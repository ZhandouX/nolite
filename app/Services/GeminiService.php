<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Produk;

class GeminiService
{
    public function query($message)
    {
        try {
            $messageTrim = trim($message);

            // 1️⃣ Ambil keyword dari pertanyaan user
            $keywords = preg_split('/\s+/', strtolower($messageTrim));
            $keywords = array_filter($keywords, fn($w) => strlen($w) > 2);

            // 2️⃣ Ambil filter harga jika ada (contoh: "di bawah 100000")
            preg_match('/di bawah (\d+)/', strtolower($messageTrim), $hargaMatch);
            $maxHarga = $hargaMatch[1] ?? null;

            // 3️⃣ Ambil filter warna & ukuran jika disebut
            preg_match_all('/(biru|merah|hitam|putih|kuning|hijau)/i', $messageTrim, $warnaMatch);
            $warnaFilter = $warnaMatch[0] ?? [];

            preg_match_all('/\b(S|M|L|XL|XXL|XXXL)\b/i', $messageTrim, $ukuranMatch);
            $ukuranFilter = $ukuranMatch[0] ?? [];

            // 4️⃣ Query produk dari database
            $produkList = Produk::with('fotos')
                ->when(count($keywords) > 0, function ($q) use ($keywords) {
                    $q->where(function ($q2) use ($keywords) {
                        foreach ($keywords as $word) {
                            $q2->orWhere('nama_produk', 'ILIKE', "%{$word}%")
                               ->orWhere('deskripsi', 'ILIKE', "%{$word}%");
                        }
                    });
                })
                ->when($maxHarga, fn($q) => $q->where('harga', '<=', $maxHarga))
                ->get();

            // 5️⃣ Filter warna & ukuran
            $produkList = $produkList->filter(function ($p) use ($warnaFilter, $ukuranFilter) {
                $warna = is_array($p->warna) ? $p->warna : [];
                $ukuran = is_array($p->ukuran) ? $p->ukuran : [];

                $warnaOk = empty($warnaFilter) || count(array_intersect(
                    array_map('strtolower', $warna),
                    array_map('strtolower', $warnaFilter)
                )) > 0;

                $ukuranOk = empty($ukuranFilter) || count(array_intersect(
                    array_map('strtoupper', $ukuran),
                    array_map('strtoupper', $ukuranFilter)
                )) > 0;

                return $warnaOk && $ukuranOk;
            });

            // 6️⃣ Siapkan data produk untuk kartu UI
            $produkForCards = [];
            $context = "Kamu adalah chatbot produk e-commerce Nolite Aspicience.\n";
            $context .= "Jawablah pertanyaan pengguna dengan bahasa Indonesia natural. ";
            $context .= "Sebutkan produk dalam bullet point jika tersedia, nama, warna, ukuran, dan harga.\n\n";

            if ($produkList->isNotEmpty()) {
                foreach ($produkList as $produk) {
                    $warna = is_array($produk->warna) ? $produk->warna : [];
                    $ukuran = is_array($produk->ukuran) ? $produk->ukuran : [];

                    $nama = $produk->nama_produk;
                    $deskripsi = $produk->deskripsi;
                    $harga = is_numeric($produk->harga)
                        ? 'IDR ' . number_format($produk->harga, 0, ',', '.')
                        : $produk->harga;

                    $context .= "- {$nama}, Warna: (" . implode(', ', $warna) . "), Ukuran: (" . implode(', ', $ukuran) . "), Harga: {$harga}\n";

                    $foto = $produk->fotos->first()->foto ?? null;
                    $foto = $foto ? asset('storage/' . $foto) : asset('assets/images/no-image.png');

                    $produkForCards[] = [
                        'id' => $produk->id,
                        'nama_produk' => $nama,
                        'warna' => implode(', ', $warna),
                        'ukuran' => implode(', ', $ukuran),
                        'harga' => $harga,
                        'deskripsi' => $deskripsi,
                        'foto' => $foto
                    ];
                }
            }

            // 7️⃣ Siapkan prompt ke Gemini API
            $prompt = $context . "\nPertanyaan pengguna: " . $messageTrim;

            // 8️⃣ Kirim request ke Gemini
            $url = 'https://generativelanguage.googleapis.com/v1/models/' . env('GEMINI_MODEL') . ':generateContent?key=' . env('GEMINI_API_KEY');

            Log::info('Gemini Request', ['url' => $url, 'prompt' => $prompt]);

            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]);

            Log::info('Gemini Raw Response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->failed()) {
                return [
                    'reply' => "Terjadi kesalahan koneksi ke server. Kode: " . $response->status(),
                    'produk_list' => $produkForCards
                ];
            }

            $result = $response->json();
            $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Tidak ada jawaban dari AI.";

            return [
                'reply' => trim($reply),
                'produk_list' => $produkForCards
            ];

        } catch (\Exception $e) {
            Log::error('Error di GeminiService: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return [
                'reply' => "Terjadi error di server: " . $e->getMessage(),
                'produk_list' => []
            ];
        }
    }
}

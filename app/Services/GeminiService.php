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
            // Ambil keyword dari pertanyaan user
            $keywords = preg_split('/\s+/', strtolower($message));
            $keywords = array_filter($keywords, fn($w) => strlen($w) > 2);

            // Ambil filter harga jika ada
            preg_match('/di bawah (\d+)/', strtolower($message), $hargaMatch);
            $maxHarga = $hargaMatch[1] ?? null;

            // Ambil warna dan ukuran jika disebut
            preg_match_all('/(biru|merah|hitam|putih|kuning|hijau)/i', $message, $warnaMatch);
            $warnaFilter = $warnaMatch[0] ?? [];

            preg_match_all('/(S|M|L|XL|XXL|XXXL)/i', $message, $ukuranMatch);
            $ukuranFilter = $ukuranMatch[0] ?? [];

            // Query produk
            $produkList = Produk::with('fotos')
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->orWhere('nama_produk', 'ILIKE', "%{$word}%")
                            ->orWhere('deskripsi', 'ILIKE', "%{$word}%");
                    }
                })
                ->when($maxHarga, fn($q) => $q->where('harga', '<=', $maxHarga))
                ->get();

            // Filter warna dan ukuran secara manual
            $produkList = $produkList->filter(function ($p) use ($warnaFilter, $ukuranFilter) {
                $warna = is_array($p->warna) ? $p->warna : [$p->warna];
                $ukuran = is_array($p->ukuran) ? $p->ukuran : [$p->ukuran];

                $warnaOk = empty($warnaFilter) || count(array_intersect(array_map('strtolower', $warna), array_map('strtolower', $warnaFilter))) > 0;
                $ukuranOk = empty($ukuranFilter) || count(array_intersect(array_map('strtoupper', $ukuran), array_map('strtoupper', $ukuranFilter))) > 0;

                return $warnaOk && $ukuranOk;
            });

            // Build context untuk AI
            $context = "Kamu adalah chatbot produk e-commerce Nolite Aspicience.\n";
            $context .= "Jawablah pertanyaan pengguna hanya dengan format natural: Sebutkan produk yang sesuai dalam bullet point, sebutkan nama, warna, ukuran, dan harga.\n\n";

            $produkForCards = [];

            foreach ($produkList as $produk) {
                $nama = $produk->nama_produk;
                $warna = is_array($produk->warna) ? implode(', ', $produk->warna) : $produk->warna;
                $ukuran = is_array($produk->ukuran) ? implode(', ', $produk->ukuran) : $produk->ukuran;
                $deskripsi = $produk->deskripsi;
                $harga = is_numeric($produk->harga) ? 'IDR ' . number_format($produk->harga, 0, ',', '.') : $produk->harga;

                $context .= "- {$nama}, Warna: ({$warna}), Ukuran: ({$ukuran}), Harga: {$harga}\n";

                $foto = $produk->fotos->first()->foto ?? null;
                $foto = $foto ? asset('storage/' . $foto) : asset('assets/images/no-image.png');

                $produkForCards[] = [
                    'id' => $produk->id,
                    'nama_produk' => $nama,
                    'warna' => $warna,
                    'ukuran' => $ukuran,
                    'harga' => $harga,
                    'deskripsi' => $deskripsi,
                    'foto' => $foto
                ];
            }

            $prompt = $context . "\nPertanyaan pengguna: " . $message;

            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post(
                    'https://generativelanguage.googleapis.com/v1/models/' . env('GEMINI_MODEL') . ':generateContent?key=' . env('GEMINI_API_KEY'),
                    [
                        'contents' => [
                            ['parts' => [['text' => $prompt]]]
                        ]
                    ]
                );

            if ($response->failed()) {
                Log::error('Gagal koneksi ke Gemini API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [
                    'reply' => "Gagal koneksi ke Gemini API. Kode: " . $response->status(),
                    'produk_list' => []
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

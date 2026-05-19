<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukCustomerController extends Controller
{
    /**
     * 🔥 SEARCH PRODUK (POSTGRES FULL TEXT SEARCH)
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // ==============================
        // 🔥 SINONIM
        // ==============================
        $map = [

            // =========================
            // KAOS / TSHIRT
            // =========================
            'kaos'         => 'tee',
            'kaosnya'      => 'tee',
            'kaosan'       => 'tee',
            'kaoz'         => 'tee',
            'kaoss'        => 'tee',
            'kaso'         => 'tee',
            'koas'         => 'tee',
            'kos'          => 'tee',
            'koss'         => 'tee',
            'kass'         => 'tee',

            'tshirt'       => 'tee',
            'tshrit'       => 'tee',
            'tshrt'        => 'tee',
            't-shrit'      => 'tee',
            't-shrt'       => 'tee',
            'tshirtt'      => 'tee',
            'tshirr'       => 'tee',
            't-shirr'      => 'tee',
            't-shirt'      => 'tee',
            'teeshirt'     => 'tee',
            'tee'          => 'tee',
            'tees'         => 'tee',

            'shirt'        => 'tee',
            'shrit'        => 'tee',
            'shrt'         => 'tee',
            'sirt'         => 'tee',
            'sheert'       => 'tee',

            'baju'         => 'tee',
            'bajuu'        => 'tee',
            'bju'          => 'tee',
            'bjju'         => 'tee',
            'bajug'        => 'tee',

            'pakaian'      => 'tee',
            'pkian'        => 'tee',
            'pakayan'      => 'tee',

            'atasan'       => 'tee',
            'atasn'        => 'tee',

            // =========================
            // BRAND
            // =========================
            'nolite'       => 'aspiciens',
            'nolte'        => 'nolite',
            'nolitte'      => 'nolite',
            'nolit'        => 'nolite',
            'noliet'       => 'nolite',
            'noilte'       => 'nolite',
            'nolitr'       => 'nolite',
            'nolitee'      => 'nolite',
            'nlite'        => 'nolite',
            'nlt'          => 'nolite',
            'noliteee'     => 'nolite',

            'aspiciens'    => 'nolite',
            'aspicien'     => 'nolite',
            'aspicens'     => 'nolite',
            'aspicience'   => 'nolite',
            'aspiciencee'  => 'nolite',
            'aspiciens'    => 'nolite',
            'aspicins'     => 'nolite',

            'na'           => 'nolite',

            // =========================
            // WARNA
            // =========================
            'hitam'        => 'black',
            'itam'         => 'black',
            'htam'         => 'black',
            'itammm'       => 'black',
            'hitm'         => 'black',
            'hitammm'      => 'black',
            'black'        => 'black',
            'blck'         => 'black',
            'blk'          => 'black',

            'putih'        => 'white',
            'ptih'         => 'white',
            'puth'         => 'white',
            'putii'        => 'white',
            'white'        => 'white',
            'wite'         => 'white',
            'whte'         => 'white',

            'merah'        => 'red',
            'mrah'         => 'red',
            'merh'         => 'red',
            'reed'         => 'red',
            'red'          => 'red',

            'biru'         => 'blue',
            'biruu'        => 'blue',
            'bru'          => 'blue',
            'blue'         => 'blue',
            'bleu'         => 'blue',

            'hijau'        => 'green',
            'ijo'          => 'green',
            'hjau'         => 'green',
            'green'        => 'green',

            'kuning'       => 'yellow',
            'kning'        => 'yellow',
            'yellow'       => 'yellow',

            'abu'          => 'grey',
            'abuabu'       => 'grey',
            'abu-abu'      => 'grey',
            'abuu'         => 'grey',
            'gray'         => 'grey',
            'grey'         => 'grey',

            // =========================
            // MODEL / FIT
            // =========================
            'oversize'     => 'oversized',
            'oversized'    => 'oversized',
            'oversice'     => 'oversized',
            'oversz'       => 'oversized',
            'ovrsize'      => 'oversized',
            'oversizedd'   => 'oversized',
            'oversisee'    => 'oversized',
            'ovsize'       => 'oversized',
            'ovrsz'        => 'oversized',

            'longgar'      => 'oversized',
            'longer'       => 'oversized',
            'loggar'       => 'oversized',

            'baggy'        => 'oversized',
            'bagi'         => 'oversized',

            'loose'        => 'oversized',
            'lose'         => 'oversized',

            'fit'          => 'oversized',

            // =========================
            // UKURAN
            // =========================
            'small'        => 's',
            'smal'         => 's',
            'smaal'        => 's',

            'medium'       => 'm',
            'medum'        => 'm',
            'medim'        => 'm',
            'med'          => 'm',

            'large'        => 'l',
            'lage'         => 'l',
            'larg'         => 'l',
            'lrage'        => 'l',

            'extra large'  => 'xl',
            'xtra large'   => 'xl',
            'xl'           => 'xl',
            'xll'          => 'xl',
            'xxl'          => 'xl',

            'besar'        => 'xl',
            'bessar'       => 'xl',
            'gede'         => 'xl',

            'kecil'        => 's',
            'kecill'       => 's',

            // =========================
            // STYLE
            // =========================
            'streetwear'   => 'oversized',
            'stretwear'    => 'oversized',
            'street'       => 'oversized',
            'stret'        => 'oversized',

            'casual'       => 'tee',
            'casul'        => 'tee',

            'distro'       => 'tee',
            'distroo'      => 'tee',

            'fashion'      => 'tee',
            'fasion'       => 'tee',

            // =========================
            // BAHAN
            // =========================
            'cotton'       => 'cotton',
            'coton'        => 'cotton',
            'cotonns'      => 'cotton',

            'katun'        => 'cotton',
            'katunn'       => 'cotton',

            'premium'      => 'heavyweight',
            'premum'       => 'heavyweight',
            'premiun'      => 'heavyweight',

            'tebal'        => 'heavyweight',
            'tebel'        => 'heavyweight',

            'soft'         => 'cotton',

            // =========================
            // DESAIN
            // =========================
            'grafis'       => 'graphic',
            'grafik'       => 'graphic',
            'graphic'      => 'graphic',
            'graphik'      => 'graphic',

            'anime'        => 'graphic',
            'anim'         => 'graphic',

            'dark'         => 'black',
            'drak'         => 'black',
            'gelap'        => 'black',

            'minimalis'    => 'simple',
            'minimalist'   => 'simple',
            'simple'       => 'simple',
        ];

        $words = explode(' ', strtolower($query));
        $expanded = [];

        foreach ($words as $word) {

            $expanded[] = $word;

            if (isset($map[$word])) {
                $expanded[] = $map[$word];
            }
        }

        // kaos hitam -> kaos & t-shirt & hitam
        $tsQuery = implode(' | ', $expanded);

        // ==============================
        // 🔥 FULL TEXT SEARCH
        // ==============================
        $produk = Produk::with([
            'fotos' => fn($q) => $q->orderBy('id', 'asc')->limit(1)
        ])

            ->whereRaw(
                "search_vector @@ to_tsquery('indonesian', ?)",
                [$tsQuery]
            )

            // ranking relevansi
            ->orderByRaw(
                "ts_rank(search_vector, to_tsquery('indonesian', ?)) DESC",
                [$tsQuery]
            )

            ->limit(20)
            ->get();

        // ==============================
        // 🔥 FORMAT RESPONSE
        // ==============================
        $results = $produk->map(function ($item) {

            $hargaAsli = (float) $item->harga;
            $diskon = (float) ($item->diskon ?? 0);

            $hargaDiskon = $diskon > 0
                ? $hargaAsli - ($hargaAsli * $diskon / 100)
                : $hargaAsli;

            return [
                'id' => $item->id,
                'nama_produk' => $item->nama_produk,
                'harga' => $hargaAsli,
                'harga_diskon' => $hargaDiskon,
                'diskon' => $diskon,
                'jumlah' => $item->jumlah,

                'kategori_id' => $item->kategori_id ?? '-',

                'foto' => $item->fotos->isNotEmpty()
                    ? asset('storage/' . $item->fotos->first()->foto)
                    : asset('assets/images/no-image.png'),

                // JSON aman
                'warna' => is_array($item->warna)
                    ? implode(', ', $item->warna)
                    : $item->warna,

                'ukuran' => is_array($item->ukuran)
                    ? implode(', ', $item->ukuran)
                    : $item->ukuran,
            ];
        });

        return response()->json($results);
    }

    /**
     * 🔥 SEARCH DENGAN PAGINATION
     */
    public function searchWithPagination(Request $request)
    {
        $query = trim($request->input('q', ''));
        $perPage = $request->input('per_page', 12);

        if (strlen($query) < 2) {
            return response()->json([
                'data' => [],
                'total' => 0,
                'current_page' => 1,
                'last_page' => 1
            ]);
        }

        $tsQuery = str_replace(' ', ' & ', strtolower($query));

        $produk = Produk::with([
            'fotos' => fn($q) => $q->orderBy('id', 'asc')->limit(1)
        ])

            ->whereRaw(
                "search_vector @@ to_tsquery('indonesian', ?)",
                [$tsQuery]
            )

            ->orderByRaw(
                "ts_rank(search_vector, to_tsquery('indonesian', ?)) DESC",
                [$tsQuery]
            )

            ->paginate($perPage);

        return response()->json([
            'data' => $produk->map(function ($item) {

                return [
                    'id' => $item->id,
                    'nama_produk' => $item->nama_produk,
                    'harga' => $item->harga,
                    'diskon' => $item->diskon ?? 0,
                    'jumlah' => $item->jumlah,

                    'kategori' => $item->kategori->nama_kategori ?? '-',

                    'foto' => $item->fotos->isNotEmpty()
                        ? asset('storage/' . $item->fotos->first()->foto)
                        : asset('assets/images/no-image.png'),

                    'warna' => is_array($item->warna)
                        ? implode(', ', $item->warna)
                        : $item->warna,

                    'ukuran' => is_array($item->ukuran)
                        ? implode(', ', $item->ukuran)
                        : $item->ukuran,
                ];
            }),

            'total' => $produk->total(),
            'current_page' => $produk->currentPage(),
            'last_page' => $produk->lastPage(),
            'per_page' => $produk->perPage(),
        ]);
    }

    /**
     * 🔥 MODAL PRODUK
     */
    public function getProductModals($id)
    {
        $item = Produk::with('fotos')->findOrFail($id);

        return view('layouts.partials_user.modal-beli', compact('item'))->render()
            . view('layouts.partials_user.modal-cart', compact('item'))->render();
    }

    /**
     * 🔥 HALAMAN KATEGORI
     */
    public function kategori($kategoriId, Request $request)
    {
        $kategori = Kategori::findOrFail($kategoriId);

        $query = Produk::where('kategori_id', $kategori->id)
            ->withStatistik();

        if ($request->has('sort')) {

            switch ($request->sort) {

                case 'harga_terendah':
                    $query->orderBy('harga', 'asc');
                    break;

                case 'harga_tertinggi':
                    $query->orderBy('harga', 'desc');
                    break;

                case 'nama_az':
                    $query->orderBy('nama_produk', 'asc');
                    break;

                case 'nama_za':
                    $query->orderBy('nama_produk', 'desc');
                    break;
            }
        }

        $produks = $query->get();

        return view(
            'customer.kategori-produk',
            compact('kategori', 'produks')
        );
    }
}

<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LokasiController extends Controller
{
    public $provinsiKota = [];

    public function __construct()
    {
        $this->provinsiKota = [
            'Aceh' => [
                'Aceh Barat',
                'Aceh Barat Daya',
                'Aceh Besar',
                'Aceh Jaya',
                'Aceh Selatan',
                'Aceh Singkil',
                'Aceh Tamiang',
                'Aceh Tengah',
                'Aceh Tenggara',
                'Aceh Timur',
                'Aceh Utara',
                'Banda Aceh',
                'Gayo Lues',
                'Langsa',
                'Lhokseumawe',
                'Nagan Raya',
                'Pidie',
                'Pidie Jaya',
                'Sabang',
                'Simeulue',
                'Subulussalam'
            ],

            'Bali' => [
                'Badung',
                'Bangli',
                'Buleleng',
                'Denpasar',
                'Gianyar',
                'Jembrana',
                'Karangasem',
                'Klungkung',
                'Tabanan'
            ],

            'Bangka Belitung' => [
                'Bangka',
                'Bangka Barat',
                'Bangka Selatan',
                'Bangka Tengah',
                'Belitung',
                'Belitung Timur',
                'Pangkal Pinang'
            ],

            'Banten' => [
                'Cilegon',
                'Lebak',
                'Pandeglang',
                'Serang',
                'Tangerang',
                'Tangerang Selatan'
            ],

            'Bengkulu' => [
                'Bengkulu',
                'Bengkulu Selatan',
                'Bengkulu Utara',
                'Kaur',
                'Kepahiang',
                'Lebong',
                'Mukomuko',
                'Rejang Lebong',
                'Seluma'
            ],

            'DI Yogyakarta' => [
                'Bantul',
                'Gunungkidul',
                'Kulon Progo',
                'Sleman',
                'Yogyakarta'
            ],

            'DKI Jakarta' => [
                'Jakarta Barat',
                'Jakarta Pusat',
                'Jakarta Selatan',
                'Jakarta Timur',
                'Jakarta Utara',
                'Kepulauan Seribu'
            ],

            'Gorontalo' => [
                'Boalemo',
                'Bone Bolango',
                'Gorontalo',
                'Gorontalo Utara',
                'Pohuwato'
            ],

            'Jambi' => [
                'Batanghari',
                'Bungo',
                'Jambi',
                'Kerinci',
                'Merangin',
                'Muaro Jambi',
                'Sarolangun',
                'Sungai Penuh',
                'Tanjung Jabung Barat',
                'Tanjung Jabung Timur',
                'Tebo'
            ],

            'Jawa Barat' => [
                'Banjar',
                'Bandung',
                'Bandung Barat',
                'Bekasi',
                'Bogor',
                'Ciamis',
                'Cianjur',
                'Cirebon',
                'Depok',
                'Garut',
                'Indramayu',
                'Karawang',
                'Kuningan',
                'Majalengka',
                'Purwakarta',
                'Subang',
                'Sukabumi',
                'Sumedang',
                'Tasikmalaya'
            ],

            'Jawa Tengah' => [
                'Batang',
                'Blora',
                'Boyolali',
                'Brebes',
                'Cilacap',
                'Demak',
                'Grobogan',
                'Jepara',
                'Karanganyar',
                'Kebumen',
                'Kendal',
                'Klaten',
                'Kudus',
                'Magelang',
                'Pati',
                'Pekalongan',
                'Pemalang',
                'Purbalingga',
                'Purworejo',
                'Rembang',
                'Salatiga',
                'Semarang',
                'Sragen',
                'Sukoharjo',
                'Surakarta',
                'Tegal',
                'Temanggung',
                'Wonogiri',
                'Wonosobo'
            ],

            'Jawa Timur' => [
                'Banyuwangi',
                'Blitar',
                'Bojonegoro',
                'Bondowoso',
                'Gresik',
                'Jember',
                'Jombang',
                'Kediri',
                'Lamongan',
                'Lumajang',
                'Madiun',
                'Magetan',
                'Malang',
                'Mojokerto',
                'Nganjuk',
                'Ngawi',
                'Pacitan',
                'Pamekasan',
                'Pasuruan',
                'Ponorogo',
                'Probolinggo',
                'Sampang',
                'Sidoarjo',
                'Situbondo',
                'Sumenep',
                'Surabaya',
                'Trenggalek',
                'Tuban',
                'Tulungagung'
            ],

            'Kalimantan Barat' => [
                'Bengkayang',
                'Kapuas Hulu',
                'Kayong Utara',
                'Ketapang',
                'Kubu Raya',
                'Landak',
                'Melawi',
                'Mempawah',
                'Pontianak',
                'Sambas',
                'Sanggau',
                'Sekadau',
                'Singkawang',
                'Sintang'
            ],

            'Kalimantan Selatan' => [
                'Balangan',
                'Banjar',
                'Banjarbaru',
                'Banjarmasin',
                'Barito Kuala',
                'Hulu Sungai Selatan',
                'Hulu Sungai Tengah',
                'Hulu Sungai Utara',
                'Kotabaru',
                'Tabalong',
                'Tanah Bumbu',
                'Tanah Laut',
                'Tapin'
            ],

            'Kalimantan Tengah' => [
                'Barito Selatan',
                'Barito Timur',
                'Barito Utara',
                'Gunung Mas',
                'Kapuas',
                'Katingan',
                'Kotawaringin Barat',
                'Kotawaringin Timur',
                'Lamandau',
                'Murung Raya',
                'Palangka Raya',
                'Pulang Pisau',
                'Sampit',
                'Seruyan',
                'Sukamara'
            ],

            'Kalimantan Timur' => [
                'Balikpapan',
                'Berau',
                'Kutai Barat',
                'Kutai Kartanegara',
                'Kutai Timur',
                'Mahakam Ulu',
                'Paser',
                'Penajam Paser Utara',
                'Samarinda'
            ],

            'Kalimantan Utara' => [
                'Bulungan',
                'Malinau',
                'Nunukan',
                'Tana Tidung',
                'Tanjung Selor'
            ],

            'Kepulauan Riau' => [
                'Batam',
                'Bintan',
                'Karimun',
                'Kepulauan Anambas',
                'Lingga',
                'Natuna',
                'Tanjung Pinang'
            ],

            'Lampung' => [
                'Bandar Lampung',
                'Lampung Barat',
                'Lampung Selatan',
                'Lampung Tengah',
                'Lampung Timur',
                'Lampung Utara',
                'Mesuji',
                'Metro',
                'Pesawaran',
                'Pesisir Barat',
                'Pringsewu',
                'Tanggamus',
                'Tulang Bawang',
                'Tulang Bawang Barat',
                'Way Kanan'
            ],

            'Maluku' => [
                'Ambon',
                'Buru',
                'Buru Selatan',
                'Maluku Barat Daya',
                'Maluku Tengah',
                'Maluku Tenggara',
                'Maluku Tenggara Barat',
                'Seram Bagian Barat',
                'Seram Bagian Timur',
                'Tual'
            ],

            'Maluku Utara' => [
                'Halmahera Barat',
                'Halmahera Selatan',
                'Halmahera Tengah',
                'Halmahera Timur',
                'Halmahera Utara',
                'Pulau Morotai',
                'Pulau Taliabu',
                'Ternate',
                'Tidore'
            ],

            'Nusa Tenggara Barat' => [
                'Bima',
                'Dompu',
                'Lombok Barat',
                'Lombok Tengah',
                'Lombok Timur',
                'Lombok Utara',
                'Mataram',
                'Sumbawa'
            ],

            'Nusa Tenggara Timur' => [
                'Alor',
                'Belu',
                'Ende',
                'Flores Barat',
                'Flores Timur',
                'Kupang',
                'Lembata',
                'Manggarai',
                'Manggarai Barat',
                'Manggarai Timur',
                'Nagekeo',
                'Ngada',
                'Rote Ndao',
                'Sabu Raijua',
                'Sikka',
                'Sumba Barat',
                'Sumba Timur',
                'Timor Tengah Selatan',
                'Timor Tengah Utara'
            ],

            'Papua' => [
                'Asmat',
                'Biak Numfor',
                'Boven Digoel',
                'Jayapura',
                'Jayapura Selatan',
                'Jayapura Utara',
                'Keerom',
                'Kepulauan Yapen',
                'Mamberamo Raya',
                'Merauke',
                'Mimika',
                'Nabire',
                'Paniai',
                'Pegunungan Bintang',
                'Puncak',
                'Puncak Jaya',
                'Supiori',
                'Waropen',
                'Yahukimo',
                'Yalimo'
            ],

            'Papua Barat' => [
                'Fakfak',
                'Kaimana',
                'Manokwari',
                'Maybrat',
                'Raja Ampat',
                'Sorong',
                'South Manokwari',
                'Tambrauw',
                'Teluk Bintuni',
                'Teluk Wondama'
            ],

            'Papua Pegunungan' => [
                'Jayawijaya',
                'Lanny Jaya',
                'Mamberamo Tengah',
                'Nabire',
                'Nduga',
                'Pegunungan Bintang',
                'Tolikara',
                'Yalimo'
            ],

            'Papua Selatan' => [
                'Asmat',
                'Boven Digoel',
                'Mappi',
                'Merauke',
                'Mimika'
            ],

            'Papua Tengah' => [
                'Deiyai',
                'Dogiyai',
                'Intan Jaya',
                'Mamberamo Tengah',
                'Nabire',
                'Paniai',
                'Puncak',
                'Puncak Jaya'
            ],

            'Riau' => [
                'Bengkalis',
                'Dumai',
                'Indragiri Hilir',
                'Indragiri Hulu',
                'Kampar',
                'Kepulauan Meranti',
                'Kuantan Singingi',
                'Pelalawan',
                'Pekanbaru',
                'Rokan Hilir',
                'Rokan Hulu',
                'Siak'
            ],

            'Sulawesi Barat' => [
                'Majene',
                'Mamasa',
                'Mamuju',
                'Mamuju Tengah',
                'Polewali Mandar'
            ],

            'Sulawesi Selatan' => [
                'Barru',
                'Bone',
                'Bulukumba',
                'Bantaeng',
                'Enrekang',
                'Gowa',
                'Jeneponto',
                'Luwu',
                'Luwu Timur',
                'Luwu Utara',
                'Makassar',
                'Maros',
                'Pangkajene Kepulauan',
                'Parepare',
                'Pinrang',
                'Sidenreng Rappang',
                'Sinjai',
                'Soppeng',
                'Takalar',
                'Tana Toraja',
                'Toraja Utara',
                'Wajo'
            ],

            'Sulawesi Tengah' => [
                'Banggai',
                'Banggai Kepulauan',
                'Buol',
                'Donggala',
                'Morowali',
                'Palu',
                'Parigi Moutong',
                'Poso',
                'Sigi',
                'Tojo Una-Una',
                'Tolitoli'
            ],

            'Sulawesi Tenggara' => [
                'Bombana',
                'Buton',
                'Buton Tengah',
                'Buton Utara',
                'Kendari',
                'Kolaka',
                'Kolaka Utara',
                'Konawe',
                'Konawe Kepulauan',
                'Konawe Selatan',
                'Konawe Utara',
                'Muna',
                'Wakatobi'
            ],

            'Sulawesi Utara' => [
                'Bitung',
                'Bolaang Mongondow',
                'Kotamobagu',
                'Manado',
                'Minahasa',
                'Minahasa Selatan',
                'Minahasa Tenggara',
                'Minahasa Utara',
                'Sangihe',
                'Siau Tagulandang Biaro',
                'Talaud',
                'Tomohon'
            ],

            'Sumatera Barat' => [
                'Agam',
                'Bukittinggi',
                'Dharmasraya',
                'Kepulauan Mentawai',
                'Lima Puluh Kota',
                'Padang',
                'Padang Pariaman',
                'Pariaman',
                'Pasaman',
                'Pasaman Barat',
                'Payakumbuh',
                'Sijunjung',
                'Solok',
                'Solok Selatan',
                'Tanah Datar'
            ],

            'Sumatera Selatan' => [
                'Empat Lawang',
                'Lahat',
                'Musi Banyuasin',
                'Musi Rawas',
                'Musi Rawas Utara',
                'Ogan Ilir',
                'Ogan Komering Ilir',
                'Ogan Komering Ulu',
                'Ogan Komering Ulu Selatan',
                'Ogan Komering Ulu Timur',
                'Pagar Alam',
                'Palembang',
                'Penukal Abab Lematang Ilir',
                'Prabumulih'
            ],

            'Sumatera Utara' => [
                'Binjai',
                'Dairi',
                'Gunungsitoli',
                'Humbang Hasundutan',
                'Karo',
                'Labuhanbatu',
                'Labuhanbatu Selatan',
                'Labuhanbatu Utara',
                'Langkat',
                'Mandailing Natal',
                'Medan',
                'Nias',
                'Nias Selatan',
                'Nias Utara',
                'Padang Lawas',
                'Padang Lawas Utara',
                'Pakpak Bharat',
                'Pematangsiantar',
                'Serdang Bedagai',
                'Sibolga',
                'Simalungun',
                'Tanjungbalai',
                'Tapanuli Selatan',
                'Tapanuli Tengah',
                'Tapanuli Utara',
                'Tebing Tinggi',
                'Toba Samosir'
            ]
        ];

        // Urutkan provinsi & kota
        ksort($this->provinsiKota);
        foreach ($this->provinsiKota as &$kotaList) {
            sort($kotaList);
        }
    }

    public function form()
    {
        $provinsiList = array_keys($this->provinsiKota);
        return view('lokasi.form', compact('provinsiList'));
    }

    public function getKota(Request $request)
    {
        $provinsi = $request->get('provinsi');
        $kotaList = $this->provinsiKota[$provinsi] ?? [];
        sort($kotaList); // urutkan juga saat fetch
        return response()->json($kotaList);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getKota($provinsi)
    {
        $kotaList = [
            'Aceh' => ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Sabang', 'Subulussalam', 'Aceh Barat', 'Aceh Barat Daya', 'Aceh Besar', 'Aceh Jaya', 'Aceh Selatan', 'Aceh Singkil', 'Aceh Tamiang', 'Aceh Tengah', 'Aceh Tenggara', 'Aceh Timur', 'Aceh Utara', 'Gayo Lues', 'Nagan Raya', 'Pidie', 'Pidie Jaya', 'Simeulue'],
            'Sumatera Utara' => ['Medan', 'Binjai', 'Tebing Tinggi', 'Pematangsiantar', 'Tanjungbalai', 'Sibolga', 'Gunungsitoli', 'Humbang Hasundutan', 'Karo', 'Dairi', 'Tapanuli Selatan', 'Tapanuli Utara', 'Tapanuli Tengah', 'Nias', 'Nias Selatan', 'Nias Utara', 'Pakpak Bharat', 'Simalungun', 'Serdang Bedagai', 'Langkat', 'Labuhanbatu', 'Labuhanbatu Selatan', 'Labuhanbatu Utara', 'Humbang Hasundutan', 'Mandailing Natal', 'Padang Lawas', 'Padang Lawas Utara', 'Toba Samosir'],
            'Sumatera Barat' => ['Padang', 'Bukittinggi', 'Payakumbuh', 'Solok', 'Agam', 'Dharmasraya', 'Kepulauan Mentawai', 'Lima Puluh Kota', 'Pasaman', 'Pasaman Barat', 'Padang Pariaman', 'Pariaman', 'Sijunjung', 'Solok Selatan', 'Tanah Datar'],
            'Riau' => ['Pekanbaru', 'Dumai', 'Bengkalis', 'Indragiri Hilir', 'Indragiri Hulu', 'Kampar', 'Kepulauan Meranti', 'Kuantan Singingi', 'Pelalawan', 'Rokan Hilir', 'Rokan Hulu', 'Siak'],
            'Kepulauan Riau' => ['Batam', 'Tanjung Pinang', 'Bintan', 'Karimun', 'Kepulauan Anambas', 'Lingga', 'Natuna'],
            'Jambi' => ['Jambi', 'Sungai Penuh', 'Batanghari', 'Bungo', 'Kerinci', 'Merangin', 'Muaro Jambi', 'Sarolangun', 'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tebo'],
            'Sumatera Selatan' => ['Palembang', 'Prabumulih', 'Pagar Alam', 'Lahat', 'Musi Banyuasin', 'Musi Rawas', 'Musi Rawas Utara', 'Ogan Ilir', 'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Timur', 'Empat Lawang', 'Penukal Abab Lematang Ilir'],
            'Bangka Belitung' => ['Pangkal Pinang', 'Bangka', 'Bangka Barat', 'Bangka Selatan', 'Bangka Tengah', 'Belitung', 'Belitung Timur'],
            'Bengkulu' => ['Bengkulu', 'Bengkulu Selatan', 'Bengkulu Utara', 'Kaur', 'Kepahiang', 'Lebong', 'Mukomuko', 'Rejang Lebong', 'Seluma'],
            'Lampung' => ['Bandar Lampung', 'Metro', 'Lampung Barat', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara', 'Mesuji', 'Pesawaran', 'Pringsewu', 'Tanggamus', 'Tulang Bawang', 'Tulang Bawang Barat', 'Way Kanan', 'Pesisir Barat'],
            'DKI Jakarta' => ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur', 'Kepulauan Seribu'],
            'Banten' => ['Serang', 'Cilegon', 'Tangerang', 'Tangerang Selatan', 'Pandeglang', 'Lebak', 'Tangerang'],
            'Jawa Barat' => ['Bandung', 'Bekasi', 'Bogor', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya', 'Bandung Barat', 'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka', 'Purwakarta', 'Subang', 'Sumedang', 'Ciamis', 'Cianjur', 'Banjar', 'Bekasi', 'Bogor'],
            'Jawa Tengah' => ['Semarang', 'Surakarta', 'Magelang', 'Salatiga', 'Pekalongan', 'Tegal', 'Batang', 'Blora', 'Boyolali', 'Brebes', 'Cilacap', 'Demak', 'Grobogan', 'Jepara', 'Karanganyar', 'Kebumen', 'Kendal', 'Klaten', 'Kudus', 'Pati', 'Pekalongan', 'Pemalang', 'Purbalingga', 'Purworejo', 'Rembang', 'Semarang', 'Sragen', 'Sukoharjo', 'Tegal', 'Temanggung', 'Wonogiri', 'Wonosobo'],
            'DI Yogyakarta' => ['Yogyakarta', 'Bantul', 'Gunungkidul', 'Kulon Progo', 'Sleman'],
            'Jawa Timur' => ['Surabaya', 'Malang', 'Kediri', 'Blitar', 'Madiun', 'Banyuwangi', 'Bojonegoro', 'Bondowoso', 'Gresik', 'Jember', 'Jombang', 'Kediri', 'Lamongan', 'Lumajang', 'Madiun', 'Magetan', 'Malang', 'Mojokerto', 'Nganjuk', 'Ngawi', 'Pacitan', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Probolinggo', 'Sampang', 'Sidoarjo', 'Situbondo', 'Sumenep', 'Trenggalek', 'Tuban', 'Tulungagung'],
            'Bali' => ['Denpasar', 'Badung', 'Bangli', 'Buleleng', 'Gianyar', 'Jembrana', 'Karangasem', 'Klungkung', 'Tabanan'],
            'Nusa Tenggara Barat' => ['Mataram', 'Bima', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Sumbawa', 'Dompu'],
            'Nusa Tenggara Timur' => ['Kupang', 'Alor', 'Belu', 'Ende', 'Flores Timur', 'Flores Barat', 'Lembata', 'Manggarai', 'Manggarai Barat', 'Manggarai Timur', 'Ngada', 'Rote Ndao', 'Sabu Raijua', 'Sikka', 'Sumba Barat', 'Sumba Timur', 'Timor Tengah Selatan', 'Timor Tengah Utara', 'Nagekeo'],
            'Kalimantan Barat' => ['Pontianak', 'Singkawang', 'Bengkayang', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang', 'Kubu Raya', 'Landak', 'Melawi', 'Mempawah', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang'],
            'Kalimantan Tengah' => ['Palangka Raya', 'Katingan', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Lamandau', 'Murung Raya', 'Pulau Pisang', 'Sukamara', 'Seruyan', 'Barito Selatan', 'Barito Timur', 'Barito Utara', 'Gunung Mas', 'Kapuas', 'Pulang Pisau', 'Sampit'],
            'Kalimantan Selatan' => ['Banjarmasin', 'Banjar', 'Banjarbaru', 'Barito Kuala', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin', 'Balangan', 'Kotabaru'],
            'Kalimantan Timur' => ['Samarinda', 'Balikpapan', 'Berau', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Paser', 'Penajam Paser Utara', 'Mahakam Ulu'],
            'Kalimantan Utara' => ['Tanjung Selor', 'Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung'],
            'Sulawesi Utara' => ['Manado', 'Bitung', 'Bolaang Mongondow', 'Kotamobagu', 'Minahasa', 'Minahasa Selatan', 'Minahasa Utara', 'Minahasa Tenggara', 'Sangihe', 'Siau Tagulandang Biaro', 'Talaud', 'Tomohon'],
            'Gorontalo' => ['Gorontalo', 'Boalemo', 'Bone Bolango', 'Pohuwato', 'Gorontalo Utara'],
            'Sulawesi Tengah' => ['Palu', 'Banggai', 'Banggai Kepulauan', 'Buol', 'Donggala', 'Morowali', 'Parigi Moutong', 'Poso', 'Sigi', 'Tojo Una-Una', 'Tolitoli'],
            'Sulawesi Barat' => ['Mamuju', 'Majene', 'Mamasa', 'Polewali Mandar', 'Mamuju Tengah'],
            'Sulawesi Selatan' => ['Makassar', 'Parepare', 'Barru', 'Bone', 'Bulukumba', 'Bantaeng', 'Enrekang', 'Gowa', 'Jeneponto', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Maros', 'Pangkajene Kepulauan', 'Pinrang', 'Sidenreng Rappang', 'Sinjai', 'Soppeng', 'Takalar', 'Tana Toraja', 'Toraja Utara', 'Wajo'],
            'Sulawesi Tenggara' => ['Kendari', 'Bombana', 'Buton', 'Buton Utara', 'Konawe', 'Konawe Selatan', 'Konawe Utara', 'Kolaka', 'Kolaka Utara', 'Muna', 'Wakatobi', 'Konawe Kepulauan', 'Buton Tengah'],
            'Maluku' => ['Ambon', 'Tual', 'Buru', 'Seram Bagian Barat', 'Seram Bagian Timur', 'Maluku Tengah', 'Maluku Tenggara', 'Maluku Tenggara Barat', 'Maluku Barat Daya', 'Buru Selatan'],
            'Maluku Utara' => ['Ternate', 'Tidore', 'Halmahera Barat', 'Halmahera Tengah', 'Halmahera Utara', 'Halmahera Selatan', 'Halmahera Timur', 'Pulau Morotai', 'Pulau Taliabu'],
            'Papua' => ['Jayapura', 'Jayapura Selatan', 'Jayapura Utara', 'Biak Numfor', 'Yahukimo', 'Merauke', 'Mimika', 'Paniai', 'Pegunungan Bintang', 'Boven Digoel', 'Mamberamo Raya', 'Nabire', 'Puncak', 'Puncak Jaya', 'Yalimo', 'Asmat', 'Keerom', 'Kepulauan Yapen', 'Supiori', 'Waropen'],
            'Papua Barat' => ['Manokwari', 'Sorong', 'Fakfak', 'Kaimana', 'Raja Ampat', 'Teluk Bintuni', 'Teluk Wondama', 'Maybrat', 'Tambrauw', 'South Manokwari'],
            'Papua Selatan' => ['Merauke', 'Mappi', 'Asmat', 'Boven Digoel', 'Mimika', 'Boven Digoel'],
            'Papua Tengah' => ['Nabire', 'Paniai', 'Puncak Jaya', 'Puncak', 'Dogiyai', 'Deiyai', 'Intan Jaya', 'Mamberamo Tengah'],
            'Papua Pegunungan' => ['Jayawijaya', 'Lanny Jaya', 'Nabire', 'Tolikara', 'Yalimo', 'Nduga', 'Pegunungan Bintang', 'Mamberamo Tengah'],
            'Papua Barat Daya' => ['Maybrat', 'Raja Ampat', 'Sorong Selatan', 'Tambrauw', 'Fakfak', 'Kaimana'],
        ];

        return response()->json($kotaList[$provinsi] ?? []);
    }
}

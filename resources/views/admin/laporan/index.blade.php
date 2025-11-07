@extends('layouts.admin_app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4 fw-bold">📊 Manajemen Laporan Terpadu</h2>

        {{-- 🔹 Filter --}}
        <div class="card mb-4 p-3 shadow-sm">
            <form id="formFilter" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis Laporan</label>
                    <select class="form-select" id="jenis" name="jenis" required>
                        <option value="">-- Pilih Jenis Laporan --</option>
                        <option value="penjualan">💰 Penjualan</option>
                        <option value="produk">🏷️ Produk</option>
                        <option value="pengguna">👥 Pengguna</option>
                        <option value="pesanan">🚚 Pesanan</option>
                        <option value="keuangan">🧾 Keuangan</option>
                        <option value="stok">📦 Stok</option>
                        <option value="ulasan">⭐ Ulasan</option>
                        <option value="aktivitas">📈 Aktivitas Admin</option>
                    </select>
                </div>

                <div class="mb-3 d-flex gap-2">
                    <button id="btnPdf" class="btn btn-danger">📄 Ekspor PDF</button>
                    <button id="btnExcel" class="btn btn-success">📊 Ekspor Excel</button>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="mdi mdi-eye"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>

        {{-- 🔹 Grafik --}}
        <div id="chartContainer" class="card mb-4 p-4 shadow-sm" style="display:none;">
            <h5 id="chartTitle" class="mb-3 fw-bold"></h5>
            <canvas id="laporanChart" height="100"></canvas>
        </div>

        {{-- 🔹 Tabel Data --}}
        <div class="card p-4 shadow-sm">
            <h5 class="fw-bold mb-3">📄 Hasil Data</h5>
            <div id="hasilLaporan" class="table-responsive">
                <p class="text-muted">Silakan pilih jenis laporan untuk melihat hasil.</p>
            </div>
        </div>
    </div>

    {{-- 🔸 Script JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chart;

        function formatRupiah(angka) {
            if (!angka) return '-';
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function formatTanggal(tgl) {
            if (!tgl) return '-';
            const date = new Date(tgl);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }

        $('#formFilter').on('submit', function(e) {
            e.preventDefault();
            let jenis = $('#jenis').val();
            if (!jenis) return alert('⚠️ Pilih jenis laporan terlebih dahulu');

            $.ajax({
                url: "{{ route('admin.laporan.getData') }}",
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: () => {
                    $('#hasilLaporan').html('<p class="text-muted text-center">Memuat data...</p>');
                },
                success: function(res) {
                    const {
                        data,
                        chart: c
                    } = res;

                    // 🔸 Tampilkan grafik
                    if (c && c.labels && c.values) {
                        $('#chartContainer').show();
                        $('#chartTitle').text(c.title);

                        if (chart) chart.destroy();
                        const ctx = document.getElementById('laporanChart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: (jenis === 'keuangan') ? 'doughnut' : 'bar',
                            data: {
                                labels: c.labels,
                                datasets: [{
                                    label: 'Jumlah',
                                    data: c.values,
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.6)',
                                        'rgba(255, 159, 64, 0.6)',
                                        'rgba(75, 192, 192, 0.6)',
                                        'rgba(255, 99, 132, 0.6)',
                                    ],
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    }
                                },
                                scales: (jenis === 'keuangan') ? {} : {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    } else {
                        $('#chartContainer').hide();
                    }

                    // 🔸 Tabel hasil data
                    let html = '';
                    if (!data || data.length === 0) {
                        html = '<p class="text-center text-muted">Tidak ada data ditemukan.</p>';
                    } else if (Array.isArray(data)) {
                        html =
                            '<table class="table table-bordered table-striped table-hover"><thead><tr>';
                        Object.keys(data[0]).forEach(k => html +=
                            `<th>${k.replace(/_/g, ' ').toUpperCase()}</th>`);
                        html += '</tr></thead><tbody>';

                        data.forEach(row => {
                            html += '<tr>';
                            Object.entries(row).forEach(([k, v]) => {
                                if (k.includes('harga') || k.includes('subtotal') || k
                                    .includes('total'))
                                    v = formatRupiah(v);
                                else if (k.includes('created_at') || k.includes(
                                        'updated_at'))
                                    v = formatTanggal(v);
                                else if (v === null || v === undefined)
                                    v = '-';
                                html += `<td>${v}</td>`;
                            });
                            html += '</tr>';
                        });
                        html += '</tbody></table>';
                    } else if (typeof data === 'object') {
                        html = '<table class="table table-bordered"><tbody>';
                        Object.entries(data).forEach(([key, val]) => {
                            if (key.includes('harga') || key.includes('total')) val =
                                formatRupiah(val);
                            html +=
                                `<tr><th>${key.replace(/_/g, ' ').toUpperCase()}</th><td>${val}</td></tr>`;
                        });
                        html += '</tbody></table>';
                    }

                    $('#hasilLaporan').html(html);
                },
                error: function() {
                    $('#hasilLaporan').html(
                        '<p class="text-danger text-center">Terjadi kesalahan memuat data.</p>');
                    $('#chartContainer').hide();
                }
            });
        });

        // Tombol Ekspor PDF
        $('#btnPdf').on('click', function() {
            let jenis = $('#jenis').val();
            let tanggalAwal = $('#tanggal_awal').val();
            let tanggalAkhir = $('#tanggal_akhir').val();

            if (!jenis) return alert('Pilih jenis laporan terlebih dahulu');

            let url = "{{ url('admin/laporan/export-pdf') }}/" + jenis;
            url += `?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
            window.open(url, '_blank');
        });

        // Tombol Ekspor Excel
        $('#btnExcel').on('click', function() {
            let jenis = $('#jenis').val();
            let tanggalAwal = $('#tanggal_awal').val();
            let tanggalAkhir = $('#tanggal_akhir').val();

            if (!jenis) return alert('Pilih jenis laporan terlebih dahulu');

            let url = "{{ url('admin/laporan/export-excel') }}/" + jenis;
            url += `?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
            window.location.href = url;
        });
    </script>
@endsection

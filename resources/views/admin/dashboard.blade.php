@extends('layouts.app')

@section('content')
    <div class="w-full space-y-6">

        {{-- STATISTIK --}}
        @include('layouts.partials_admin.statistik_charts.statistik')

        {{-- CHART PENDAPATAN --}}
        @include('layouts.partials_admin.statistik_charts.chart')

        {{-- PESANAN TERBARU --}}
        @include('layouts.partials_admin.tables.pesanan')

        {{-- PRODUK TERLARIS --}}
        @include('layouts.partials_admin.tables.produk-terlaris_user')

    </div>
@endsection

@push('scripts')
    <script>
        window.ChartData = {
            bulanLabels: @json($bulanLabels),
            pendapatanData: @json($pendapatanData),
            penggunaData: @json($penggunaData),
        };
    </script>
    <script src="/assets/js/admin/chart.js"></script>
    <script src="/assets/js/admin/order.js"></script>
@endpush

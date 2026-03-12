@extends('layouts.app')
@section('title','Monitoring')
@section('page-title','Monitoring Ujian Saya')
@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Semua Ruang Ujian Saya</h2>

    @forelse($ruangUjians as $r)
    @php
        $total = $r->ujianSiswas->count();
        $sedang = $r->ujianSiswas->where('status','sedang')->count();
        $selesai = $r->ujianSiswas->where('status','selesai')->count();
    @endphp
    <div class="border border-gray-200 rounded-xl p-4 mb-4 hover:shadow-sm transition">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <p class="font-semibold text-gray-800">{{ $r->nama_ruang }}</p>
                <p class="text-xs text-gray-500">Token: <span class="font-mono font-bold text-yellow-700">{{ $r->token }}</span></p>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center space-x-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                    <span>{{ $sedang }} sedang</span>
                </span>
                <span class="flex items-center space-x-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                    <span>{{ $selesai }} selesai</span>
                </span>
                <span class="text-gray-400">/ {{ $total }} total</span>
                <a href="{{ route('guru.ruang-ujian.monitoring', $r->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded-lg">
                    <i class="fas fa-eye mr-1"></i>Detail
                </a>
            </div>
        </div>
        @if($total > 0)
        <div class="mt-3">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full transition-all" style="width:{{ $total > 0 ? ($selesai/$total*100) : 0 }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">{{ $total > 0 ? round($selesai/$total*100) : 0 }}% selesai</p>
        </div>
        @endif
    </div>
    @empty
    <div class="text-center py-12 text-gray-400">
        <i class="fas fa-desktop text-4xl mb-3"></i>
        <p>Belum ada ruang ujian aktif.</p>
    </div>
    @endforelse
</div>
@endsection
@section('scripts')
<script>
setTimeout(function(){ location.reload(); }, 30000);
</script>
@endsection

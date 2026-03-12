@extends('layouts.app')
@section('title','Monitoring - '.$ruangUjian->nama_ruang)
@section('page-title','Monitoring Ujian')
@section('content')
<div class="mb-4 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-gray-800">{{ $ruangUjian->nama_ruang }}</h2>
        <p class="text-sm text-gray-500">
            {{ $ruangUjian->bankSoal?->nama_soal }} &bull;
            Token: <span class="font-mono font-bold text-yellow-700">{{ $ruangUjian->token }}</span>
        </p>
    </div>
    <a href="{{ route('guru.ruang-ujian.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-1"></i>Kembali
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
        $total = $ruangUjian->ujianSiswas->count();
        $sedang = $ruangUjian->ujianSiswas->where('status','sedang')->count();
        $selesai = $ruangUjian->ujianSiswas->where('status','selesai')->count();
        $belum = $ruangUjian->ujianSiswas->where('status','belum')->count();
    @endphp
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-blue-500">
        <p class="text-xs text-gray-500">Total Peserta</p>
        <p class="text-2xl font-bold text-gray-800">{{ $total }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-500">Sedang Ujian</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $sedang }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-500">
        <p class="text-xs text-gray-500">Selesai</p>
        <p class="text-2xl font-bold text-green-600">{{ $selesai }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-gray-400">
        <p class="text-xs text-gray-500">Belum Mulai</p>
        <p class="text-2xl font-bold text-gray-600">{{ $belum }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-base font-semibold text-gray-700 mb-4">Status Peserta</h3>
    <div class="overflow-x-auto">
        <table id="tabelMonitor" class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Nama Siswa</th>
                    <th class="px-3 py-2 text-left">Status</th>
                    <th class="px-3 py-2 text-left">Waktu Mulai</th>
                    <th class="px-3 py-2 text-left">Waktu Selesai</th>
                    <th class="px-3 py-2 text-center">Keluar</th>
                    <th class="px-3 py-2 text-center">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ruangUjian->ujianSiswas as $i => $us)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $i+1 }}</td>
                    <td class="px-3 py-2 font-medium">{{ $us->siswa?->name ?? '-' }}</td>
                    <td class="px-3 py-2">
                        @if($us->status === 'sedang')
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full"><i class="fas fa-circle animate-pulse mr-1"></i>Sedang</span>
                        @elseif($us->status === 'selesai')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full"><i class="fas fa-check mr-1"></i>Selesai</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">Belum</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 text-xs">{{ $us->waktu_mulai?->format('H:i:s') ?? '-' }}</td>
                    <td class="px-3 py-2 text-xs">{{ $us->waktu_selesai?->format('H:i:s') ?? '-' }}</td>
                    <td class="px-3 py-2 text-center {{ $us->jumlah_keluar > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">{{ $us->jumlah_keluar ?? 0 }}</td>
                    <td class="px-3 py-2 text-center font-bold {{ $us->nilai >= 75 ? 'text-green-600' : ($us->nilai !== null ? 'text-red-500' : 'text-gray-400') }}">
                        {{ $us->nilai !== null ? number_format($us->nilai, 1) : '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-6 text-gray-400">Belum ada peserta.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    $('#tabelMonitor').DataTable({paging:false,searching:true,info:false,language:{search:'Cari:',zeroRecords:'Data tidak ditemukan'}});
    setTimeout(function(){ location.reload(); }, 30000);
});
</script>
@endsection

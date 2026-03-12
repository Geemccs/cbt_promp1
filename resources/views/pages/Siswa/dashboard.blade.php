@extends('layouts.app')
@section('title','Dashboard Siswa')
@section('page-title','Dashboard')
@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Selamat datang, {{ $siswa->name }}!</h2>
        <p class="text-sm text-gray-500">NISN: {{ $siswa->nisn }}</p>
    </div>

    {{-- Pengumuman --}}
    @if($pengumumans->isNotEmpty())
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <h3 class="text-sm font-semibold text-blue-800 mb-3"><i class="fas fa-bullhorn mr-2"></i>Pengumuman Terbaru</h3>
        <div class="space-y-2">
            @foreach($pengumumans as $p)
            <div class="bg-white rounded-lg p-3 text-sm text-gray-700 border border-blue-100">
                <div class="prose prose-sm max-w-none">{!! $p->isi !!}</div>
                <p class="text-xs text-gray-400 mt-2">{{ $p->created_at?->diffForHumans() }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CTA Masuk Ujian --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 mb-6 text-white">
        <h3 class="text-lg font-bold mb-2">Siap mengerjakan ujian?</h3>
        <p class="text-blue-200 text-sm mb-4">Masukkan token yang diberikan guru untuk memulai ujian.</p>
        <a href="{{ route('siswa.ruang-ujian') }}"
            class="inline-flex items-center bg-white text-blue-700 font-semibold text-sm px-5 py-2.5 rounded-lg hover:bg-blue-50 transition">
            <i class="fas fa-pencil-alt mr-2"></i>Masuk Ujian
        </a>
    </div>

    {{-- Riwayat Ujian --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">Riwayat Ujian</h3>
        @if($ujianSiswas->isEmpty())
        <div class="text-center py-8 text-gray-400">
            <i class="fas fa-clipboard-list text-4xl mb-3"></i>
            <p>Belum ada riwayat ujian.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left">#</th>
                        <th class="px-3 py-2 text-left">Nama Ujian</th>
                        <th class="px-3 py-2 text-left">Status</th>
                        <th class="px-3 py-2 text-center">Nilai</th>
                        <th class="px-3 py-2 text-left">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ujianSiswas as $i => $us)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $i + 1 }}</td>
                        <td class="px-3 py-2 font-medium">{{ $us->ruangUjian?->nama_ruang ?? '-' }}</td>
                        <td class="px-3 py-2">
                            @if($us->status === 'selesai')
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full"><i class="fas fa-check mr-1"></i>Selesai</span>
                            @elseif($us->status === 'sedang')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full"><i class="fas fa-spinner animate-spin mr-1"></i>Berlangsung</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">Belum</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-center font-bold {{ $us->nilai >= 75 ? 'text-green-600' : ($us->nilai !== null ? 'text-red-500' : 'text-gray-400') }}">
                            {{ $us->nilai !== null ? number_format($us->nilai, 1) : '-' }}
                        </td>
                        <td class="px-3 py-2 text-xs">{{ $us->waktu_selesai?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

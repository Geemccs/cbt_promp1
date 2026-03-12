@extends('layouts.app')
@section('title','Dashboard Guru')
@section('page-title','Dashboard')
@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Selamat datang, {{ $guru->name }}!</h2>
        <p class="text-sm text-gray-500">NIK: {{ $guru->nik }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-blue-600">
            <div class="bg-blue-100 p-3 rounded-full"><i class="fas fa-database text-blue-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Bank Soal Saya</p><p class="text-3xl font-bold text-gray-800">{{ $totalBankSoal }}</p></div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-green-500">
            <div class="bg-green-100 p-3 rounded-full"><i class="fas fa-door-open text-green-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Ruang Ujian Saya</p><p class="text-3xl font-bold text-gray-800">{{ $totalRuangUjian }}</p></div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">Navigasi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <a href="{{ route('guru.bank-soal.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl border border-blue-200 transition">
                <i class="fas fa-database text-blue-600 text-3xl mb-2"></i>
                <span class="text-sm font-medium text-blue-700">Bank Soal</span>
            </a>
            <a href="{{ route('guru.ruang-ujian.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl border border-green-200 transition">
                <i class="fas fa-door-open text-green-600 text-3xl mb-2"></i>
                <span class="text-sm font-medium text-green-700">Ruang Ujian</span>
            </a>
        </div>
    </div>

    @if($guru->kelas->isNotEmpty() || $guru->mapels->isNotEmpty())
    <div class="bg-white rounded-xl shadow p-6 mt-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">Tugas Mengajar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($guru->kelas->isNotEmpty())
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Kelas:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($guru->kelas as $k)
                    <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">{{ $k->nama_kelas }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            @if($guru->mapels->isNotEmpty())
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Mata Pelajaran:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($guru->mapels as $m)
                    <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">{{ $m->nama_mapel }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

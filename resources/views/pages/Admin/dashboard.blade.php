@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard')
@section('content')
<div class="p-6">
    {{-- Row 1: Siswa, Guru, Kelas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-blue-600">
            <div class="bg-blue-100 p-3 rounded-full"><i class="fas fa-user-graduate text-blue-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Data Siswa</p><p class="text-3xl font-bold text-gray-800">{{ $siswaCount }}</p></div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-green-500">
            <div class="bg-green-100 p-3 rounded-full"><i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Data Guru</p><p class="text-3xl font-bold text-gray-800">{{ $guruCount }}</p></div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-purple-500">
            <div class="bg-purple-100 p-3 rounded-full"><i class="fas fa-school text-purple-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Data Kelas</p><p class="text-3xl font-bold text-gray-800">{{ $kelasCount }}</p></div>
        </div>
    </div>
    {{-- Row 2: Mapel, Bank Soal, Ruang Ujian --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-yellow-500">
            <div class="bg-yellow-100 p-3 rounded-full"><i class="fas fa-book text-yellow-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Jumlah Mapel</p><p class="text-3xl font-bold text-gray-800">{{ $mapelCount }}</p></div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-red-500">
            <div class="bg-red-100 p-3 rounded-full"><i class="fas fa-database text-red-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Jumlah Bank Soal</p><p class="text-3xl font-bold text-gray-800">{{ $bankSoalCount }}</p></div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 border-l-4 border-indigo-500">
            <div class="bg-indigo-100 p-3 rounded-full"><i class="fas fa-door-open text-indigo-600 text-2xl"></i></div>
            <div><p class="text-sm text-gray-500">Jumlah Ruang Ujian</p><p class="text-3xl font-bold text-gray-800">{{ $ruangUjianCount }}</p></div>
        </div>
    </div>
    {{-- Quick Navigation --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Navigasi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.bank-soal.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl border border-blue-200 transition">
                <i class="fas fa-database text-blue-600 text-3xl mb-2"></i>
                <span class="text-sm font-medium text-blue-700">Bank Soal</span>
            </a>
            <a href="{{ route('admin.ruang-ujian.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl border border-green-200 transition">
                <i class="fas fa-door-open text-green-600 text-3xl mb-2"></i>
                <span class="text-sm font-medium text-green-700">Ruang Ujian</span>
            </a>
            <a href="{{ route('admin.exambrowser.index') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl border border-purple-200 transition">
                <i class="fas fa-shield-alt text-purple-600 text-3xl mb-2"></i>
                <span class="text-sm font-medium text-purple-700">Exambrowser</span>
            </a>
            <a href="{{ route('admin.pengumuman.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl border border-yellow-200 transition">
                <i class="fas fa-bullhorn text-yellow-600 text-3xl mb-2"></i>
                <span class="text-sm font-medium text-yellow-700">Pengumuman</span>
            </a>
        </div>
    </div>
</div>
@endsection

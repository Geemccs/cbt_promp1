@extends('layouts.app')
@section('title','Exambrowser')
@section('page-title','Pengaturan Exambrowser')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center space-x-4 mb-6">
            <div class="bg-purple-100 p-4 rounded-full">
                <i class="fas fa-shield-alt text-purple-600 text-3xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Safe Exam Browser (SEB)</h2>
                <p class="text-sm text-gray-500">Aktifkan mode browser aman untuk ujian</p>
            </div>
        </div>

        <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700">Status Exambrowser</p>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($sebEnabled === '1')
                        <span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i>Aktif - Siswa harus menggunakan Safe Exam Browser</span>
                        @else
                        <span class="text-gray-500"><i class="fas fa-times-circle mr-1"></i>Tidak Aktif - Siswa dapat menggunakan browser biasa</span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded-full mr-2 {{ $sebEnabled === '1' ? 'bg-green-500 animate-pulse' : 'bg-gray-300' }}"></span>
                    <span class="text-sm font-bold {{ $sebEnabled === '1' ? 'text-green-600' : 'text-gray-500' }}">
                        {{ $sebEnabled === '1' ? 'ON' : 'OFF' }}
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.exambrowser.toggle') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full py-3 rounded-xl font-medium text-sm transition {{ $sebEnabled === '1' ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                <i class="fas {{ $sebEnabled === '1' ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2 text-lg"></i>
                {{ $sebEnabled === '1' ? 'Nonaktifkan Exambrowser' : 'Aktifkan Exambrowser' }}
            </button>
        </form>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <h3 class="text-sm font-semibold text-blue-800 mb-2"><i class="fas fa-info-circle mr-1"></i>Tentang Safe Exam Browser</h3>
            <ul class="text-xs text-blue-700 space-y-1 list-disc list-inside">
                <li>Membatasi akses siswa ke situs lain selama ujian berlangsung</li>
                <li>Mencegah penggunaan shortcut keyboard berbahaya</li>
                <li>Menonaktifkan copy-paste dan print screen</li>
                <li>Memastikan integritas ujian secara digital</li>
            </ul>
        </div>
    </div>
</div>
@endsection

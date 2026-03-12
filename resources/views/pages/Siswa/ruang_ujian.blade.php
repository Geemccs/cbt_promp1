@extends('layouts.app')
@section('title','Masuk Ujian')
@section('page-title','Masuk Ujian')
@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-pencil-alt text-blue-600 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Masuk Ujian</h2>
            <p class="text-sm text-gray-500 mt-1">Masukkan token yang diberikan oleh guru</p>
        </div>

        <form action="{{ route('siswa.ujian.masuk-token') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Token Ujian</label>
                <input type="text" name="token" id="tokenInput"
                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 text-center text-2xl font-mono font-bold tracking-[0.5em] uppercase text-blue-700 focus:outline-none focus:border-blue-500 transition"
                    placeholder="XXXXXX" maxlength="8" autocomplete="off" required autofocus>
                @error('token')
                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm transition">
                <i class="fas fa-door-open mr-2"></i>Masuk Ujian
            </button>
        </form>

        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <p class="text-xs text-yellow-700 font-medium mb-1"><i class="fas fa-exclamation-triangle mr-1"></i>Perhatian:</p>
            <ul class="text-xs text-yellow-600 space-y-1 list-disc list-inside">
                <li>Pastikan Anda sudah siap sebelum memasukkan token.</li>
                <li>Ujian akan langsung dimulai setelah token dimasukkan.</li>
                <li>Jangan tutup tab atau browser selama ujian berlangsung.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('tokenInput').addEventListener('input', function () {
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g,'');
});
</script>
@endsection

@extends('layouts.app')
@section('title','Bank Soal')
@section('page-title','Bank Soal Saya')
@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Bank Soal Saya</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Bank Soal
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="tabelBankSoal" class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Nama Bank Soal</th>
                    <th class="px-3 py-2 text-left">Mata Pelajaran</th>
                    <th class="px-3 py-2 text-center">Waktu (menit)</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bankSoals as $i => $bs)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $bankSoals->firstItem() + $i }}</td>
                    <td class="px-3 py-2 font-medium">{{ $bs->nama_soal }}</td>
                    <td class="px-3 py-2">{{ $bs->mapel?->nama_mapel ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $bs->waktu_mengerjakan }}</td>
                    <td class="px-3 py-2 space-x-1">
                        <a href="{{ route('guru.bank-soal.edit', $bs->id) }}"
                            class="text-blue-600 hover:text-blue-700 text-xs bg-blue-50 px-2 py-1 rounded">
                            <i class="fas fa-pencil-alt mr-1"></i>Soal
                        </a>
                        <button onclick="openEdit({{ $bs->id }},'{{ addslashes($bs->nama_soal) }}',{{ $bs->mapel_id }},{{ $bs->waktu_mengerjakan }},{{ $bs->bobot_pg }},{{ $bs->bobot_essay }},{{ $bs->bobot_menjodohkan }},{{ $bs->bobot_benar_salah }})"
                            class="text-yellow-600 hover:text-yellow-700"><i class="fas fa-cog"></i></button>
                        <form action="{{ route('guru.bank-soal.destroy', $bs->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Hapus bank soal ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-6 text-gray-400">Belum ada bank soal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $bankSoals->links() }}</div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Tambah Bank Soal</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('guru.bank-soal.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank Soal</label>
                <input type="text" name="nama_soal" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="mapel_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapels as $m)<option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mengerjakan (menit)</label>
                <input type="number" name="waktu_mengerjakan" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <p class="text-sm font-medium text-gray-700 mb-3">Bobot Penilaian (total harus 100%)</p>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-xs text-gray-600 mb-1">PG (%)</label><input type="number" name="bobot_pg" value="100" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                    <div><label class="block text-xs text-gray-600 mb-1">Essay (%)</label><input type="number" name="bobot_essay" value="0" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                    <div><label class="block text-xs text-gray-600 mb-1">Menjodohkan (%)</label><input type="number" name="bobot_menjodohkan" value="0" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                    <div><label class="block text-xs text-gray-600 mb-1">Benar/Salah (%)</label><input type="number" name="bobot_benar_salah" value="0" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Simpan</button>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Edit Bank Soal</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank Soal</label>
                <input type="text" name="nama_soal" id="editNama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="mapel_id" id="editMapel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($mapels as $m)<option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mengerjakan (menit)</label>
                <input type="number" name="waktu_mengerjakan" id="editWaktu" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <p class="text-sm font-medium text-gray-700 mb-3">Bobot Penilaian</p>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-xs text-gray-600 mb-1">PG (%)</label><input type="number" name="bobot_pg" id="editPg" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                    <div><label class="block text-xs text-gray-600 mb-1">Essay (%)</label><input type="number" name="bobot_essay" id="editEssay" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                    <div><label class="block text-xs text-gray-600 mb-1">Menjodohkan (%)</label><input type="number" name="bobot_menjodohkan" id="editMenjodohkan" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                    <div><label class="block text-xs text-gray-600 mb-1">Benar/Salah (%)</label><input type="number" name="bobot_benar_salah" id="editBenarSalah" min="0" max="100" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
                </div>
            </div>
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium">Perbarui</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    $('#tabelBankSoal').DataTable({paging:false,searching:true,info:false,language:{search:'Cari:',zeroRecords:'Data tidak ditemukan'}});
});
function openEdit(id,nama,mapelId,waktu,pg,essay,menjodohkan,benarSalah){
    document.getElementById('formEdit').action='/guru/bank-soal/'+id;
    document.getElementById('editNama').value=nama;
    document.getElementById('editMapel').value=mapelId;
    document.getElementById('editWaktu').value=waktu;
    document.getElementById('editPg').value=pg;
    document.getElementById('editEssay').value=essay;
    document.getElementById('editMenjodohkan').value=menjodohkan;
    document.getElementById('editBenarSalah').value=benarSalah;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection

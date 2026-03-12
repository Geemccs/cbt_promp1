@extends('layouts.app')
@section('title','Data Guru')
@section('page-title','Data Guru')
@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Guru</h2>
        <div class="flex space-x-2">
            <button onclick="document.getElementById('modalImport').classList.remove('hidden')"
                class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-file-excel mr-2"></i>Import Excel
            </button>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Guru
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="tabelGuru" class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Nama</th>
                    <th class="px-3 py-2 text-left">NIK</th>
                    <th class="px-3 py-2 text-left">Kelas</th>
                    <th class="px-3 py-2 text-left">Mapel</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $i => $g)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $gurus->firstItem() + $i }}</td>
                    <td class="px-3 py-2 font-medium">{{ $g->name }}</td>
                    <td class="px-3 py-2 font-mono">{{ $g->nik }}</td>
                    <td class="px-3 py-2">
                        @foreach($g->kelas as $k)<span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded mr-1">{{ $k->nama_kelas }}</span>@endforeach
                    </td>
                    <td class="px-3 py-2">
                        @foreach($g->mapels as $m)<span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded mr-1">{{ $m->nama_mapel }}</span>@endforeach
                    </td>
                    <td class="px-3 py-2 space-x-1">
                        <button onclick="openEdit({{ $g->id }},'{{ addslashes($g->name) }}','{{ $g->nik }}')"
                            class="text-yellow-600 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></button>
                        <button onclick="openRelasi({{ $g->id }},'{{ addslashes($g->name) }}',{{ $g->kelas->pluck('id') }},{{ $g->mapels->pluck('id') }})"
                            class="text-blue-500 hover:text-blue-700" title="Atur Relasi"><i class="fas fa-link"></i></button>
                        <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Hapus guru ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-6 text-gray-400">Belum ada data guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $gurus->links() }}</div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Tambah Guru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.guru.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digit)</label>
                <input type="text" name="nik" maxlength="16" minlength="16" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required minlength="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Simpan</button>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Edit Guru</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="editName" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digit)</label>
                <input type="text" name="nik" id="editNik" maxlength="16" minlength="16" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" minlength="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium">Perbarui</button>
        </form>
    </div>
</div>

{{-- Modal Relasi --}}
<div id="modalRelasi" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Atur Relasi Guru: <span id="relasiNama" class="text-blue-600"></span></h3>
            <button onclick="document.getElementById('modalRelasi').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formRelasi" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas yang Diajar</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($kelas as $k)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="kelas_ids[]" value="{{ $k->id }}" class="cb-kelas w-4 h-4 text-blue-600">
                        <span class="text-sm">{{ $k->nama_kelas }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran yang Diajar</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($mapels as $m)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="mapel_ids[]" value="{{ $m->id }}" class="cb-mapel w-4 h-4 text-green-600">
                        <span class="text-sm">{{ $m->nama_mapel }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Simpan Relasi</button>
        </form>
    </div>
</div>

{{-- Modal Import --}}
<div id="modalImport" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Import Data Guru</h3>
            <button onclick="document.getElementById('modalImport').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 text-sm text-blue-700">
            <p class="font-medium mb-1"><i class="fas fa-info-circle mr-1"></i>Format Excel:</p>
            <p>Kolom: <strong>Nama | NIK | Password</strong></p>
        </div>
        <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">File Excel (.xlsx, .xls)</label>
                <input type="file" name="file" accept=".xlsx,.xls" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm font-medium">Import</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    $('#tabelGuru').DataTable({paging:false,searching:true,info:false,language:{search:'Cari:',zeroRecords:'Data tidak ditemukan'}});
});
function openEdit(id,name,nik){
    document.getElementById('formEdit').action='/admin/guru/'+id;
    document.getElementById('editName').value=name;
    document.getElementById('editNik').value=nik;
    document.getElementById('modalEdit').classList.remove('hidden');
}
function openRelasi(id,nama,kelasIds,mapelIds){
    document.getElementById('formRelasi').action='/admin/guru/'+id+'/relasi';
    document.getElementById('relasiNama').textContent=nama;
    document.querySelectorAll('.cb-kelas').forEach(cb=>{ cb.checked=kelasIds.includes(parseInt(cb.value)); });
    document.querySelectorAll('.cb-mapel').forEach(cb=>{ cb.checked=mapelIds.includes(parseInt(cb.value)); });
    document.getElementById('modalRelasi').classList.remove('hidden');
}
</script>
@endsection

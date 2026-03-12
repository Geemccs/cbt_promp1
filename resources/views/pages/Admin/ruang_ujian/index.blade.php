@extends('layouts.app')
@section('title','Ruang Ujian')
@section('page-title','Ruang Ujian')
@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Ruang Ujian</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>Buat Ruang Ujian
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="tabelRuang" class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Nama Ruang</th>
                    <th class="px-3 py-2 text-left">Bank Soal</th>
                    <th class="px-3 py-2 text-left">Guru</th>
                    <th class="px-3 py-2 text-left">Token</th>
                    <th class="px-3 py-2 text-left">Mulai</th>
                    <th class="px-3 py-2 text-left">Selesai</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ruangUjians as $i => $r)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $ruangUjians->firstItem() + $i }}</td>
                    <td class="px-3 py-2 font-medium">{{ $r->nama_ruang }}</td>
                    <td class="px-3 py-2">{{ $r->bankSoal?->nama_soal ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $r->guru?->name ?? 'Admin' }}</td>
                    <td class="px-3 py-2"><span class="font-mono bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs font-bold tracking-widest">{{ $r->token }}</span></td>
                    <td class="px-3 py-2 text-xs">{{ $r->tanggal_mulai?->format('d/m/Y H:i') }}</td>
                    <td class="px-3 py-2 text-xs">{{ $r->batas_akhir?->format('d/m/Y H:i') }}</td>
                    <td class="px-3 py-2 space-x-1">
                        <a href="{{ route('admin.ruang-ujian.monitoring', $r->id) }}"
                            class="text-blue-600 hover:text-blue-700 text-xs bg-blue-50 px-2 py-1 rounded"><i class="fas fa-eye mr-1"></i>Monitor</a>
                        <button onclick="openEdit({{ $r->id }},{{ json_encode($r) }},{{ $r->kelas->pluck('id') }})"
                            class="text-yellow-600 hover:text-yellow-700"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('admin.ruang-ujian.destroy', $r->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Hapus ruang ujian ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-6 text-gray-400">Belum ada ruang ujian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $ruangUjians->links() }}</div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Buat Ruang Ujian</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.ruang-ujian.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruang</label>
                <input type="text" name="nama_ruang" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bank Soal</label>
                <select name="bank_soal_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Bank Soal --</option>
                    @foreach($bankSoals as $bs)<option value="{{ $bs->id }}">{{ $bs->nama_soal }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Guru (Opsional)</label>
                <select name="guru_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Admin --</option>
                    @foreach($gurus as $g)<option value="{{ $g->id }}">{{ $g->name }}</option>@endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="datetime-local" name="tanggal_mulai" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batas Akhir</label>
                    <input type="datetime-local" name="batas_akhir" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Batas Keluar (kali)</label>
                <input type="number" name="batas_keluar" value="3" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas Peserta</label>
                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    @foreach($kelas as $k)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="kelas_ids[]" value="{{ $k->id }}" class="w-4 h-4 text-blue-600">
                        <span class="text-sm">{{ $k->nama_kelas }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="flex space-x-4 mb-4">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="hidden" name="acak_soal" value="0">
                    <input type="checkbox" name="acak_soal" value="1" class="w-4 h-4 text-blue-600">
                    <span class="text-sm">Acak Soal</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="hidden" name="acak_jawaban" value="0">
                    <input type="checkbox" name="acak_jawaban" value="1" class="w-4 h-4 text-blue-600">
                    <span class="text-sm">Acak Jawaban</span>
                </label>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Buat Ruang Ujian</button>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Edit Ruang Ujian</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruang</label>
                <input type="text" name="nama_ruang" id="editNamaRuang" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="datetime-local" name="tanggal_mulai" id="editMulai" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batas Akhir</label>
                    <input type="datetime-local" name="batas_akhir" id="editAkhir" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Batas Keluar</label>
                <input type="number" name="batas_keluar" id="editBatasKeluar" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas Peserta</label>
                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    @foreach($kelas as $k)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="kelas_ids[]" value="{{ $k->id }}" class="edit-kelas w-4 h-4 text-blue-600">
                        <span class="text-sm">{{ $k->nama_kelas }}</span>
                    </label>
                    @endforeach
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
    $('#tabelRuang').DataTable({paging:false,searching:true,info:false,language:{search:'Cari:',zeroRecords:'Data tidak ditemukan'}});
});
function openEdit(id,data,kelasIds){
    document.getElementById('formEdit').action='/admin/ruang-ujian/'+id;
    document.getElementById('editNamaRuang').value=data.nama_ruang;
    document.getElementById('editBatasKeluar').value=data.batas_keluar;
    // Format datetime
    if(data.tanggal_mulai) document.getElementById('editMulai').value=data.tanggal_mulai.replace(' ','T').substring(0,16);
    if(data.batas_akhir) document.getElementById('editAkhir').value=data.batas_akhir.replace(' ','T').substring(0,16);
    document.querySelectorAll('.edit-kelas').forEach(cb=>{ cb.checked=kelasIds.includes(parseInt(cb.value)); });
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection

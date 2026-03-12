@extends('layouts.app')
@section('title','Mata Pelajaran')
@section('page-title','Mata Pelajaran')
@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Mata Pelajaran</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Mapel
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="tabelMapel" class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left"><input type="checkbox" id="checkAll"></th>
                    <th class="px-3 py-2 text-left">Kode</th>
                    <th class="px-3 py-2 text-left">Nama Mata Pelajaran</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mapels as $m)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2"><input type="checkbox" class="cb-item" value="{{ $m->id }}"></td>
                    <td class="px-3 py-2 font-mono">{{ $m->kode }}</td>
                    <td class="px-3 py-2">{{ $m->nama_mapel }}</td>
                    <td class="px-3 py-2 space-x-2">
                        <button onclick="openEdit({{ $m->id }},'{{ addslashes($m->nama_mapel) }}')"
                            class="text-yellow-600 hover:text-yellow-700"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Hapus mapel ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-6 text-gray-400">Belum ada data mapel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mt-4">
        <button id="btnBulkDelete" onclick="bulkDelete()"
            class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg hidden">
            <i class="fas fa-trash mr-2"></i>Hapus Terpilih
        </button>
        <div>{{ $mapels->links() }}</div>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Tambah Mata Pelajaran</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.mapel.store') }}" method="POST">
            @csrf
            <div id="inputFields">
                <div class="mb-3 flex items-center space-x-2">
                    <input type="text" name="nama_mapel[]" placeholder="cth: Matematika" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <button type="button" onclick="tambahInput()" class="text-blue-600 hover:text-blue-700 text-xl"><i class="fas fa-plus-circle"></i></button>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium mt-2">Simpan</button>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Edit Mata Pelajaran</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran</label>
                <input type="text" name="nama_mapel" id="editNamaMapel" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium">Perbarui</button>
        </form>
    </div>
</div>

<form id="formBulkDelete" action="{{ route('admin.mapel.bulk-delete') }}" method="POST" class="hidden">
    @csrf
    <div id="bulkIds"></div>
</form>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    $('#tabelMapel').DataTable({paging:false,searching:true,info:false,language:{search:'Cari:',zeroRecords:'Data tidak ditemukan'}});
    $('#checkAll').on('change',function(){ $('.cb-item').prop('checked',$(this).is(':checked')); toggleBulkBtn(); });
    $(document).on('change','.cb-item',function(){ toggleBulkBtn(); });
});
function toggleBulkBtn(){
    if($('.cb-item:checked').length>0) $('#btnBulkDelete').removeClass('hidden');
    else $('#btnBulkDelete').addClass('hidden');
}
function openEdit(id,nama){
    document.getElementById('formEdit').action='/admin/mapel/'+id;
    document.getElementById('editNamaMapel').value=nama;
    document.getElementById('modalEdit').classList.remove('hidden');
}
function tambahInput(){
    const div=document.createElement('div');
    div.className='mb-3 flex items-center space-x-2';
    div.innerHTML='<input type="text" name="nama_mapel[]" placeholder="Nama mapel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"><button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-600 text-xl"><i class="fas fa-minus-circle"></i></button>';
    document.getElementById('inputFields').appendChild(div);
}
function bulkDelete(){
    const ids=$('.cb-item:checked').map(function(){return this.value;}).get();
    if(!ids.length)return;
    if(!confirm('Hapus '+ids.length+' mapel terpilih?'))return;
    const c=document.getElementById('bulkIds');
    c.innerHTML='';
    ids.forEach(id=>{ const i=document.createElement('input'); i.type='hidden'; i.name='ids[]'; i.value=id; c.appendChild(i); });
    document.getElementById('formBulkDelete').submit();
}
</script>
@endsection

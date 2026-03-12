@extends('layouts.app')
@section('title','Pengumuman')
@section('page-title','Pengumuman')
@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Pengumuman</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>Buat Pengumuman
        </button>
    </div>

    <div class="space-y-4">
        @forelse($pengumumans as $p)
        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-sm transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="prose prose-sm max-w-none text-gray-700 mb-2">{!! $p->isi !!}</div>
                    <div class="flex flex-wrap gap-1 mt-2">
                        @if($p->kelas->isEmpty())
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded">Semua Kelas</span>
                        @else
                            @foreach($p->kelas as $k)
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">{{ $k->nama_kelas }}</span>
                            @endforeach
                        @endif
                        <span class="text-xs text-gray-400 ml-2">{{ $p->created_at?->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex space-x-2 ml-4">
                    <button onclick="openEdit({{ $p->id }}, {{ json_encode($p->isi) }}, {{ $p->kelas->pluck('id') }})"
                        class="text-yellow-600 hover:text-yellow-700"><i class="fas fa-edit"></i></button>
                    <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <i class="fas fa-bullhorn text-4xl mb-3"></i>
            <p>Belum ada pengumuman.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $pengumumans->links() }}</div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Buat Pengumuman</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                <textarea name="isi" rows="5" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"
                    placeholder="Tulis isi pengumuman..."></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ditujukan Untuk Kelas <span class="text-gray-400 font-normal">(kosongkan = semua kelas)</span></label>
                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    @foreach($kelas as $k)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="kelas_ids[]" value="{{ $k->id }}" class="w-4 h-4 text-blue-600">
                        <span class="text-sm">{{ $k->nama_kelas }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Simpan</button>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Edit Pengumuman</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                <textarea name="isi" id="editIsi" rows="5" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ditujukan Untuk Kelas</label>
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
function openEdit(id, isi, kelasIds) {
    document.getElementById('formEdit').action = '/admin/pengumuman/' + id;
    document.getElementById('editIsi').value = isi;
    document.querySelectorAll('.edit-kelas').forEach(cb => {
        cb.checked = kelasIds.includes(parseInt(cb.value));
    });
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection

@extends('layouts.app')
@section('title','Editor Soal - '.$bankSoal->nama_soal)
@section('page-title','Editor Soal')
@section('styles')
<style>
.rte-toolbar { display:flex; flex-wrap:wrap; gap:4px; padding:6px 8px; background:#f9fafb; border:1px solid #d1d5db; border-bottom:none; border-radius:8px 8px 0 0; }
.rte-toolbar button { padding:4px 8px; border:1px solid #d1d5db; background:#fff; border-radius:4px; font-size:13px; cursor:pointer; color:#374151; transition:background 0.15s; }
.rte-toolbar button:hover,.rte-toolbar button.active { background:#dbeafe; border-color:#93c5fd; color:#1d4ed8; }
.rte-editor { min-height:120px; padding:10px 12px; border:1px solid #d1d5db; border-radius:0 0 8px 8px; background:#fff; outline:none; font-size:14px; line-height:1.6; }
.rte-editor:focus { border-color:#60a5fa; box-shadow:0 0 0 2px rgba(59,130,246,0.1); }
.soal-card { transition: box-shadow 0.2s; }
.soal-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.tab-btn.active { background:#2563eb; color:#fff; border-color:#2563eb; }
</style>
@endsection
@section('content')
{{-- Bank Soal Info --}}
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-800">{{ $bankSoal->nama_soal }}</h2>
            <p class="text-sm text-gray-500">
                {{ $bankSoal->mapel?->nama_mapel ?? '-' }} &bull;
                <i class="fas fa-clock mr-1"></i>{{ $bankSoal->waktu_mengerjakan }} menit &bull;
                {{ $soals->count() }} soal
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="document.getElementById('modalImportExcel').classList.remove('hidden')"
                class="bg-green-50 hover:bg-green-100 border border-green-300 text-green-700 text-xs px-3 py-2 rounded-lg">
                <i class="fas fa-file-excel mr-1"></i>Import Excel
            </button>
            <button onclick="document.getElementById('modalImportWord').classList.remove('hidden')"
                class="bg-blue-50 hover:bg-blue-100 border border-blue-300 text-blue-700 text-xs px-3 py-2 rounded-lg">
                <i class="fas fa-file-word mr-1"></i>Import Word
            </button>
            <a href="{{ request()->is('admin/*') ? route('admin.bank-soal.index') : route('guru.bank-soal.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs px-3 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Form Tambah Soal --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4 flex items-center">
            <i class="fas fa-plus-circle text-blue-600 mr-2"></i>Tambah Soal Baru
        </h3>

        {{-- Jenis Soal Tabs --}}
        <div class="flex flex-wrap gap-2 mb-4" id="jenisTabs">
            @foreach(['pg' => 'Pilihan Ganda','essay' => 'Essay','benar_salah' => 'Benar/Salah','menjodohkan' => 'Menjodohkan'] as $val => $label)
            <button type="button" class="tab-btn border border-gray-300 text-gray-600 text-xs px-3 py-1.5 rounded-lg {{ $val==='pg'?'active':'' }}"
                onclick="setJenis('{{ $val }}')">{{ $label }}</button>
            @endforeach
        </div>

        <form action="{{ request()->is('admin/*') ? route('admin.soal.store') : route('guru.soal.store') }}" method="POST" id="formSoal">
            @csrf
            <input type="hidden" name="bank_soal_id" value="{{ $bankSoal->id }}">
            <input type="hidden" name="jenis_soal" id="jenisSoal" value="pg">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                <div class="rte-toolbar" id="toolbarTambah">
                    <button type="button" onclick="rteCmd('tambah','bold')" title="Bold"><i class="fas fa-bold"></i></button>
                    <button type="button" onclick="rteCmd('tambah','italic')" title="Italic"><i class="fas fa-italic"></i></button>
                    <button type="button" onclick="rteCmd('tambah','underline')" title="Underline"><i class="fas fa-underline"></i></button>
                    <button type="button" onclick="rteCmd('tambah','insertUnorderedList')" title="List"><i class="fas fa-list-ul"></i></button>
                    <button type="button" onclick="rteCmd('tambah','insertOrderedList')" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                    <button type="button" onclick="insertImg('tambah')" title="Gambar"><i class="fas fa-image"></i></button>
                    <button type="button" onclick="rteCmd('tambah','justifyLeft')" title="Rata Kiri"><i class="fas fa-align-left"></i></button>
                    <button type="button" onclick="rteCmd('tambah','justifyCenter')" title="Rata Tengah"><i class="fas fa-align-center"></i></button>
                </div>
                <div id="rteTambah" class="rte-editor" contenteditable="true" data-placeholder="Tulis pertanyaan di sini..."></div>
                <input type="hidden" name="pertanyaan" id="pertanyaanTambah">
            </div>

            {{-- Opsi PG --}}
            <div id="opsiPG" class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban</label>
                @foreach(['a','b','c','d','e'] as $op)
                <div class="flex items-center mb-2">
                    <span class="w-6 text-sm font-bold text-gray-500 uppercase">{{ $op }}.</span>
                    <input type="text" name="opsi_{{ $op }}" placeholder="Opsi {{ strtoupper($op) }}"
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                </div>
                @endforeach
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban Benar</label>
                    <select name="jawaban_benar" class="jawaban-pg w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option><option value="e">E</option>
                    </select>
                </div>
            </div>

            {{-- Opsi Essay --}}
            <div id="opsiEssay" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kunci Jawaban</label>
                <textarea name="jawaban_benar" rows="3" placeholder="Tulis kunci jawaban..."
                    class="jawaban-essay w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"></textarea>
            </div>

            {{-- Opsi Benar/Salah --}}
            <div id="opsiBenarSalah" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban Benar</label>
                <select name="jawaban_benar" class="jawaban-bs w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="benar">Benar</option><option value="salah">Salah</option>
                </select>
            </div>

            {{-- Opsi Menjodohkan --}}
            <div id="opsiMenjodohkan" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pasangan (format: kiri=kanan, pisahkan dengan baris baru)</label>
                <textarea name="jawaban_benar" rows="4" placeholder="Contoh:&#10;Ibu Kota Indonesia=Jakarta&#10;Ibu Kota Jepang=Tokyo"
                    class="jawaban-mj w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 font-mono"></textarea>
            </div>

            <button type="submit" onclick="syncRte()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">
                <i class="fas fa-plus mr-2"></i>Tambah Soal
            </button>
        </form>
    </div>

    {{-- Daftar Soal --}}
    <div class="space-y-4">
        <h3 class="text-base font-semibold text-gray-700 flex items-center">
            <i class="fas fa-list text-blue-600 mr-2"></i>Daftar Soal ({{ $soals->count() }})
        </h3>
        @forelse($soals as $idx => $soal)
        <div class="soal-card bg-white rounded-xl shadow border border-gray-100 p-4" id="soal-{{ $soal->id }}">
            <div class="flex items-start justify-between mb-2">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded">
                    #{{ $idx+1 }} &bull; {{ strtoupper(str_replace('_',' ',$soal->jenis_soal)) }}
                </span>
                <div class="flex space-x-2">
                    <button onclick="openEditSoal({{ $soal->id }})"
                        class="text-yellow-600 hover:text-yellow-700 text-sm"><i class="fas fa-edit"></i></button>
                    <form action="{{ request()->is('admin/*') ? route('admin.soal.destroy', $soal->id) : route('guru.soal.destroy', $soal->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Hapus soal ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            <div class="text-sm text-gray-700 mb-3 prose max-w-none">{!! $soal->pertanyaan !!}</div>
            @if($soal->jenis_soal === 'pg')
            <div class="grid grid-cols-2 gap-1 text-xs">
                @foreach(['a','b','c','d','e'] as $op)
                    @if($soal->{'opsi_'.$op})
                    <div class="flex items-center {{ $soal->jawaban_benar === $op ? 'text-green-700 font-bold' : 'text-gray-600' }}">
                        <span class="mr-1">{{ strtoupper($op) }}.</span> {{ $soal->{'opsi_'.$op} }}
                        @if($soal->jawaban_benar === $op)<i class="fas fa-check ml-1 text-green-600"></i>@endif
                    </div>
                    @endif
                @endforeach
            </div>
            @elseif($soal->jenis_soal === 'benar_salah')
            <p class="text-xs"><span class="font-medium">Jawaban:</span> <span class="text-green-700 font-bold">{{ ucfirst($soal->jawaban_benar) }}</span></p>
            @elseif($soal->jenis_soal === 'essay')
            <p class="text-xs text-gray-500 italic">Kunci: {{ Str::limit($soal->jawaban_benar, 80) }}</p>
            @else
            <div class="text-xs text-gray-600">
                @foreach(explode("\n", $soal->jawaban_benar) as $pair)
                <p>{{ $pair }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-8 text-center text-gray-400">
            <i class="fas fa-question-circle text-4xl mb-3"></i>
            <p>Belum ada soal. Tambahkan soal pertama Anda!</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Modal Edit Soal --}}
<div id="modalEditSoal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Edit Soal</h3>
            <button onclick="document.getElementById('modalEditSoal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="formEditSoal" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Soal</label>
                <input type="text" id="editJenisSoal" readonly class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                <div class="rte-toolbar" id="toolbarEdit">
                    <button type="button" onclick="rteCmd('edit','bold')" title="Bold"><i class="fas fa-bold"></i></button>
                    <button type="button" onclick="rteCmd('edit','italic')" title="Italic"><i class="fas fa-italic"></i></button>
                    <button type="button" onclick="rteCmd('edit','underline')" title="Underline"><i class="fas fa-underline"></i></button>
                    <button type="button" onclick="rteCmd('edit','insertUnorderedList')" title="List"><i class="fas fa-list-ul"></i></button>
                    <button type="button" onclick="rteCmd('edit','insertOrderedList')" title="Numbered"><i class="fas fa-list-ol"></i></button>
                    <button type="button" onclick="insertImg('edit')" title="Gambar"><i class="fas fa-image"></i></button>
                </div>
                <div id="rteEdit" class="rte-editor" contenteditable="true"></div>
                <input type="hidden" name="pertanyaan" id="pertanyaanEdit">
            </div>
            <div id="editOpsiArea"></div>
            <button type="submit" onclick="syncRteEdit()" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium">Perbarui Soal</button>
        </form>
    </div>
</div>

{{-- Modal Import Excel --}}
<div id="modalImportExcel" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Import Soal dari Excel</h3>
            <button onclick="document.getElementById('modalImportExcel').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 text-xs text-green-700">
            <p class="font-semibold mb-1">Format Kolom:</p>
            <p>jenis_soal | pertanyaan | opsi_a | opsi_b | opsi_c | opsi_d | opsi_e | jawaban_benar</p>
        </div>
        <form action="{{ request()->is('admin/*') ? route('admin.soal.import-excel') : route('guru.soal.import-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bank_soal_id" value="{{ $bankSoal->id }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">File Excel (.xlsx, .xls)</label>
                <input type="file" name="file" accept=".xlsx,.xls" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm font-medium">Import</button>
        </form>
    </div>
</div>

{{-- Modal Import Word --}}
<div id="modalImportWord" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Import Soal dari Word</h3>
            <button onclick="document.getElementById('modalImportWord').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 text-xs text-blue-700">
            <p class="font-semibold mb-1">Format Dokumen Word:</p>
            <p>Setiap soal dipisahkan dengan baris kosong. Contoh:</p>
            <pre class="mt-1 font-mono text-xs">1. Pertanyaan
A. Opsi A
B. Opsi B
Jawaban: A</pre>
        </div>
        <form action="{{ request()->is('admin/*') ? route('admin.soal.import-word') : route('guru.soal.import-word') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bank_soal_id" value="{{ $bankSoal->id }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">File Word (.docx, .doc)</label>
                <input type="file" name="file" accept=".docx,.doc" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Import</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
// Soal data for edit modal
const soalData = @json($soals->keyBy('id'));
const adminPrefix = '{{ request()->is("admin/*") ? "admin" : "guru" }}';

// RTE helpers
function rteCmd(which, cmd) {
    const el = document.getElementById('rte' + (which === 'tambah' ? 'Tambah' : 'Edit'));
    el.focus();
    document.execCommand(cmd, false, null);
}
function insertImg(which) {
    const url = prompt('URL gambar:');
    if (url) {
        const el = document.getElementById('rte' + (which === 'tambah' ? 'Tambah' : 'Edit'));
        el.focus();
        document.execCommand('insertHTML', false, '<img src="' + url + '" style="max-width:100%;height:auto;" />');
    }
}
function syncRte() {
    document.getElementById('pertanyaanTambah').value = document.getElementById('rteTambah').innerHTML;
}
function syncRteEdit() {
    document.getElementById('pertanyaanEdit').value = document.getElementById('rteEdit').innerHTML;
}

// Jenis soal tabs
function setJenis(jenis) {
    document.getElementById('jenisSoal').value = jenis;
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    // Show/hide opsi areas
    document.getElementById('opsiPG').classList.toggle('hidden', jenis !== 'pg');
    document.getElementById('opsiEssay').classList.toggle('hidden', jenis !== 'essay');
    document.getElementById('opsiBenarSalah').classList.toggle('hidden', jenis !== 'benar_salah');
    document.getElementById('opsiMenjodohkan').classList.toggle('hidden', jenis !== 'menjodohkan');
    // Toggle required/name on hidden fields to avoid sending empty data
    ['jawaban-pg','jawaban-essay','jawaban-bs','jawaban-mj'].forEach(cls => {
        document.querySelectorAll('.'+cls).forEach(el => el.disabled = true);
    });
    const activeMap = {pg:'jawaban-pg',essay:'jawaban-essay',benar_salah:'jawaban-bs',menjodohkan:'jawaban-mj'};
    if (activeMap[jenis]) document.querySelectorAll('.'+activeMap[jenis]).forEach(el => el.disabled = false);
}

function openEditSoal(id) {
    const soal = soalData[id];
    if (!soal) return;
    const form = document.getElementById('formEditSoal');
    form.action = '/' + adminPrefix + '/soal/' + id;
    document.getElementById('editJenisSoal').value = soal.jenis_soal.replace('_',' ').toUpperCase();
    document.getElementById('rteEdit').innerHTML = soal.pertanyaan;
    // Build opsi area
    let html = '';
    if (soal.jenis_soal === 'pg') {
        html = '<div class="mb-3"><label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban</label>';
        ['a','b','c','d','e'].forEach(op => {
            html += '<div class="flex items-center mb-2"><span class="w-6 text-sm font-bold text-gray-500">' + op.toUpperCase() + '.</span><input type="text" name="opsi_' + op + '" value="' + (soal['opsi_'+op]||'') + '" class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-sm ml-2"></div>';
        });
        html += '<div class="mt-2"><label class="block text-sm font-medium text-gray-700 mb-1">Jawaban Benar</label><select name="jawaban_benar" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">';
        ['a','b','c','d','e'].forEach(op => { html += '<option value="'+op+'"'+(soal.jawaban_benar===op?' selected':'')+'>' + op.toUpperCase() + '</option>'; });
        html += '</select></div></div>';
    } else if (soal.jenis_soal === 'essay') {
        html = '<div class="mb-3"><label class="block text-sm font-medium text-gray-700 mb-1">Kunci Jawaban</label><textarea name="jawaban_benar" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none">' + (soal.jawaban_benar||'') + '</textarea></div>';
    } else if (soal.jenis_soal === 'benar_salah') {
        html = '<div class="mb-3"><label class="block text-sm font-medium text-gray-700 mb-1">Jawaban Benar</label><select name="jawaban_benar" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><option value="benar"'+(soal.jawaban_benar==='benar'?' selected':'')+'>Benar</option><option value="salah"'+(soal.jawaban_benar==='salah'?' selected':'')+'>Salah</option></select></div>';
    } else {
        html = '<div class="mb-3"><label class="block text-sm font-medium text-gray-700 mb-1">Pasangan</label><textarea name="jawaban_benar" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono">' + (soal.jawaban_benar||'') + '</textarea></div>';
    }
    document.getElementById('editOpsiArea').innerHTML = html;
    document.getElementById('modalEditSoal').classList.remove('hidden');
}

// Init
document.addEventListener('DOMContentLoaded', function () {
    // Set placeholder behavior for RTE
    document.getElementById('rteTambah').addEventListener('focus', function () {
        if (this.innerHTML === '') this.innerHTML = '';
    });
    // Disable hidden jawaban fields on load
    setJenis('pg');
    document.querySelectorAll('.tab-btn')[0].classList.add('active');
});
</script>
@endsection

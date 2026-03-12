<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ujian - {{ $ruangUjian->nama_ruang }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .soal-panel { display:none; }
        .soal-panel.active { display:block; }
        .nav-btn { transition: all 0.15s; }
        .nav-btn.answered { background:#16a34a; color:#fff; border-color:#16a34a; }
        .nav-btn.current { ring:2px; outline:2px solid #3b82f6; }
        body { overscroll-behavior: none; }
    </style>
</head>
<body class="bg-gray-100 h-screen overflow-hidden select-none">
{{-- Header --}}
<header class="bg-blue-700 text-white px-4 py-3 flex items-center justify-between shadow-md">
    <div>
        <p class="font-bold text-sm">{{ $ruangUjian->bankSoal->nama_soal }}</p>
        <p class="text-xs text-blue-200">{{ Auth::guard('siswa')->user()->name }}</p>
    </div>
    <div class="text-center">
        <p class="text-xs text-blue-200">Sisa Waktu</p>
        <p id="countdown" class="text-xl font-mono font-bold">--:--</p>
    </div>
    <button onclick="konfirmasiSelesai()" class="bg-white text-blue-700 font-semibold text-sm px-4 py-2 rounded-lg hover:bg-blue-50">
        <i class="fas fa-flag-checkered mr-1"></i>Selesai
    </button>
</header>

<div class="flex h-[calc(100vh-56px)] overflow-hidden">
    {{-- Navigasi Soal --}}
    <div class="w-48 bg-white border-r border-gray-200 overflow-y-auto p-3 flex-shrink-0">
        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Nomor Soal</p>
        <div class="grid grid-cols-4 gap-1">
            @foreach($soals as $i => $soal)
            <button type="button" id="navbtn-{{ $i }}"
                class="nav-btn w-8 h-8 text-xs font-bold rounded border border-gray-300 text-gray-600 {{ isset($jawabanSiswas[$soal->id]) && $jawabanSiswas[$soal->id]->jawaban ? 'answered' : '' }}"
                onclick="goToSoal({{ $i }})">{{ $i+1 }}</button>
            @endforeach
        </div>
        <div class="mt-4 space-y-1.5 text-xs text-gray-500">
            <div class="flex items-center space-x-2"><span class="w-4 h-4 bg-green-600 rounded"></span><span>Dijawab</span></div>
            <div class="flex items-center space-x-2"><span class="w-4 h-4 border border-gray-300 rounded"></span><span>Belum</span></div>
        </div>
    </div>

    {{-- Area Soal --}}
    <div class="flex-1 overflow-y-auto p-4">
        <form id="formSelesai" action="{{ route('siswa.ujian.selesai') }}" method="POST">
            @csrf
            <input type="hidden" name="ujian_siswa_id" value="{{ $ujianSiswa->id }}">
        </form>

        @foreach($soals as $i => $soal)
        <div id="soal-panel-{{ $i }}" class="soal-panel {{ $i === 0 ? 'active' : '' }} bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-3">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded">
                    Soal {{ $i+1 }} dari {{ $soals->count() }}
                    &bull; {{ strtoupper(str_replace('_',' ', $soal->jenis_soal)) }}
                </span>
            </div>
            <div class="prose prose-sm max-w-none text-gray-800 mb-6 text-base">{!! $soal->pertanyaan !!}</div>

            @if($soal->jenis_soal === 'pg')
            <div class="space-y-3">
                @foreach(['a','b','c','d','e'] as $op)
                    @if($soal->{'opsi_'.$op})
                    <label class="flex items-start space-x-3 p-3 rounded-xl border-2 cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition {{ isset($jawabanSiswas[$soal->id]) && $jawabanSiswas[$soal->id]->jawaban === $op ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" name="jawaban_{{ $soal->id }}" value="{{ $op }}"
                            class="mt-0.5 w-4 h-4 text-blue-600 flex-shrink-0"
                            {{ isset($jawabanSiswas[$soal->id]) && $jawabanSiswas[$soal->id]->jawaban === $op ? 'checked' : '' }}
                            onchange="saveJawaban({{ $ujianSiswa->id }}, {{ $soal->id }}, this.value, {{ $i }})">
                        <span class="text-sm"><strong class="mr-1">{{ strtoupper($op) }}.</strong> {{ $soal->{'opsi_'.$op} }}</span>
                    </label>
                    @endif
                @endforeach
            </div>
            @elseif($soal->jenis_soal === 'benar_salah')
            <div class="space-y-3">
                @foreach(['benar', 'salah'] as $op)
                <label class="flex items-center space-x-3 p-3 rounded-xl border-2 cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition {{ isset($jawabanSiswas[$soal->id]) && $jawabanSiswas[$soal->id]->jawaban === $op ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                    <input type="radio" name="jawaban_{{ $soal->id }}" value="{{ $op }}"
                        class="w-4 h-4 text-blue-600"
                        {{ isset($jawabanSiswas[$soal->id]) && $jawabanSiswas[$soal->id]->jawaban === $op ? 'checked' : '' }}
                        onchange="saveJawaban({{ $ujianSiswa->id }}, {{ $soal->id }}, this.value, {{ $i }})">
                    <span class="text-sm font-medium capitalize">{{ $op }}</span>
                </label>
                @endforeach
            </div>
            @elseif($soal->jenis_soal === 'essay')
            <textarea rows="5"
                class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 resize-none transition"
                placeholder="Tulis jawaban Anda..."
                onblur="saveJawaban({{ $ujianSiswa->id }}, {{ $soal->id }}, this.value, {{ $i }})"
                oninput="markNav({{ $i }}, this.value.trim().length > 0)">{{ isset($jawabanSiswas[$soal->id]) ? $jawabanSiswas[$soal->id]->jawaban : '' }}</textarea>
            @else
            {{-- Menjodohkan --}}
            @php $pairs = $soal->jawaban_benar ? array_filter(array_map('trim', explode("\n", $soal->jawaban_benar))) : []; @endphp
            <div class="space-y-2">
                @foreach($pairs as $pi => $pair)
                @php [$kiri, $kanan] = array_pad(explode('=', $pair, 2), 2, ''); @endphp
                <div class="flex items-center space-x-2">
                    <span class="flex-1 bg-gray-100 rounded-lg px-3 py-2 text-sm">{{ trim($kiri) }}</span>
                    <span class="text-gray-400"><i class="fas fa-arrows-alt-h"></i></span>
                    <input type="text" class="flex-1 border-2 border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Pasangkan...">
                </div>
                @endforeach
            </div>
            @endif

            {{-- Navigation buttons --}}
            <div class="flex justify-between mt-6">
                <button type="button" onclick="goToSoal({{ $i - 1 }})" {{ $i === 0 ? 'disabled' : '' }}
                    class="flex items-center text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 disabled:opacity-30">
                    <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                </button>
                @if($i < $soals->count() - 1)
                <button type="button" onclick="goToSoal({{ $i + 1 }})"
                    class="flex items-center text-sm px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                    Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
                </button>
                @else
                <button type="button" onclick="konfirmasiSelesai()"
                    class="flex items-center text-sm px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white">
                    <i class="fas fa-flag-checkered mr-2"></i>Selesai Ujian
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Modal Konfirmasi Selesai --}}
<div id="modalSelesai" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-flag-checkered text-green-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Selesaikan Ujian?</h3>
        <p class="text-sm text-gray-500 mb-1">Soal terjawab: <strong id="jumlahJawab">0</strong> dari {{ $soals->count() }}</p>
        <p class="text-xs text-red-500 mb-6">Pastikan semua soal sudah dijawab sebelum menyelesaikan ujian.</p>
        <div class="flex space-x-3">
            <button onclick="document.getElementById('modalSelesai').classList.add('hidden')"
                class="flex-1 border border-gray-300 text-gray-600 py-2 rounded-xl text-sm hover:bg-gray-50">Kembali</button>
            <button onclick="submitSelesai()"
                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl text-sm font-semibold">Ya, Selesai</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const ujianSiswaId = {{ $ujianSiswa->id }};
let currentSoal = 0;
let answeredSet = new Set();
const totalSoal = {{ $soals->count() }};

// Init answered from existing data
@php $soalPositions = []; @endphp
@foreach($soals as $idx => $soalItem)
    @php $soalPositions[$soalItem->id] = $idx; @endphp
@endforeach
@foreach($jawabanSiswas as $jawaban)
    @if($jawaban->jawaban)
    answeredSet.add({{ $soalPositions[$jawaban->soal_id] ?? 0 }});
    @endif
@endforeach

function goToSoal(idx) {
    if (idx < 0 || idx >= totalSoal) return;
    document.querySelectorAll('.soal-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('soal-panel-' + idx).classList.add('active');
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('current'));
    const btn = document.getElementById('navbtn-' + idx);
    if (btn) btn.classList.add('current');
    currentSoal = idx;
}

function markNav(idx, answered) {
    const btn = document.getElementById('navbtn-' + idx);
    if (!btn) return;
    if (answered) { btn.classList.add('answered'); answeredSet.add(idx); }
    else { btn.classList.remove('answered'); answeredSet.delete(idx); }
}

function saveJawaban(ujianSiswaId, soalId, jawaban, navIdx) {
    markNav(navIdx, jawaban && jawaban.length > 0);
    $.ajax({
        url: '{{ route("siswa.ujian.jawab") }}',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: { ujian_siswa_id: ujianSiswaId, soal_id: soalId, jawaban: jawaban },
    });
}

function konfirmasiSelesai() {
    document.getElementById('jumlahJawab').textContent = answeredSet.size;
    document.getElementById('modalSelesai').classList.remove('hidden');
}

function submitSelesai() {
    document.getElementById('formSelesai').submit();
}

// Countdown
const waktuSelesai = new Date('{{ $waktuSelesai->toIso8601String() }}');
function updateCountdown() {
    const now = new Date();
    let diff = Math.floor((waktuSelesai - now) / 1000);
    if (diff <= 0) {
        document.getElementById('countdown').textContent = '00:00';
        document.getElementById('formSelesai').submit();
        return;
    }
    const m = Math.floor(diff / 60).toString().padStart(2,'0');
    const s = (diff % 60).toString().padStart(2,'0');
    const el = document.getElementById('countdown');
    el.textContent = m + ':' + s;
    if (diff <= 60) el.classList.add('text-red-300');
}
updateCountdown();
setInterval(updateCountdown, 1000);

// Prevent back/forward
history.pushState(null, null, window.location.href);
window.onpopstate = function () {
    history.pushState(null, null, window.location.href);
    $.ajax({
        url: '{{ route("siswa.ujian.keluar") }}',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: { ujian_siswa_id: ujianSiswaId },
        success: function(res) {
            if (res.redirect) window.location = res.redirect;
        }
    });
};

// Init
goToSoal(0);
</script>
</body>
</html>

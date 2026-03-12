<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CBT MTsN 1 Mesuji</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-800 to-blue-600 flex flex-col items-center justify-center p-4">
<div class="flex flex-col md:flex-row gap-6 w-full max-w-4xl">
    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 flex-1 flex flex-col items-center justify-center text-white text-center border border-white border-opacity-20">
        <div class="w-40 h-40 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-4"><i class="fas fa-laptop text-6xl"></i></div>
        <h2 class="text-2xl font-bold mb-2">Sistem Ujian Berbasis Komputer</h2>
        <p class="text-blue-200 text-sm mb-6">Platform ujian digital yang modern, cepat, dan terpercaya</p>
        <div class="flex flex-wrap gap-2 justify-center">
            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs"><i class="fas fa-mobile-alt mr-1"></i>Responsif</span>
            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs"><i class="fas fa-bolt mr-1"></i>Cepat</span>
            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs"><i class="fas fa-smile mr-1"></i>Mudah</span>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-8 flex-1 shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3"><span class="text-white font-bold text-xl">M1</span></div>
            <h1 class="text-xl font-bold text-gray-800">CBT MTsN 1 Mesuji</h1>
            <p class="text-gray-500 text-sm">Masuk ke akun Anda</p>
        </div>
        <div class="flex border-b border-gray-200 mb-6">
            <button onclick="showTab('admin')" id="tab-admin" class="tab-btn flex-1 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600"><i class="fas fa-user-cog mr-1"></i>Admin</button>
            <button onclick="showTab('guru')" id="tab-guru" class="tab-btn flex-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-blue-600"><i class="fas fa-chalkboard-teacher mr-1"></i>Guru</button>
            <button onclick="showTab('siswa')" id="tab-siswa" class="tab-btn flex-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-blue-600"><i class="fas fa-user-graduate mr-1"></i>Siswa</button>
        </div>
        @if(session('error'))<div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-4"><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</div>@endif
        <div id="form-admin" class="tab-form">
            @if(session('error_admin'))<div class="bg-red-50 border border-red-200 text-red-600 text-sm px-3 py-2 rounded mb-3">{{ session('error_admin') }}</div>@endif
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative"><i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                <input type="email" name="email" required placeholder="admin@email.com" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"></div></div>
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative"><i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                <input type="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"></div></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-sm"><i class="fas fa-sign-in-alt mr-2"></i>Login sebagai Admin</button>
            </form>
        </div>
        <div id="form-guru" class="tab-form hidden">
            @if(session('error_guru'))<div class="bg-red-50 border border-red-200 text-red-600 text-sm px-3 py-2 rounded mb-3">{{ session('error_guru') }}</div>@endif
            <form action="{{ route('guru.login') }}" method="POST">
                @csrf
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 Digit)</label>
                <div class="relative"><i class="fas fa-id-card absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="nik" required placeholder="1234567890123456" maxlength="16" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"></div></div>
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative"><i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                <input type="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"></div></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-sm"><i class="fas fa-sign-in-alt mr-2"></i>Login sebagai Guru</button>
            </form>
        </div>
        <div id="form-siswa" class="tab-form hidden">
            @if(session('error_siswa'))<div class="bg-red-50 border border-red-200 text-red-600 text-sm px-3 py-2 rounded mb-3">{{ session('error_siswa') }}</div>@endif
            <form action="{{ route('siswa.login') }}" method="POST">
                @csrf
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">NISN (10 Digit)</label>
                <div class="relative"><i class="fas fa-id-badge absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="nisn" required placeholder="1234567890" maxlength="10" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"></div></div>
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative"><i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                <input type="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"></div></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-sm mb-3"><i class="fas fa-sign-in-alt mr-2"></i>Login sebagai Siswa</button>
            </form>
            <div class="border-t pt-3">
                <p class="text-xs text-gray-500 text-center mb-2">Atau masuk dengan token ujian</p>
                <form action="{{ route('siswa.ujian.masuk-token') }}" method="POST">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="token" placeholder="TOKEN UJIAN" maxlength="10" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm uppercase text-center tracking-widest font-mono">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm"><i class="fas fa-key"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<p class="text-blue-200 text-sm mt-6">&copy; {{ date('Y') }} | Developer by Asmin Pratama</p>
<script>
function showTab(tab){
    document.querySelectorAll('.tab-form').forEach(f=>f.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b=>{b.classList.remove('text-blue-600','border-blue-600');b.classList.add('text-gray-500','border-transparent');});
    document.getElementById('form-'+tab).classList.remove('hidden');
    const btn=document.getElementById('tab-'+tab);
    btn.classList.add('text-blue-600','border-blue-600');
    btn.classList.remove('text-gray-500','border-transparent');
}
@if(session('error_guru'))showTab('guru');@endif
@if(session('error_siswa'))showTab('siswa');@endif
</script>
</body>
</html>

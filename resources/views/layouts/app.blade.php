<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CBT MTsN 1 Mesuji')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .sidebar-menu a:hover,.sidebar-menu a.active{background-color:rgba(255,255,255,.15);border-left:3px solid #fff}
        .sidebar-menu a{border-left:3px solid transparent;transition:all .2s}
    </style>
    @yield('styles')
</head>
<body class="bg-gray-100 font-sans">
<div class="flex h-screen overflow-hidden">
    <div class="w-64 bg-blue-800 text-white flex flex-col flex-shrink-0 overflow-y-auto" id="sidebar">
        <div class="p-4 border-b border-blue-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center"><span class="text-blue-800 font-bold text-sm">CBT</span></div>
                <div><p class="font-bold text-sm">CBT MTsN 1</p><p class="text-xs text-blue-300">Mesuji</p></div>
            </div>
        </div>
        <nav class="sidebar-menu flex-1 p-2 space-y-1 text-sm">
            @if(Auth::guard('admin')->check())
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home w-5 mr-2"></i> Dashboard</a>
                <p class="px-3 py-1 text-xs text-blue-400 uppercase mt-3">Master Data</p>
                <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"><i class="fas fa-school w-5 mr-2"></i> Data Kelas</a>
                <a href="{{ route('admin.mapel.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"><i class="fas fa-book w-5 mr-2"></i> Mata Pelajaran</a>
                <a href="{{ route('admin.guru.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher w-5 mr-2"></i> Data Guru</a>
                <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"><i class="fas fa-user-graduate w-5 mr-2"></i> Data Siswa</a>
                <p class="px-3 py-1 text-xs text-blue-400 uppercase mt-3">Ujian</p>
                <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.bank-soal.*') ? 'active' : '' }}"><i class="fas fa-database w-5 mr-2"></i> Bank Soal</a>
                <a href="{{ route('admin.ruang-ujian.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.ruang-ujian.*') ? 'active' : '' }}"><i class="fas fa-door-open w-5 mr-2"></i> Ruang Ujian</a>
                <a href="{{ route('admin.monitoring.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}"><i class="fas fa-desktop w-5 mr-2"></i> Monitoring</a>
                <p class="px-3 py-1 text-xs text-blue-400 uppercase mt-3">Pengaturan</p>
                <a href="{{ route('admin.exambrowser.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.exambrowser.*') ? 'active' : '' }}"><i class="fas fa-shield-alt w-5 mr-2"></i> Exambrowser</a>
                <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"><i class="fas fa-bullhorn w-5 mr-2"></i> Pengumuman</a>
                <a href="{{ route('admin.administrator.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('admin.administrator.*') ? 'active' : '' }}"><i class="fas fa-user-cog w-5 mr-2"></i> Administrator</a>
            @elseif(Auth::guard('guru')->check())
                <a href="{{ route('guru.dashboard') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"><i class="fas fa-home w-5 mr-2"></i> Dashboard</a>
                <p class="px-3 py-1 text-xs text-blue-400 uppercase mt-3">Ujian</p>
                <a href="{{ route('guru.bank-soal.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('guru.bank-soal.*') ? 'active' : '' }}"><i class="fas fa-database w-5 mr-2"></i> Bank Soal</a>
                <a href="{{ route('guru.ruang-ujian.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('guru.ruang-ujian.*') ? 'active' : '' }}"><i class="fas fa-door-open w-5 mr-2"></i> Ruang Ujian</a>
                <a href="{{ route('guru.monitoring.index') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('guru.monitoring.*') ? 'active' : '' }}"><i class="fas fa-desktop w-5 mr-2"></i> Monitoring</a>
            @elseif(Auth::guard('siswa')->check())
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"><i class="fas fa-home w-5 mr-2"></i> Dashboard</a>
                <a href="{{ route('siswa.ruang-ujian') }}" class="flex items-center px-3 py-2 rounded text-white {{ request()->routeIs('siswa.ruang-ujian') ? 'active' : '' }}"><i class="fas fa-pencil-alt w-5 mr-2"></i> Masuk Ujian</a>
            @endif
        </nav>
        <div class="p-3 border-t border-blue-700 text-center text-xs text-blue-400">&copy; {{ date('Y') }} CBT MTsN 1 Mesuji</div>
    </div>
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <button onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="text-gray-500 mr-4"><i class="fas fa-bars text-xl"></i></button>
                <h1 class="text-lg font-semibold text-gray-800">@yield('page-title','Dashboard')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    @if(Auth::guard('admin')->check())
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::guard('admin')->user()->name }}</p>
                        <p class="text-xs text-blue-600">Administrator</p>
                    @elseif(Auth::guard('guru')->check())
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::guard('guru')->user()->name }}</p>
                        <p class="text-xs text-blue-600">Guru</p>
                    @elseif(Auth::guard('siswa')->check())
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::guard('siswa')->user()->name }}</p>
                        <p class="text-xs text-blue-600">Siswa</p>
                    @endif
                </div>
                @if(Auth::guard('admin')->check())
                    <form action="{{ route('admin.logout') }}" method="POST">@csrf<button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-2 rounded-lg"><i class="fas fa-sign-out-alt mr-1"></i>Logout</button></form>
                @elseif(Auth::guard('guru')->check())
                    <form action="{{ route('guru.logout') }}" method="POST">@csrf<button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-2 rounded-lg"><i class="fas fa-sign-out-alt mr-1"></i>Logout</button></form>
                @elseif(Auth::guard('siswa')->check())
                    <form action="{{ route('siswa.logout') }}" method="POST">@csrf<button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-2 rounded-lg"><i class="fas fa-sign-out-alt mr-1"></i>Logout</button></form>
                @endif
            </div>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between"><span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span><button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>@endif
            @if(session('error'))<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between"><span><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</span><button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>@endif
            @yield('content')
        </main>
        <footer class="bg-white border-t border-gray-200 px-6 py-2 text-center text-xs text-gray-500">&copy; {{ date('Y') }} | Develop by Asmin Pratama</footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@yield('scripts')
</body>
</html>

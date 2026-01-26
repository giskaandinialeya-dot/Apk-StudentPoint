@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="text-6xl font-bold text-red-600 mb-4">403</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Akses Ditolak</h1>
        <p class="text-gray-600 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        
        <div class="space-y-3">
            <a href="{{ route('dashboard') }}" class="block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                Kembali ke Dashboard
            </a>
            <a href="/" class="block bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg">
                Kembali ke Beranda
            </a>
        </div>

        <p class="text-gray-500 text-sm mt-6">
            Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator.
        </p>
    </div>
</div>
@endsection

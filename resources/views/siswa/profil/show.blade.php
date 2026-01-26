@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="w-full">
    <div class="min-h-screen">
        <!-- Page Header -->
        <div class="mb-8 sm:mb-12" data-aos="fade-down">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-2">Profil Siswa</h1>
                    <p class="text-gray-600 text-sm sm:text-base flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        Informasi lengkap data diri Anda
                    </p>
                </div>
                <a href="{{ route('siswa.profil.edit') }}" class="px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all transform hover:scale-105 shadow-md text-sm sm:text-base flex-shrink-0">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
            </div>
        </div>>

        <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <!-- Header Background -->
        <div class="h-40 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600"></div>

        <!-- Profile Content -->
        <div class="px-3 sm:px-6 md:px-8 py-6 sm:py-8">
            <!-- Avatar & Basic Info -->
            <div class="flex flex-col md:flex-row items-center md:items-start gap-4 sm:gap-6 md:gap-8 mb-8 -mt-16 sm:-mt-20 relative z-10">
                <div class="flex-shrink-0">
                    <div class="w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center border-4 border-white shadow-xl">
                        <i class="fas fa-user text-4xl sm:text-5xl md:text-6xl text-white"></i>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-3 truncate">{{ $siswa->nama_lengkap }}</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                        <div class="bg-blue-50 p-2 sm:p-3 rounded-lg">
                            <p class="text-xs text-gray-600 font-semibold mb-1">NIS</p>
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $siswa->nis }}</p>
                        </div>
                        <div class="bg-purple-50 p-2 sm:p-3 rounded-lg">
                            <p class="text-xs text-gray-600 font-semibold mb-1">Kelas</p>
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $siswa->kelas->nama ?? '-' }}</p>
                        </div>
                        <div class="bg-green-50 p-2 sm:p-3 rounded-lg">
                            <p class="text-xs text-gray-600 font-semibold mb-1">Status</p>
                            <span class="px-2 py-0.5 {{ $siswa->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs font-semibold inline-block truncate">
                                {{ ucfirst($siswa->status) }}
                            </span>
                        </div>
                        <div class="bg-orange-50 p-2 sm:p-3 rounded-lg">
                            <p class="text-xs text-gray-600 font-semibold mb-1">Tahun Ajaran</p>
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $siswa->tahun_ajaran ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            <!-- Profile Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8 mb-8">
                <!-- Informasi Pribadi -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6" data-aos="fade-up">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-2 pb-3 sm:pb-4 border-b-2 border-blue-500">
                        <i class="fas fa-id-card text-blue-600"></i>
                        Informasi Pribadi
                    </h3>

                    <div class="space-y-4 sm:space-y-5">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Jenis Kelamin</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->jenis_kelamin ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Tempat Lahir</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->tempat_lahir ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Tanggal Lahir</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">
                                @if ($siswa->tanggal_lahir)
                                    {{ is_string($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : $siswa->tanggal_lahir->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Agama</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->agama ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak & Alamat -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-2 pb-3 sm:pb-4 border-b-2 border-purple-500">
                        <i class="fas fa-phone text-purple-600"></i>
                        Informasi Kontak
                    </h3>

                    <div class="space-y-4 sm:space-y-5">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Email</p>
                            <p class="text-gray-900 font-medium break-all text-sm sm:text-base">{{ Auth::user()->email }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Alamat</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->alamat ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">No. Telepon</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->no_telepon ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Tanggal Masuk</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">
                                @if ($siswa->tanggal_masuk)
                                    {{ is_string($siswa->tanggal_masuk) ? \Carbon\Carbon::parse($siswa->tanggal_masuk)->format('d F Y') : $siswa->tanggal_masuk->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Orang Tua & Wali Kelas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8 mb-8">
                <!-- Wali Kelas -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-2 pb-3 sm:pb-4 border-b-2 border-green-500">
                        <i class="fas fa-chalkboard-user text-green-600"></i>
                        Informasi Wali Kelas
                    </h3>

                    <div class="space-y-4 sm:space-y-5">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Nama Wali Kelas</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->kelas->guru->nama_lengkap ?? 'Belum Ditugaskan' }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Kelas</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ $siswa->kelas->nama ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Email Wali Kelas</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base break-all">{{ $siswa->kelas->guru->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 sm:p-6 border-2 border-blue-200" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-2 pb-3 sm:pb-4 border-b-2 border-blue-500">
                        <i class="fas fa-shield-alt text-blue-600"></i>
                        Informasi Akun
                    </h3>
                    <div class="space-y-3 sm:space-y-4">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Nama Pengguna</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Role</p>
                            <span class="px-2 sm:px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs sm:text-sm font-semibold inline-block flex-shrink-0">
                                <i class="fas fa-user-tag mr-2"></i>{{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Terdaftar Sejak</p>
                            <p class="text-gray-900 font-medium text-sm sm:text-base">{{ Auth::user()->created_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1 sm:mb-2">Email Terverifikasi</p>
                            <span class="inline-block px-2 sm:px-3 py-1 {{ Auth::user()->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs sm:text-sm font-semibold flex-shrink-0">
                                <i class="fas {{ Auth::user()->email_verified_at ? 'fa-check-circle' : 'fa-times-circle' }} mr-1 sm:mr-2"></i>
                                {{ Auth::user()->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 sm:p-6 border-2 border-purple-200" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-flash text-purple-600"></i>
                    Menu Cepat
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-3">
                    <a href="{{ route('siswa.dashboard') }}" class="group bg-white hover:bg-blue-50 rounded-lg p-2 sm:p-3 lg:p-4 transition-all border border-gray-300 hover:border-blue-400 text-center">
                        <div class="text-2xl sm:text-3xl mb-1 sm:mb-2">📊</div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-900">Dashboard</p>
                    </a>
                    <a href="{{ route('siswa.absensi.riwayat') }}" class="group bg-white hover:bg-green-50 rounded-lg p-2 sm:p-3 lg:p-4 transition-all border border-gray-300 hover:border-green-400 text-center">
                        <div class="text-2xl sm:text-3xl mb-1 sm:mb-2">📋</div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-900">Absensi</p>
                    </a>
                    <a href="{{ route('siswa.profil.edit') }}" class="group bg-white hover:bg-orange-50 rounded-lg p-2 sm:p-3 lg:p-4 transition-all border border-gray-300 hover:border-orange-400 text-center">
                        <div class="text-2xl sm:text-3xl mb-1 sm:mb-2">✏️</div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-900">Edit</p>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="contents">
                        @csrf
                        <button type="submit" class="group bg-white hover:bg-red-50 rounded-lg p-2 sm:p-3 lg:p-4 transition-all border border-gray-300 hover:border-red-400 text-center cursor-pointer">
                            <div class="text-2xl sm:text-3xl mb-1 sm:mb-2">🚪</div>
                            <p class="text-xs sm:text-sm font-semibold text-gray-900">Logout</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('title', 'Input Absensi Hari Ini')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-down">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Input Absensi Harian</h1>
            <p class="text-gray-600"><i class="fas fa-calendar-check"></i> Input absensi untuk {{ date('l, d F Y') }}</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-4xl mx-auto">
        <form action="{{ route('guru.absensi.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Tanggal Hidden -->
            <input type="hidden" name="tanggal" value="{{ today()->format('Y-m-d') }}">

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-900"><i class="fas fa-info-circle mr-2"></i><strong>Instruksi:</strong> Pilih status untuk setiap siswa. Anda bisa memilih "Hadir", "Sakit", "Izin", atau "Alfa".</p>
            </div>

            <!-- Absensi List -->
            <div class="space-y-4">
                @foreach($siswas as $idx => $siswa)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                            <!-- Siswa Info -->
                            <div>
                                <p class="font-bold text-gray-900">{{ $loop->iteration }}. {{ $siswa->nama_lengkap }}</p>
                                <p class="text-sm text-gray-600">NIS: {{ $siswa->nis }}</p>
                            </div>

                            <!-- Status Buttons -->
                            <div class="md:col-span-2">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($status_options as $status_key => $status_label)
                                        @php
                                            $colors = [
                                                'hadir' => 'bg-green-100 hover:bg-green-200 text-green-700 border-green-300',
                                                'sakit' => 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700 border-yellow-300',
                                                'izin' => 'bg-blue-100 hover:bg-blue-200 text-blue-700 border-blue-300',
                                                'alfa' => 'bg-red-100 hover:bg-red-200 text-red-700 border-red-300',
                                            ];
                                        @endphp
                                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border-2 cursor-pointer transition-all {{ $colors[$status_key] }}">
                                            <input type="radio" name="absensi[{{ $idx }}][siswa_id]" value="{{ $siswa->id }}" class="hidden">
                                            <input type="radio" name="absensi[{{ $idx }}][status]" value="{{ $status_key }}" required class="w-4 h-4">
                                            <span class="font-semibold text-sm">{{ $status_label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div>
                                <input type="text" name="absensi[{{ $idx }}][keterangan]" placeholder="Keterangan (opsional)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" maxlength="100">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Hidden siswa_id field untuk setiap absensi -->
            @foreach($siswas as $idx => $siswa)
                <input type="hidden" name="absensi[{{ $idx }}][siswa_id]" value="{{ $siswa->id }}">
            @endforeach

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Absensi
                </button>
                <a href="{{ route('guru.absensi.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- JavaScript untuk menangani form dengan multiple radio buttons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle radio button changes untuk fill siswa_id otomatis
            const form = document.querySelector('form');
            const statusRadios = form.querySelectorAll('input[name^="absensi"][name$="][status]"]');
            
            statusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const match = this.name.match(/\[(\d+)\]/);
                    if (match) {
                        const index = match[1];
                        const siswaIdField = form.querySelector(`input[name="absensi[${index}][siswa_id]"]`);
                        // siswa_id sudah ter-set di hidden field, jadi tidak perlu ubah
                    }
                });
            });

            // Prevent form submission jika ada yang belum dipilih
            form.addEventListener('submit', function(e) {
                let allFilled = true;
                const absensiGroups = {};
                
                // Get all indices
                const indices = new Set();
                form.querySelectorAll('input[name^="absensi"]').forEach(input => {
                    const match = input.name.match(/\[(\d+)\]/);
                    if (match) indices.add(match[1]);
                });

                // Check each group
                indices.forEach(idx => {
                    const statusRadios = form.querySelectorAll(`input[name="absensi[${idx}][status]"]`);
                    const isChecked = Array.from(statusRadios).some(r => r.checked);
                    if (!isChecked) {
                        allFilled = false;
                    }
                });

                if (!allFilled) {
                    e.preventDefault();
                    alert('Mohon pilih status untuk semua siswa!');
                }
            });
        });
    </script>
</div>
@endsection

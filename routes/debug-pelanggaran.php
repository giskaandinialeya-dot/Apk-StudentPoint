<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug/pelanggaran-create', function() {
    $user = auth()->user();
    if (!$user) {
        return 'Not authenticated';
    }
    
    $guru = \App\Models\Guru::where('user_id', $user->id)->first();
    
    $response = [
        'user_id' => $user->id,
        'email' => $user->email,
        'guru_found' => $guru ? true : false,
        'guru_id' => $guru?->id,
        'has_kelas_wali' => $guru?->kelasWali ? true : false,
        'kelas_wali_id' => $guru?->kelasWali?->id,
    ];
    
    if ($guru && $guru->kelasWali) {
        $siswas = $guru->kelasWali->siswas()->aktif()->get();
        $jenisPelanggarans = \App\Models\JenisPerlanggaran::aktif()->get();
        
        $response['siswas_count'] = $siswas->count();
        $response['jenis_pelanggaran_count'] = $jenisPelanggarans->count();
        $response['jenis_pelanggaran_list'] = $jenisPelanggarans->map(fn($j) => [
            'id' => $j->id,
            'nama' => $j->nama,
            'poin' => $j->poin,
        ])->toArray();
    }
    
    return response()->json($response, 200);
})->middleware(['auth:sanctum', 'verified', 'role:guru']);

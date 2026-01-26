<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Show absensi list with filters
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru || !$guru->kelasWali) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas wali.');
        }

        $kelas = $guru->kelasWali;
        $siswas = $kelas->siswas()->aktif()->get();

        $query = Absensi::whereIn('siswa_id', $siswas->pluck('id'));

        // Filter tanggal
        $tanggal_filter = $request->filled('tanggal') ? $request->tanggal : today()->format('Y-m-d');
        $query->whereDate('tanggal', $tanggal_filter);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absentis = $query->with('siswa')->orderBy('tanggal', 'desc')->paginate(20);

        return view('guru.absensi.index', [
            'absentis' => $absentis,
            'kelas' => $kelas,
            'siswas' => $siswas,
            'tanggal_filter' => $tanggal_filter,
            'status_options' => Absensi::STATUSES,
        ]);
    }

    /**
     * Show form untuk input absensi harian
     */
    public function create()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru || !$guru->kelasWali) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas wali.');
        }

        $siswas = $guru->kelasWali->siswas()->aktif()->get();

        return view('guru.absensi.create', [
            'siswas' => $siswas,
            'status_options' => Absensi::STATUSES,
            'tanggal_hari_ini' => today()->format('Y-m-d'),
        ]);
    }

    /**
     * Store absensi harian untuk multiple siswa
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array|min:1',
            'absensi.*.siswa_id' => 'required|exists:siswas,id',
            'absensi.*.status' => 'required|in:hadir,sakit,izin,alfa',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);

        $tanggal = $validated['tanggal'];

        foreach ($validated['absensi'] as $absensi_data) {
            // Cek duplikasi
            $existing = Absensi::where('siswa_id', $absensi_data['siswa_id'])
                ->whereDate('tanggal', $tanggal)
                ->first();

            if ($existing) {
                // Update existing record
                $existing->update([
                    'status' => $absensi_data['status'],
                    'keterangan' => $absensi_data['keterangan'] ?? null,
                    'guru_input_id' => $user->id,
                ]);
            } else {
                // Create new record
                Absensi::create([
                    'siswa_id' => $absensi_data['siswa_id'],
                    'guru_input_id' => $user->id,
                    'tanggal' => $tanggal,
                    'status' => $absensi_data['status'],
                    'keterangan' => $absensi_data['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('guru.absensi.index', ['tanggal' => $tanggal])
            ->with('success', 'Absensi berhasil disimpan!');
    }

    /**
     * Edit single absensi
     */
    public function edit(Absensi $absensi)
    {
        return view('guru.absensi.edit', [
            'absensi' => $absensi,
            'status_options' => Absensi::STATUSES,
        ]);
    }

    /**
     * Update single absensi
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alfa',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $absensi->update($validated);

        return redirect()->back()->with('success', 'Absensi berhasil diperbarui!');
    }

    /**
     * Bulk input for today
     */
    public function bulkToday()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru || !$guru->kelasWali) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas wali.');
        }

        $siswas = $guru->kelasWali->siswas()->aktif()->get();

        // Check if already input for today
        $existing = Absensi::whereIn('siswa_id', $siswas->pluck('id'))
            ->whereDate('tanggal', today())
            ->first();

        if ($existing) {
            return redirect()->route('guru.absensi.index', ['tanggal' => today()->format('Y-m-d')])
                ->with('info', 'Absensi hari ini sudah pernah diinput. Silakan edit jika perlu perubahan.');
        }

        return view('guru.absensi.bulk-today', [
            'siswas' => $siswas,
            'status_options' => Absensi::STATUSES,
        ]);
    }
}

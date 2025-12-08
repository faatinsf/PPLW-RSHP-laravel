<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->select(
                'rm.idrekam_medis',
                'rm.created_at as tanggal_appointment',
                'rm.anamnesa',
                'rm.diagnosa',
                'p.idpet',
                'p.nama as nama_pet',
                'jh.nama_jenis_hewan',
                'rh.nama_ras',
                'u_pemilik.nama as nama_pemilik',
                'pm.no_wa',
                'u_dokter.nama as nama_dokter'
            );

        // Filter by date
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('rm.created_at', $request->tanggal);
        }

        // Filter by status (we'll use diagnosa field to determine status)
        if ($request->has('status') && $request->status != '') {
            switch ($request->status) {
                case 'pending':
                    $query->whereNull('rm.diagnosa');
                    break;
                case 'selesai':
                    $query->whereNotNull('rm.diagnosa');
                    break;
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('p.nama', 'like', '%' . $search . '%')
                  ->orWhere('u_pemilik.nama', 'like', '%' . $search . '%')
                  ->orWhere('pm.no_wa', 'like', '%' . $search . '%');
            });
        }

        $appointments = $query->orderBy('rm.created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => DB::table('rekam_medis')->count(),
            'today' => DB::table('rekam_medis')->whereDate('created_at', Carbon::today())->count(),
            'pending' => DB::table('rekam_medis')->whereNull('diagnosa')->count(),
            'completed' => DB::table('rekam_medis')->whereNotNull('diagnosa')->count(),
        ];

        return view('resepsionis.appointment.index', compact('appointments', 'stats'));
    }

    public function create()
    {
        // Get pets with owners
        $pets = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select(
                'p.idpet',
                'p.nama as nama_pet',
                'jh.nama_jenis_hewan',
                'rh.nama_ras',
                'u.nama as nama_pemilik',
                'pm.no_wa'
            )
            ->orderBy('u.nama', 'asc')
            ->get();

        // Get doctors (role_user with idrole = 2)
        $doctors = DB::table('role_user as ru')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->where('ru.idrole', 2)
            ->where('ru.status', 1)
            ->select('ru.idrole_user', 'u.nama')
            ->orderBy('u.nama', 'asc')
            ->get();

        return view('resepsionis.appointment.create', compact('pets', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required|string',
            'tanggal_appointment' => 'required|date',
        ]);

        try {
            DB::table('rekam_medis')->insert([
                'idpet' => $validated['idpet'],
                'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
                'anamnesa' => $validated['anamnesa'],
                'created_at' => $validated['tanggal_appointment'],
                'temuan_klinis' => null,
                'diagnosa' => null,
            ]);

            return redirect()->route('resepsionis.appointment.index')
                ->with('success', 'Appointment berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat appointment: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $appointment = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->where('rm.idrekam_medis', $id)
            ->select(
                'rm.*',
                'p.idpet',
                'p.nama as nama_pet',
                'p.tanggal_lahir',
                'p.jenis_kelamin',
                'p.warna_tanda',
                'jh.nama_jenis_hewan',
                'rh.nama_ras',
                'pm.idpemilik',
                'pm.no_wa',
                'pm.alamat',
                'u_pemilik.nama as nama_pemilik',
                'u_pemilik.email as email_pemilik',
                'u_dokter.nama as nama_dokter',
                'ru.idrole_user'
            )
            ->first();

        if (!$appointment) {
            return redirect()->route('resepsionis.appointment.index')
                ->with('error', 'Appointment tidak ditemukan!');
        }

        // Get detail tindakan
        $details = DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'drm.idkode_tindakan_terapi', '=', 'ktt.idkode_tindakan_terapi')
            ->join('kategori as k', 'ktt.idkategori', '=', 'k.idkategori')
            ->join('kategori_klinis as kk', 'ktt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->where('drm.idrekam_medis', $id)
            ->select(
                'drm.*',
                'ktt.kode',
                'ktt.deskripsi_tindakan_terapi',
                'k.nama_kategori',
                'kk.nama_kategori_klinis'
            )
            ->get();

        return view('resepsionis.appointment.show', compact('appointment', 'details'));
    }

    public function edit($id)
    {
        $appointment = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();

        if (!$appointment) {
            return redirect()->route('resepsionis.appointment.index')
                ->with('error', 'Appointment tidak ditemukan!');
        }

        // Get pets with owners
        $pets = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select(
                'p.idpet',
                'p.nama as nama_pet',
                'jh.nama_jenis_hewan',
                'u.nama as nama_pemilik'
            )
            ->orderBy('u.nama', 'asc')
            ->get();

        // Get doctors
        $doctors = DB::table('role_user as ru')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->where('ru.idrole', 2)
            ->where('ru.status', 1)
            ->select('ru.idrole_user', 'u.nama')
            ->orderBy('u.nama', 'asc')
            ->get();

        return view('resepsionis.appointment.edit', compact('appointment', 'pets', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required|string',
            'tanggal_appointment' => 'required|date',
        ]);

        try {
            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update([
                    'idpet' => $validated['idpet'],
                    'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
                    'anamnesa' => $validated['anamnesa'],
                    'created_at' => $validated['tanggal_appointment'],
                ]);

            return redirect()->route('resepsionis.appointment.show', $id)
                ->with('success', 'Appointment berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui appointment: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Check if has details
            $hasDetails = DB::table('detail_rekam_medis')
                ->where('idrekam_medis', $id)
                ->exists();

            if ($hasDetails) {
                return back()->with('error', 'Tidak dapat menghapus appointment yang sudah memiliki tindakan!');
            }

            DB::table('rekam_medis')->where('idrekam_medis', $id)->delete();

            return redirect()->route('resepsionis.appointment.index')
                ->with('success', 'Appointment berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus appointment: ' . $e->getMessage());
        }
    }

    // Quick registration from dashboard
    public function quickRegister(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:500',
            'no_wa' => 'required|string|max:45',
            'email' => 'nullable|email|max:200',
            'alamat' => 'nullable|string|max:100',
            'nama_pet' => 'required|string|max:100',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:J,B',
            'warna_tanda' => 'nullable|string|max:45',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create user for pemilik
            $iduser = DB::table('user')->insertGetId([
                'nama' => $validated['nama_pemilik'],
                'email' => $validated['email'] ?? strtolower(str_replace(' ', '', $validated['nama_pemilik'])) . rand(100, 999) . '@temp.com',
                'password' => bcrypt('password123'),
            ]);

            if (!$iduser) {
                throw new \Exception('Gagal membuat user');
            }

            // 2. Get next idpemilik (manual karena auto_increment mungkin tidak set)
            $maxIdPemilik = DB::table('pemilik')->max('idpemilik');
            $nextIdPemilik = ($maxIdPemilik ?? 0) + 1;

            // 3. Create pemilik
            $insertedPemilik = DB::table('pemilik')->insert([
                'idpemilik' => $nextIdPemilik,
                'no_wa' => $validated['no_wa'],
                'alamat' => $validated['alamat'],
                'iduser' => $iduser,
            ]);

            if (!$insertedPemilik) {
                throw new \Exception('Gagal membuat data pemilik');
            }

            // 4. Get next idpet (manual)
            $maxIdPet = DB::table('pet')->max('idpet');
            $nextIdPet = ($maxIdPet ?? 0) + 1;

            // 5. Create pet
            $insertedPet = DB::table('pet')->insert([
                'idpet' => $nextIdPet,
                'nama' => $validated['nama_pet'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'warna_tanda' => $validated['warna_tanda'],
                'idpemilik' => $nextIdPemilik,
                'idras_hewan' => $validated['idras_hewan'],
            ]);

            if (!$insertedPet) {
                throw new \Exception('Gagal membuat data pet');
            }

            DB::commit();

            return redirect()->route('resepsionis.appointment.create')
                ->with('success', 'Registrasi berhasil! Silakan buat appointment.')
                ->with('new_pet_id', $nextIdPet);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Quick Register Error: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return back()
                ->with('error', 'Gagal registrasi: ' . $e->getMessage())
                ->withInput();
        }
    }
}
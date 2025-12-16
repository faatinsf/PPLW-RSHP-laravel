<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Get all appointments with pet and user data
        $appointments = DB::table('appointment')
            ->leftJoin('pet', 'appointment.idpet', '=', 'pet.idpet')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('appointment.idpemilik', $pemilik->idpemilik)
            ->select(
                'appointment.*',
                'pet.nama as nama_pet',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->orderBy('appointment.tanggal_appointment', 'desc')
            ->orderBy('appointment.waktu_appointment', 'desc')
            ->get();
        
        // Separate appointments by status
        $upcomingAppointments = $appointments->where('status', 'dikonfirmasi')
            ->filter(function($apt) {
                return $apt->tanggal_appointment >= date('Y-m-d');
            });
        
        $pendingAppointments = $appointments->where('status', 'pending');
        $completedAppointments = $appointments->where('status', 'selesai');
        $cancelledAppointments = $appointments->where('status', 'dibatalkan');
        
        return view('pemilik.appointment.index', compact(
            'appointments',
            'upcomingAppointments',
            'pendingAppointments',
            'completedAppointments',
            'cancelledAppointments'
        ));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Get user's pets
        $pets = DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->select(
                'pet.idpet',
                'pet.nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();
        
        // Jenis layanan
        $jenisLayanan = [
            'Pemeriksaan Umum',
            'Vaksinasi',
            'Grooming',
            'Bedah / Operasi',
            'Konsultasi',
            'Pemeriksaan Laboratorium',
            'Rawat Inap',
            'Emergency',
            'Lainnya'
        ];
        
        return view('pemilik.appointment.create', compact('pets', 'jenisLayanan'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        $validated = $request->validate([
            'idpet' => ['nullable', 'exists:pet,idpet'],
            'tanggal_appointment' => ['required', 'date', 'after_or_equal:today'],
            'waktu_appointment' => ['required'],
            'jenis_layanan' => ['required', 'string', 'max:100'],
            'keluhan' => ['nullable', 'string'],
        ]);
        
        // Insert appointment
        DB::table('appointment')->insert([
            'idpemilik' => $pemilik->idpemilik,
            'idpet' => $validated['idpet'] ?? null,
            'tanggal_appointment' => $validated['tanggal_appointment'],
            'waktu_appointment' => $validated['waktu_appointment'],
            'jenis_layanan' => $validated['jenis_layanan'],
            'keluhan' => $validated['keluhan'] ?? null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('pemilik.appointment')
            ->with('success', 'Janji temu berhasil dibuat! Menunggu konfirmasi dari klinik.');
    }

    /**
     * Display the specified appointment.
     */
    public function show($id)
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Get appointment detail
        $appointment = DB::table('appointment')
            ->leftJoin('pet', 'appointment.idpet', '=', 'pet.idpet')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('appointment.idappointment', $id)
            ->where('appointment.idpemilik', $pemilik->idpemilik)
            ->select(
                'appointment.*',
                'pet.nama as nama_pet',
                'pet.jenis_kelamin',
                'pet.tanggal_lahir',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->first();
        
        if (!$appointment) {
            return redirect()->route('pemilik.appointment')
                ->with('error', 'Appointment tidak ditemukan');
        }
        
        return view('pemilik.appointment.show', compact('appointment'));
    }

    /**
     * Cancel the appointment.
     */
    public function cancel($id)
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Check if appointment exists and belongs to user
        $appointment = DB::table('appointment')
            ->where('idappointment', $id)
            ->where('idpemilik', $pemilik->idpemilik)
            ->first();
        
        if (!$appointment) {
            return redirect()->route('pemilik.appointment')
                ->with('error', 'Appointment tidak ditemukan');
        }
        
        // Check if can be cancelled (only pending or confirmed)
        if (!in_array($appointment->status, ['pending', 'dikonfirmasi'])) {
            return redirect()->route('pemilik.appointment')
                ->with('error', 'Appointment tidak dapat dibatalkan');
        }
        
        // Update status to cancelled
        DB::table('appointment')
            ->where('idappointment', $id)
            ->update([
                'status' => 'dibatalkan',
                'updated_at' => now()
            ]);
        
        return redirect()->route('pemilik.appointment')
            ->with('success', 'Appointment berhasil dibatalkan');
    }
}
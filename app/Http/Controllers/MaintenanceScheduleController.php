<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceScheduleController extends Controller
{
    /**
     * List semua jadwal
     */
    public function index()
    {
        $schedules = MaintenanceSchedule::with(['asset', 'creator', 'assignee'])
            ->latest()
            ->get();

        return view('maintenance.schedule.index', compact('schedules'));
    }

    /**
     * Form buat jadwal baru
     */
    public function create()
    {
        $assets    = Asset::all();
        $teknisis  = User::where('role', 'teknisi')->get();

        return view('maintenance.schedule.create', compact('assets', 'teknisis'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id'       => 'required|exists:assets,id',
            'assigned_to'    => 'nullable|exists:users,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'repeat_every'   => 'nullable|integer|min:1',
        ]);

        $schedule = MaintenanceSchedule::create([
            'asset_id'       => $request->asset_id,
            'created_by'     => Auth::id(),
            'assigned_to'    => $request->assigned_to,
            'title'          => $request->title,
            'description'    => $request->description,
            'scheduled_date' => $request->scheduled_date,
            'repeat_every'   => $request->repeat_every,
            'next_schedule'  => $request->repeat_every
                                    ? now()->parse($request->scheduled_date)->addDays($request->repeat_every)
                                    : null,
            'status'         => 'upcoming',
        ]);

        return redirect()
            ->route('maintenance.schedule.index')
            ->with('success', 'Jadwal maintenance berhasil dibuat');
    }

    /**
     * Detail jadwal
     */
    public function show($id)
    {
        $schedule = MaintenanceSchedule::with(['asset', 'creator', 'assignee', 'logs.reporter'])
            ->findOrFail($id);

        return view('maintenance.schedule.show', compact('schedule'));
    }

    /**
     * Form edit jadwal
     */
    public function edit($id)
    {
        $schedule  = MaintenanceSchedule::findOrFail($id);
        $assets    = Asset::all();
        $teknisis  = User::where('role', 'teknisi')->get();

        return view('maintenance.schedule.edit', compact('schedule', 'assets', 'teknisis'));
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, $id)
    {
        $schedule = MaintenanceSchedule::findOrFail($id);

        $request->validate([
            'asset_id'       => 'required|exists:assets,id',
            'assigned_to'    => 'nullable|exists:users,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'scheduled_date' => 'required|date',
            'repeat_every'   => 'nullable|integer|min:1',
            'status'         => 'required|in:upcoming,in_progress,done,cancelled',
        ]);

        $schedule->update([
            'asset_id'       => $request->asset_id,
            'assigned_to'    => $request->assigned_to,
            'title'          => $request->title,
            'description'    => $request->description,
            'scheduled_date' => $request->scheduled_date,
            'repeat_every'   => $request->repeat_every,
            'next_schedule'  => $request->repeat_every
                                    ? now()->parse($request->scheduled_date)->addDays($request->repeat_every)
                                    : null,
            'status'         => $request->status,
        ]);

        // Kalau status done & ada repeat → buat jadwal berikutnya otomatis
        if ($request->status === 'done' && $schedule->repeat_every) {
            MaintenanceSchedule::create([
                'asset_id'       => $schedule->asset_id,
                'created_by'     => $schedule->created_by,
                'assigned_to'    => $schedule->assigned_to,
                'title'          => $schedule->title,
                'description'    => $schedule->description,
                'scheduled_date' => $schedule->next_schedule,
                'repeat_every'   => $schedule->repeat_every,
                'next_schedule'  => $schedule->next_schedule->addDays($schedule->repeat_every),
                'status'         => 'upcoming',
            ]);
        }

        return redirect()
            ->route('maintenance.schedule.index')
            ->with('success', 'Jadwal maintenance berhasil diperbarui');
    }

    /**
     * Hapus jadwal
     */
    public function destroy($id)
    {
        $schedule = MaintenanceSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()
            ->route('maintenance.schedule.index')
            ->with('success', 'Jadwal maintenance berhasil dihapus');
    }
}
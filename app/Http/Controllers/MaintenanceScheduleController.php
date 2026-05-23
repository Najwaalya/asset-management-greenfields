<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'teknisi') {
            $schedules = MaintenanceSchedule::with(['asset', 'creator', 'assignee'])
                ->where('assigned_to', $user->id)
                ->latest()
                ->get();
        } else {
            $schedules = MaintenanceSchedule::with(['asset', 'creator', 'assignee'])
                ->latest()
                ->get();
        }

        return view('maintenance.schedule.index', compact('schedules'));
    }

    public function create()
    {
        $assets   = Asset::all();
        $teknisis = User::where('role', 'teknisi')->get();

        return view('maintenance.schedule.create', compact('assets', 'teknisis'));
    }

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

        MaintenanceSchedule::create([
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

    public function show($id)
    {
        $schedule = MaintenanceSchedule::with(['asset', 'creator', 'assignee', 'logs.reporter'])
            ->findOrFail($id);

        // Pastikan teknisi hanya bisa lihat miliknya
        if (Auth::user()->role === 'teknisi' && $schedule->assigned_to !== Auth::id()) {
            abort(403);
        }

        return view('maintenance.schedule.show', compact('schedule'));
    }

    public function edit($id)
    {
        $schedule = MaintenanceSchedule::findOrFail($id);
        $assets   = Asset::all();
        $teknisis = User::where('role', 'teknisi')->get();

        return view('maintenance.schedule.edit', compact('schedule', 'assets', 'teknisis'));
    }

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

        // Kalau done & ada repeat → buat jadwal berikutnya otomatis
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

    public function destroy($id)
    {
        MaintenanceSchedule::findOrFail($id)->delete();

        return redirect()
            ->route('maintenance.schedule.index')
            ->with('success', 'Jadwal maintenance berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
{
    $schedule = MaintenanceSchedule::findOrFail($id);

    // Pastikan teknisi hanya bisa update miliknya
    if (auth()->user()->role === 'teknisi' && $schedule->assigned_to !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'status' => 'required|in:upcoming,in_progress,done,cancelled',
    ]);

    $schedule->update(['status' => $request->status]);

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
        ->route('maintenance.schedule.show', $id)
        ->with('success', 'Status jadwal berhasil diperbarui');
}
}
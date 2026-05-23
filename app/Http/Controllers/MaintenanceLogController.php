<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceLogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'teknisi') {
            $logs = MaintenanceLog::with(['asset', 'reporter'])
                ->where('reported_by', $user->id)
                ->orderByRaw("CASE
                    WHEN status = 'pending'     THEN 1
                    WHEN status = 'in_progress' THEN 2
                    WHEN status = 'resolved'    THEN 3
                END")
                ->latest()
                ->get();
        } else {
            $logs = MaintenanceLog::with(['asset', 'reporter'])
                ->orderByRaw("CASE
                    WHEN status = 'pending'     THEN 1
                    WHEN status = 'in_progress' THEN 2
                    WHEN status = 'resolved'    THEN 3
                END")
                ->latest()
                ->get();
        }

        return view('maintenance.logs.index', compact('logs'));
    }

    public function create(Request $request)
    {
        $assets     = Asset::all();
        $teknisis   = User::where('role', 'teknisi')->get();
        $scheduleId = $request->schedule_id;
        $assetId    = $request->asset_id;

        // Kalau dari schedule, ambil data schedule-nya
        $schedule = $scheduleId
            ? MaintenanceSchedule::with('asset')->find($scheduleId)
            : null;

        return view('maintenance.logs.create', compact('assets', 'teknisis', 'scheduleId', 'assetId', 'schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id'    => 'required|exists:assets,id',
            'assigned_to' => 'nullable|exists:users,id',
            'issue'       => 'required|string',
            'solution'    => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,resolved',
        ]);

        $log = MaintenanceLog::create([
            'asset_id'    => $request->asset_id,
            'reported_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
            'schedule_id' => $request->schedule_id,
            'issue'       => $request->issue,
            'solution'    => $request->solution,
            'status'      => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        // Update status schedule kalau log dibuat dari schedule
        if ($request->schedule_id) {
            $schedule = MaintenanceSchedule::find($request->schedule_id);
            if ($schedule) {
                $scheduleStatus = match($request->status) {
                    'pending'     => 'upcoming',
                    'in_progress' => 'in_progress',
                    'resolved'    => 'done',
                    default       => $schedule->status,
                };
                $schedule->update(['status' => $scheduleStatus]);

                // Kalau done & ada repeat → buat jadwal berikutnya
                if ($scheduleStatus === 'done' && $schedule->repeat_every) {
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
            }
        }

        return redirect()
            ->route('maintenance.show', $log->id)
            ->with('success', 'Log maintenance berhasil dibuat');
    }

    public function show($id)
    {
        $log = MaintenanceLog::with(['asset', 'reporter', 'assignee', 'schedule'])
            ->findOrFail($id);

        return view('maintenance.logs.show', compact('log'));
    }

    public function edit($id)
    {
        $log      = MaintenanceLog::findOrFail($id);
        $assets   = Asset::all();
        $teknisis = User::where('role', 'teknisi')->get();

        return view('maintenance.logs.edit', compact('log', 'assets', 'teknisis'));
    }

    public function update(Request $request, $id)
    {
        $log = MaintenanceLog::findOrFail($id);

        $request->validate([
            'asset_id'    => 'required|exists:assets,id',
            'assigned_to' => 'nullable|exists:users,id',
            'issue'       => 'required|string',
            'solution'    => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,resolved',
        ]);

        $log->update([
            'asset_id'    => $request->asset_id,
            'assigned_to' => $request->assigned_to,
            'issue'       => $request->issue,
            'solution'    => $request->solution,
            'status'      => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        return redirect()
            ->route('maintenance.show', $log->id)
            ->with('success', 'Log maintenance berhasil diperbarui');
    }

    public function destroy($id)
    {
        MaintenanceLog::findOrFail($id)->delete();

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Log maintenance berhasil dihapus');
    }
}
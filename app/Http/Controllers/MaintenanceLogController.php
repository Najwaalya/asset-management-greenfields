<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceLogController extends Controller
{
    /**
     * Display all maintenance logs
     */
    public function index()
    {
        $logs = MaintenanceLog::with(['asset', 'reporter'])
            ->latest()
            ->get();

        return view('maintenance.index', compact('logs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $assets = Asset::all();

        return view('maintenance.create', compact('assets'));
    }

    /**
     * Store new maintenance log
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'issue' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        MaintenanceLog::create([
            'asset_id' => $request->asset_id,
            'reported_by' => Auth::id(),
            'issue' => $request->issue,
            'solution' => $request->solution,
            'status' => $request->status,
            'resolved_at' => $request->status === 'resolved'
                ? now()
                : null,
        ]);

        // Optional: update asset status
        $asset = Asset::find($request->asset_id);

        if ($request->status !== 'resolved') {
            $asset->update([
                'status' => 'maintenance'
            ]);
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Laporan maintenance berhasil dibuat');
    }

    /**
     * Show maintenance detail
     */
    public function show($id)
    {
        $log = MaintenanceLog::with(['asset', 'reporter'])
            ->findOrFail($id);

        return view('maintenance.show', compact('log'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $log = MaintenanceLog::findOrFail($id);
        $assets = Asset::all();

        return view('maintenance.edit', compact('log', 'assets'));
    }

    /**
     * Update maintenance log
     */
    public function update(Request $request, $id)
    {
        $log = MaintenanceLog::findOrFail($id);

        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'issue' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $log->update([
            'asset_id' => $request->asset_id,
            'issue' => $request->issue,
            'solution' => $request->solution,
            'status' => $request->status,
            'resolved_at' => $request->status === 'resolved'
                ? now()
                : null,
        ]);

        // Optional: update asset status
        $asset = Asset::find($request->asset_id);

        if ($request->status === 'resolved') {
            $asset->update([
                'status' => 'active'
            ]);
        } else {
            $asset->update([
                'status' => 'maintenance'
            ]);
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil diperbarui');
    }

    /**
     * Delete maintenance log
     */
    public function destroy($id)
    {
        $log = MaintenanceLog::findOrFail($id);

        $log->delete();

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil dihapus');
    }
}
<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\MaintenanceSchedule;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view): void
    {
        if (!Auth::check()) return;

        $user = Auth::user();

        if ($user->role === 'teknisi') {
            $notifications = MaintenanceSchedule::with('asset')
                ->where('assigned_to', $user->id)
                ->whereIn('status', ['upcoming', 'in_progress'])
                ->orderBy('scheduled_date')
                ->get();
        } else {
            $notifications = MaintenanceSchedule::with('asset')
                ->whereIn('status', ['upcoming', 'in_progress'])
                ->orderBy('scheduled_date')
                ->take(10)
                ->get();
        }

        $view->with('navNotifications', $notifications);
        $view->with('navNotifCount', $notifications->count());
    }
}
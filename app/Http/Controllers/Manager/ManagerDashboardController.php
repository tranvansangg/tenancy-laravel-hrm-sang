<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller; // ← bắt buộc phải import
use Illuminate\Http\Request;
use App\Models\BusinessTrip;
use Illuminate\Support\Facades\Auth;

class ManagerDashboardController extends Controller
{ public function index()
    {
        $manager = Auth::user()->employee;

        // Lấy các công tác mà manager đã tạo cho nhân viên phòng mình
        $notifications = BusinessTrip::where('requested_by', $manager->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->take(10)
            ->get();

        return view('manager.dashboard', compact('notifications'));
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; // ← bắt buộc phải import
use App\Models\BusinessTrip;

use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
      public function index()
    {
        // Lấy tất cả công tác chờ duyệt
        $pendingTrips = BusinessTrip::with('employee')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('pendingTrips'));
    }
}

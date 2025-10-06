<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;

class LeavesController extends Controller
{
    // Hiển thị danh sách tất cả đơn
    public function index()
    {
        $leaves = Leave::with('employee')->orderBy('created_at','desc')->paginate(15);
        return view('admin.leaves.index', compact('leaves'));
    }

    // Form duyệt/cập nhật
    public function edit($id)
    {
        $leave = Leave::with('employee')->findOrFail($id);
        return view('admin.leaves.edit', compact('leave'));
    }

    // Cập nhật trạng thái + phản hồi admin
    public function update(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);

        $request->validate([
            'status'=>'required|in:pending,approved,rejected',
            'admin_note'=>'nullable|string',
        ]);

        $leave->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);

        return redirect()->route('admin.leaves.index')
                         ->with('success','Đơn nghỉ phép đã được cập nhật.');
    }
}

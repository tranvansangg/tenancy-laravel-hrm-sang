<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->paginate(10);
        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(Request $request)
    {
        $allowedPositions = [
            'Giám đốc', 'Phó Giám đốc', 'Trưởng phòng', 'Phó phòng',
            'Team Leader', 'Supervisor', 'Nhân viên', 'Chuyên viên',
            'Kỹ sư', 'Thư ký', 'Nhân viên hành chính', 'Nhân viên lễ tân',
            'Nhân viên kinh doanh', 'Chuyên viên marketing', 'Kế toán',
            'Kế toán trưởng', 'Nhân viên nhân sự', 'Trưởng phòng nhân sự',
            'Nhân viên IT', 'Kỹ sư phần mềm', 'Trưởng phòng IT',
            'Thực tập sinh', 'Bảo vệ', 'Nhân viên kho','Nhân viên','Chuyên viên',
            'Tạp vụ','Lái xe','Bếp trưởng','Phục vụ','Thu ngân','Nhân viên bán hàng','Nhân viên giao hàng',
            'Thực tập sinh', 'Bảo vệ', 'Nhân viên kho',
            'Chủ tịch', 'Phó chủ tịch', 'Giám đốc điều hành', 'CFO', 'CTO', 'COO','CEO',
            'Quản lý', 'Trợ lý', 'Kỹ thuật viên', 'Nhân viên hỗ trợ', 'Nhân viên phát triển', 'Nhân viên thiết kế', 'Nhân viên kiểm thử', 'Nhân viên bảo trì', 'Nhân viên nghiên cứu', 'Nhân viên phân tích', 'Nhân viên tư vấn', 'Nhân viên đào tạo', 'Nhân viên chăm sóc khách hàng', 'Nhân viên vận hành', 'Nhân viên logistics', 'Nhân viên mua hàng', 'Nhân viên xuất nhập khẩu',
            'Nhân viên pháp lý', 'Nhân viên truyền thông', 'Nhân viên sự kiện', 'Nhân viên quan hệ công chúng', 'Nhân viên phát triển kinh doanh', 'Nhân viên quản lý dự án', 'Nhân viên kiểm soát chất lượng', 'Nhân viên an ninh mạng', 'Nhân viên dữ liệu', 'Nhân viên AI', 'Nhân viên blockchain', 'Nhân viên IoT', 'Nhân viên thực tế ảo', 'Nhân viên thực tế tăng cường', 'Nhân viên điện toán đám mây', 'Nhân viên kỹ thuật số', 'Nhân viên chuyển đổi số', 'Nhân viên tự động hóa', 'Nhân viên robotics', 'Nhân viên in 3D', 'Nhân viên nano', 'Nhân viên sinh học', 'Nhân viên y tế', 'Nhân viên dược', 'Nhân viên giáo dục', 'Nhân viên xã hội', 'Nhân viên tâm lý', 'Nhân viên nghệ thuật', 'Nhân viên văn hóa', 'Nhân viên thể thao', 'Nhân viên du lịch', 'Nhân viên khách sạn', 'Nhân viên nhà hàng', 'Nhân viên sự kiện', 'Nhân viên giải trí', 'Nhân viên truyền hình', 'Nhân viên phát thanh', 'Nhân viên báo chí', 'Nhân viên xuất bản', 'Nhân viên quảng cáo', 'Nhân viên tiếp thị', 'Nhân viên bán hàng', 'Nhân viên dịch vụ khách hàng', 'Nhân viên hỗ trợ kỹ thuật', 'Nhân viên IT', 'Nhân viên mạng', 'Nhân viên hệ thống', 'Nhân viên phần mềm', 'Nhân viên phần cứng', 'Nhân viên web', 'Nhân viên di động', 'Nhân viên game', 'Nhân viên AI', 'Nhân viên dữ liệu', 'Nhân viên bảo mật', 'Nhân viên',

        ];

        try {
            $request->validate([
                'code' => [
                    'required',
                    Rule::unique('positions', 'code')
                        ->where(fn($query) => $query->where('tenant_id', tenant('id'))),
                ],
                'name' => [
                    'required', 'string', 'max:255',
                    function ($attribute, $value, $fail) use ($allowedPositions) {
                        if (!in_array($value, $allowedPositions)) {
                            $fail('Chức vụ bạn nhập không hợp lệ.');
                        }
                        if (preg_match('/\s{2,}/', $value)) {
                            $fail('Khoảng trắng giữa các từ chỉ được 1 dấu cách.');
                        }
                    }
                ],
                'daily_salary' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            $data = $request->all();
            $data['tenant_id'] = tenant('id');
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['created_by'] = Auth::id();

            Position::create($data);

            return redirect()->route('admin.positions.index')
                ->with('success', 'Thêm chức vụ thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withErrors(['code' => 'Mã chức vụ này đã tồn tại trong công ty.'])->withInput();
            }
            throw $e;
        }
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
          $allowedPositions = [
            'Giám đốc', 'Phó Giám đốc', 'Trưởng phòng', 'Phó phòng',
            'Team Leader', 'Supervisor', 'Nhân viên', 'Chuyên viên',
            'Kỹ sư', 'Thư ký', 'Nhân viên hành chính', 'Nhân viên lễ tân',
            'Nhân viên kinh doanh', 'Chuyên viên marketing', 'Kế toán',
            'Kế toán trưởng', 'Nhân viên nhân sự', 'Trưởng phòng nhân sự',
            'Nhân viên IT', 'Kỹ sư phần mềm', 'Trưởng phòng IT',
            'Thực tập sinh', 'Bảo vệ', 'Nhân viên kho','Nhân viên','Chuyên viên',
            'Tạp vụ','Lái xe','Bếp trưởng','Phục vụ','Thu ngân','Nhân viên bán hàng','Nhân viên giao hàng',
            'Thực tập sinh', 'Bảo vệ', 'Nhân viên kho',
            'Chủ tịch', 'Phó chủ tịch', 'Giám đốc điều hành', 'CFO', 'CTO', 'COO','CEO',
            'Quản lý', 'Trợ lý', 'Kỹ thuật viên', 'Nhân viên hỗ trợ', 'Nhân viên phát triển', 'Nhân viên thiết kế', 'Nhân viên kiểm thử', 'Nhân viên bảo trì', 'Nhân viên nghiên cứu', 'Nhân viên phân tích', 'Nhân viên tư vấn', 'Nhân viên đào tạo', 'Nhân viên chăm sóc khách hàng', 'Nhân viên vận hành', 'Nhân viên logistics', 'Nhân viên mua hàng', 'Nhân viên xuất nhập khẩu',
            'Nhân viên pháp lý', 'Nhân viên truyền thông', 'Nhân viên sự kiện', 'Nhân viên quan hệ công chúng', 'Nhân viên phát triển kinh doanh', 'Nhân viên quản lý dự án', 'Nhân viên kiểm soát chất lượng', 'Nhân viên an ninh mạng', 'Nhân viên dữ liệu', 'Nhân viên AI', 'Nhân viên blockchain', 'Nhân viên IoT', 'Nhân viên thực tế ảo', 'Nhân viên thực tế tăng cường', 'Nhân viên điện toán đám mây', 'Nhân viên kỹ thuật số', 'Nhân viên chuyển đổi số', 'Nhân viên tự động hóa', 'Nhân viên robotics', 'Nhân viên in 3D', 'Nhân viên nano', 'Nhân viên sinh học', 'Nhân viên y tế', 'Nhân viên dược', 'Nhân viên giáo dục', 'Nhân viên xã hội', 'Nhân viên tâm lý', 'Nhân viên nghệ thuật', 'Nhân viên văn hóa', 'Nhân viên thể thao', 'Nhân viên du lịch', 'Nhân viên khách sạn', 'Nhân viên nhà hàng', 'Nhân viên sự kiện', 'Nhân viên giải trí', 'Nhân viên truyền hình', 'Nhân viên phát thanh', 'Nhân viên báo chí', 'Nhân viên xuất bản', 'Nhân viên quảng cáo', 'Nhân viên tiếp thị', 'Nhân viên bán hàng', 'Nhân viên dịch vụ khách hàng', 'Nhân viên hỗ trợ kỹ thuật', 'Nhân viên IT', 'Nhân viên mạng', 'Nhân viên hệ thống', 'Nhân viên phần mềm', 'Nhân viên phần cứng', 'Nhân viên web', 'Nhân viên di động', 'Nhân viên game', 'Nhân viên AI', 'Nhân viên dữ liệu', 'Nhân viên bảo mật', 'Nhân viên',
            
        ];

        try {
            $request->validate([
                'code' => [
                    'required',
                    Rule::unique('positions', 'code')
                        ->where(fn($query) => $query->where('tenant_id', tenant('id'))->where('id', '!=', $position->id)),
                ],
                'name' => [
                    'required', 'string', 'max:255',
                    function ($attribute, $value, $fail) use ($allowedPositions) {
                        if (!in_array($value, $allowedPositions)) {
                            $fail('Chức vụ bạn nhập không hợp lệ.');
                        }
                        if (preg_match('/\s{2,}/', $value)) {
                            $fail('Khoảng trắng giữa các từ chỉ được 1 dấu cách.');
                        }
                    }
                ],
                'daily_salary' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            $data = $request->all();
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['updated_by'] = Auth::id();

            $position->update($data);

            return redirect()->route('admin.positions.index')
                ->with('success', 'Cập nhật chức vụ thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withErrors(['code' => 'Mã chức vụ này đã tồn tại trong công ty.'])->withInput();
            }
            throw $e;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Position $position)
    {
        $position->forceDelete();
        return redirect()->route('admin.positions.index')
            ->with('success', 'Xóa chức vụ thành công!');
    }
}

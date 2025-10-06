
<div class="content-wrapper p-4 bg-light">
    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-primary mb-1">💰 Bảng lương toàn công ty</h4>
            <p class="text-muted mb-0">Tháng {{ $month }}/{{ $year }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Quay lại
        </a>
    </div>

    <!-- Bộ lọc tháng/năm -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tháng</label>
                    <select name="month" class="form-select">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>Tháng {{ $m }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Năm</label>
                    <select name="year" class="form-select">
                        @for ($y = 2023; $y <= now()->year; $y++)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i> Xem
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng dữ liệu -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-table"></i> Danh sách bảng lương
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Nhân viên</th>
                            <th>Chức vụ</th>
                            <th>Ngày công</th>
                            <th>Lương cơ bản</th>
                            <th>Thưởng</th>
                            <th>Phụ cấp</th>
                            <th>Trừ</th>
                            <th>Bảo hiểm</th>
                            <th>Tổng lương</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payrolls as $key => $p)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $p->employee->full_name ?? '---' }}</td>
                                <td>{{ $p->employee->position->name ?? '---' }}</td>
                                <td class="text-center">{{ $p->work_days }}</td>
                                <td class="text-end">{{ number_format($p->base_salary, 0, ',', '.') }} đ</td>
                                <td class="text-end text-success">{{ number_format($p->bonus, 0, ',', '.') }} đ</td>
                                <td class="text-end">{{ number_format($p->allowance, 0, ',', '.') }} đ</td>
                                <td class="text-end text-danger">{{ number_format($p->deduction, 0, ',', '.') }} đ</td>
                                <td class="text-end text-secondary">{{ number_format($p->insurance, 0, ',', '.') }} đ</td>
                                <td class="text-end fw-bold text-primary">{{ number_format($p->net_salary, 0, ',', '.') }} đ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3"></i><br>
                                    Không có dữ liệu bảng lương
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $payrolls->links('pagination::bootstrap-5') }}
    </div>
</div>

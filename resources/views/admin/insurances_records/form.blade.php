<div class="mb-3">
    <label for="employee_id" class="form-label">Nhân viên</label>
    <select name="employee_id" id="employee_id" class="form-select" required {{ isset($record) ? 'disabled' : '' }}>
        <option value="">-- Chọn nhân viên --</option>
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}"
                {{ isset($record) && $record->employee_id == $emp->id ? 'selected' : '' }}>
                {{ $emp->employee_code }} - {{ $emp->full_name }}
            </option>
        @endforeach
    </select>
    @if(isset($record))
        <input type="hidden" name="employee_id" value="{{ $record->employee_id }}">
    @endif
</div>

<div class="mb-3">
    <label class="form-label">Ngày tham gia</label>
    <input type="date" name="participation_date" class="form-control"
           value="{{ old('participation_date', $record->participation_date ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Trạng thái</label>
    <select name="status" class="form-select">
        <option value="active" {{ old('status', $record->status ?? '') == 'active' ? 'selected' : '' }}>Đang tham gia</option>
        <option value="inactive" {{ old('status', $record->status ?? '') == 'inactive' ? 'selected' : '' }}>Đã nghỉ</option>
        <option value="suspended" {{ old('status', $record->status ?? '') == 'suspended' ? 'selected' : '' }}>Tạm dừng</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Số BHXH</label>
    <input type="text" name="social_insurance_number" class="form-control"
           value="{{ old('social_insurance_number', $record->social_insurance_number ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Số BHYT</label>
    <input type="text" name="health_insurance_number" class="form-control"
           value="{{ old('health_insurance_number', $record->health_insurance_number ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Số BHTN</label>
    <input type="text" name="unemployment_insurance_number" class="form-control"
           value="{{ old('unemployment_insurance_number', $record->unemployment_insurance_number ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Ghi chú</label>
    <textarea name="notes" class="form-control">{{ old('notes', $record->notes ?? '') }}</textarea>
</div>

@extends('layouts.admin')

@section('content')
<h1>Tính lương dự kiến</h1>

<form id="calcForm">
    <div>
        <label>Nhân viên:</label>
        <select name="employee_id" id="employee_id">
            @foreach($employees as $employee)
                @if($employee->status == 'active')
                    <option value="{{ $employee->id }}">{{ $employee->employee_code }} - {{ $employee->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div>
        <label>Tháng:</label>
        <input type="month" name="pay_date" id="pay_date" value="{{ date('Y-m') }}">
    </div>
    <button type="submit">Tính</button>
</form>

<div id="result" style="margin-top:20px;display:none;">
    <p>Lương cơ bản: <span id="base_salary"></span></p>
    <p>Phụ cấp: <span id="allowance_total"></span></p>
    <p>Thưởng: <span id="bonus_total"></span></p>
    <p>Khấu trừ: <span id="deduction_total"></span></p>
    <p>Bảo hiểm: <span id="insurance_total"></span></p>
    <p>Lương thực lĩnh: <span id="net_salary"></span></p>
</div>

<script>
document.getElementById('calcForm').addEventListener('submit', function(e){
    e.preventDefault();
    let employee_id = document.getElementById('employee_id').value;
    let pay_date = document.getElementById('pay_date').value;

    fetch('{{ route("admin.payrolls.calc") }}', {
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({employee_id, pay_date})
    })
    .then(res=>res.json())
    .then(data=>{
        document.getElementById('result').style.display='block';
        document.getElementById('base_salary').innerText=data.base_salary;
        document.getElementById('allowance_total').innerText=data.allowance_total;
        document.getElementById('bonus_total').innerText=data.bonus_total;
        document.getElementById('deduction_total').innerText=data.deduction_total;
        document.getElementById('insurance_total').innerText=data.insurance_total;
        document.getElementById('net_salary').innerText=data.net_salary;
    });
});
</script>
@endsection

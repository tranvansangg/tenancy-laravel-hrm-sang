<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payroll;

    /**
     * Create a new message instance.
     */
    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $employee = $this->payroll->employee;

        // Kiểm tra email tồn tại
        if (empty($employee->email)) {
            throw new \Exception("Email nhân viên không tồn tại!");
        }

        // Format tên file PDF: Payroll_YYYY_MM.pdf
        $payMonth = $this->payroll->month;
        $payYear  = $this->payroll->year;
        $fileName = "Payroll_{$payYear}_{$payMonth}.pdf";

        // Tạo PDF
        $pdf = Pdf::loadView('admin.payrolls.pdf_single', [
            'payroll' => $this->payroll,
            'month'   => $payMonth,
            'year'    => $payYear
        ]);

        // Build mail
        return $this->to($employee->email)
                    ->subject("Bảng lương tháng {$payMonth}/{$payYear}")
                    ->view('admin.payrolls.mail')
                    ->attachData($pdf->output(), $fileName);
    }
}

    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('overtime_employee', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('overtime_id');
                $table->unsignedBigInteger('employee_id');
                $table->enum('status', [
                    'pending',           // chờ admin duyệt
                    'employee_declined', // nhân viên từ chối
                    'manager_declined',  // trưởng phòng chấp nhận từ chối
                    'approved',          // admin duyệt
                    'declined'           // admin từ chối
                ])->default('pending');
                $table->string('decline_reason')->nullable(); // lý do từ chối của nhân viên
                $table->timestamps();

                // foreign key
                $table->foreign('overtime_id')->references('id')->on('overtimes')->onDelete('cascade');
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('overtime_employee');
        }
    };

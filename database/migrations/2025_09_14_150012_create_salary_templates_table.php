<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTemplatesTable extends Migration {
    public function up() {
        Schema::create('salary_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('base_salary', 15,2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('salary_templates');
    }
}

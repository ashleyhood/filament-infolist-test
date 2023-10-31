<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();

            $table->foreignId('employment_advisor_id')->nullable()->constrained('users')->nullOnDelete(); // the employment advisor assigned

            $table->string('status', 20);

            $table->dateTime('discharged_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};

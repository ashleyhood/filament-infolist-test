<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('body');
            $table->string('type', 20)->nullable();
            $table->morphs('notable');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

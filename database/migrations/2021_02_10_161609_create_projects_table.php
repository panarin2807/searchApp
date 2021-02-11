<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en');
            $table->string('year');
            $table->string('advisor_joint')->nullable();
            $table->text('abstract')->nullable();
            // $table->string('file_front')->nullable();
            // $table->string('file_ch1')->nullable();
            // $table->string('file_ch2')->nullable();
            // $table->string('file_ch3')->nullable();
            // $table->string('file_ch4')->nullable();
            // $table->string('file_ch5')->nullable();
            // $table->string('file_back')->nullable();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('curricula_id')->constrained('curricula');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

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
        Schema::create('task_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->references('id')
                ->on('tasks')->onDelete('cascade');
            $table->unsignedBigInteger('participant_id')->references('id')
                ->on('participants')->onDelete('cascade');
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
        Schema::dropIfExists('task_participants');
    }
};

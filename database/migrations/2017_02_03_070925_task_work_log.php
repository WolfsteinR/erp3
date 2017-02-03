<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskWorkLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_work_log', function(Blueprint $table){
            $table->increments('id');
            $table->integer('id_task');
            $table->string('status_work');
            $table->text('comment');
            $table->dateTime('created_at');
            $table->string('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task_work_log');
    }
}

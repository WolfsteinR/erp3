<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // posts tasks
        Schema::create('tasks', function(Blueprint $table){
            $table->increments('id'); // table Id's
            $table->integer('author_id')->unsigned()->default(0);
            $table->foreign('author_id')
                ->references('id')->on('users');
            $table->integer('spec_id')->unsigned()->default(0);
            $table->foreign('spec_id')
                ->references('id')->on('users');
                //->onDelete('cascade');
            $table->integer('upload_id')->unsigned()->default(0);
            $table->foreign('upload_id')
                ->references('id')->on('upload');
            $table->string('title')->unique();
            $table->text('body'); // our tasks
            $table->boolean('hide_body');
            $table->string('website');
            $table->text('desc_manager')->nullable(); // comments by manager about task
            $table->enum('priority', ['low','medium','high']); // priority task
            $table->string('time_limit')->nullable();// time limit for task from manager
            $table->time('time')->nullable(); // time what working our task
            $table->string('slug')->unique();
            $table->boolean('active');
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
        Schema::drop('tasks');
    }
}

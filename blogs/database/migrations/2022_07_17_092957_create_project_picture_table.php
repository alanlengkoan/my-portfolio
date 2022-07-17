<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_picture', function (Blueprint $table) {
            $table->increments('id_project_picture');
            $table->integer('id_project')->unsigned()->nullable();
            $table->string('picture', 100)->nullable();
            $table->integer('by_users')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_project')->references('id_project')->on('project')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['id_project']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_picture');
    }
}

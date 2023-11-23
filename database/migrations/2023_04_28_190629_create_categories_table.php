<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('类型名称');
            $table->tinyInteger('pid')->default(0)->comment('父级id');
            $table->tinyInteger('status')->default(1)->comment('启用状态 0：禁用 1：启用');
            $table->tinyInteger('level')->default(1)->comment('类型级别 1 2 3');
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
        Schema::dropIfExists('categories');
    }
}

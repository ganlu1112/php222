<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('g_name')->comment('商品名');
            $table->string('desc')->comment('商品描述');
            $table->integer('c_id')->comment('所属分类');
            $table->integer('price')->comment('价格');
            $table->integer('stock')->comment('库存');
            $table->string('cover')->comment('封面图');
            $table->json('pics')->comment('小图集');
            $table->tinyInteger('is_on')->default(0)->comment('是否上架 0：否 1：是');
            $table->tinyInteger('is_recommend')->default(0)->comment('是否推荐 0：否 1：是');
            $table->integer('user_id')->comment('创建者');
            $table->text('detail')->comment('详情');
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
        Schema::dropIfExists('goods');
    }
}

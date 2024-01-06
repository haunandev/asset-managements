<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->text('memo')->nullable();
            $table->text('specification')->nullable();
            $table->foreignId('manufacturer_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('sub_category_id')->nullable();
            $table->text('image')->nullable();
            $table->string('currency')->nullable();
            $table->integer('price')->nullable();
            $table->string('packaging')->nullable();
            $table->integer('weight')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

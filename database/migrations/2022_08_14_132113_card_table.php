<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function ($table) {
            $table->integer("price")->default(0);
        });
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id")->nullable();
            $table->integer("quantity")->default(0);
            $table->unsignedBigInteger("user_id")->nullable();
            $table->integer("total_price")->default(0);
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
        Schema::dropIfExists('cards');
        Schema::table('products', function ($table) {
            $table->dropColumn('price');
        });
    }
}

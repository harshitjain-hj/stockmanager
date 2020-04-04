<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('item_name');
            $table->bigInteger('mobile_no')->nullable();
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('monthly_amount');
            $table->text('floor');
            $table->text('block');
            $table->date('storage_date');
            $table->unsignedInteger('remain_qty');
            $table->date('payable_amount');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('stores');
    }
}

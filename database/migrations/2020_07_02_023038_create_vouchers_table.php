<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('voucher_type');
            $table->unsignedBigInteger('customer_id');
            $table->json('item_data')->nullable();
            $table->json('asset_data')->nullable();
            $table->unsignedInteger('total_amount')->nullable();
            $table->unsignedInteger('amount_recieved')->nullable();
            $table->json('assets_recieved')->nullable();
            $table->json('outstanding')->nullable();
            $table->text('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}

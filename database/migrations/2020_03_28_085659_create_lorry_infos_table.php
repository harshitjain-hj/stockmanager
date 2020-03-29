<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLorryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lorry_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('total_weight');
            $table->unsignedInteger('arrived_unit');
            $table->unsignedInteger('created_unit');
            $table->unsignedInteger('purchase_cost');
            $table->unsignedInteger('labour_cost')->nullable();
            $table->unsignedInteger('lorry_cost')->nullable();
            $table->unsignedInteger('lorry_no')->nullable();
            $table->unsignedInteger('unit_returned')->nullable();
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
        Schema::dropIfExists('lorry_infos');
    }
}

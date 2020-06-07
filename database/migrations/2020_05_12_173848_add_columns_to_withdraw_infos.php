<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWithdrawInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('bill_no')->nullable()->after('store_id');
            $table->text('description')->nullable()->after('lorry_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_infos', function (Blueprint $table) {
            //
        });
    }
}

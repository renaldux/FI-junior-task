<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->bigIncrements('transfer_no');
            $table->string('payer_account_no');
            $table->string('recipient_account_no');
            $table->string('amount');
            $table->timestamps();

            $table->foreign('payer_account_no')->references('account_no')->on('accounts')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->string('billing_address');
            $table->string('billing_country');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_postal_code');
            $table->string('shipping_address');
            $table->string('shipping_country');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_postal_code');
            $table->string('cc_first_name');
            $table->string('cc_last_name');
            $table->string('cc_phone')->nullable();
            $table->string('subtotal');
            $table->string('tax');
            $table->string('discount')->default(0);
            $table->string('discount_code')->nullable();
            $table->string('total');
            $table->string('payment_gateway');
            $table->string('transaction_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_first_six_digits')->nullable();
            $table->string('card_last_four_digits')->nullable();
            $table->string('shipped')->default(false);
            $table->string('error')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

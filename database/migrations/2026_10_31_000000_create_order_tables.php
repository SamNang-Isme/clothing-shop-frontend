<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordertbl', function (Blueprint $table) {
            $table->id('orderid');
            $table->string('invoice_no')->unique();
            $table->string('customer_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->text('address');
            $table->text('note')->nullable();
            $table->decimal('total', 12, 2);
            $table->string('status')->default('Pending');
            $table->timestamps();
        });

        Schema::create('orderitemtbl', function (Blueprint $table) {
            $table->id('itemid');
            $table->unsignedBigInteger('orderid')->index();
            $table->unsignedBigInteger('proid');
            $table->string('proname');          // snapshot, so old invoices never change
            $table->decimal('price', 12, 2);    // snapshot
            $table->unsignedInteger('qty');
            $table->decimal('subtotal', 12, 2);

            $table->foreign('orderid')->references('orderid')->on('ordertbl')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orderitemtbl');
        Schema::dropIfExists('ordertbl');
    }
};

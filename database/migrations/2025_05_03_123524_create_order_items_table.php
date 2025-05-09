<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('tenant_id'); // multi tenancy
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity');

            $table->decimal('product_price', 10, 2);
            $table->decimal('product_taxes', 10, 2);
            $table->decimal('product_total', 10, 2);

            $table->timestamps();
            // $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade'); // multi tenancy
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('tenant_id'); // multi tenancy

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //$table->foreignId('shipment_id')->nullable()->constrained()->onDelete('set null');

            // Order klant gegevens
            $table->string('order_email');
            $table->string('order_name');
            //$table->string('order_address');
            //$table->string('order_bus')->nullable();
            //$table->string('order_postcode');
            //$table->string('order_city');

            // Order status
            $table->string('order_status')->default('pending'); // pending, paid, shipped, cancelled

            // Prijzen
            $table->decimal('order_taxes', 10, 2)->default(0);
            $table->decimal('order_total', 10, 2)->default(0);
            //$table->decimal('order_total_with_ship', 10, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade'); // multi tenancy
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

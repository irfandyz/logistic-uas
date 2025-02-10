<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->integer('price');
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('incoming_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->date('date_received');
            $table->timestamps();
        });

        Schema::create('incoming_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_item_id')->constrained('incoming_items')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });

        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('invoice_number');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('shipping_id')->constrained('shippings')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('outgoing_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outgoing_item_id')->constrained('outgoing_items')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('price');
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
        Schema::dropIfExists('outgoing_item_details');
        Schema::dropIfExists('outgoing_items');
        Schema::dropIfExists('incoming_item_details');
        Schema::dropIfExists('incoming_items');
        Schema::dropIfExists('items');
    }
};

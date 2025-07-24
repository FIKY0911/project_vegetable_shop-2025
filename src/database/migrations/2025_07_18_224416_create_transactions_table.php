<?php

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(Product::class);
            $table->enum('payment_type', ['dana', 'gopay', 'cash', 'qris']);
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->date('transaction_date')->default(DB::raw('CURRENT_DATE'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

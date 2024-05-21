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
        Schema::create('products', function (Blueprint $table) {
            $currencies = config('constants.currencies');
            $admin_approval = config('constants.admin_approval');

            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('unit_price', 20, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->comment('rate in decimal, not percentage');
            $table->decimal('weight', 10, 0)->nullable();
            $table->decimal('rating', 8, 2)->nullable();
            $table->enum('currency', $currencies::toArray())->default($currencies::NGN->value);
            $table->enum('admin_approval', $admin_approval::toArray())->default($admin_approval::Approved->value);
            $table->longText('description')->nullable();
            $table->string('logo', 150)->nullable();
            $table->json('images')->nullable();
            $table->string('thumbnail_img', 100)->nullable();
            $table->json('tags')->nullable();
            $table->enum('live', ['On', 'Off'])->default('On');
            $table->boolean('published')->default(true);
            $table->boolean('refundable')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

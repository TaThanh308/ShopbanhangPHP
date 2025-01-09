<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_phone');
            $table->decimal('total_price', 8, 2);
            $table->string('payment_method')->default('cash'); // Thêm cột payment_method
            $table->string('status')->default('đang chờ xét duyệt'); // Cột status với giá trị mặc định
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
        Schema::table('orders', function (Blueprint $table) {
            // Xóa cột user_id nếu rollback migration
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};


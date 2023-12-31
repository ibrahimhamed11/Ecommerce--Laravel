<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->json('products');
            $table->decimal('total_price', 8, 2);
            $table->string('address');
            $table->string('user_name'); // Add this line
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('status');
            $table->timestamps();



             // Add user_id column as a foreign key
             $table->unsignedBigInteger('user_id');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
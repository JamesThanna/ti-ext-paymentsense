<?php

namespace Miorder\Paymentsense\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Admin\Models\Orders_model;
use DB;
class CreateOrderPaymentTracker extends Migration
{
    public function up()
    {
            Schema::create('payment_sense', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('order_number');
                $table->string('payment_sense_id');
                $table->string('token');
                $table->string('action');
                $table->string('completed')->nullable();
                $table->string('completed_responce')->nullable();
              $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
              $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
            });
        

    }

    public function down()
    {
        Schema::dropIfExists('payment_sense');
    }
  
  
   public function order()
    {
        return $this->hasOne(Orders_model::class, 'id', 'order_id');
    }
  
}
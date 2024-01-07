<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_no')->unique();
            $table->foreignId('vendor_id');
            $table->foreignId('purpose_id')->nullable();
            $table->text('memo')->nullable();
            $table->text('payment_terms')->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->integer('general_discount')->nullable()->default(0);
            $table->integer('taxable_nett_value')->nullable();
            $table->integer('vat')->nullable();
            $table->integer('grand_value')->nullable()->default(0);
            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('manager_approval_by')->nullable();
            $table->foreignId('manager_approval_time')->nullable();
            $table->foreignId('finance_approval_by')->nullable();
            $table->foreignId('finance_approval_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}

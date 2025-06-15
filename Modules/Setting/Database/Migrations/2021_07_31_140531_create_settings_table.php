<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('company_wa')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('small_logo')->nullable();
            $table->integer('default_currency_id');
            $table->string('default_currency_position');
            $table->string('notification_email');
            $table->string('sidebar_link')->nullable();
            $table->string('sidebar_link_hover')->nullable();
            $table->string('bg_sidebar')->nullable();
            $table->string('bg_sidebar_hover')->nullable();
            $table->string('bg_sidebar_aktif')->nullable();
            $table->string('bg_sidebar_link')->nullable();
            $table->string('bg_sidebar_link_hover')->nullable();
            $table->string('link_sidebar_aktif')->nullable();
            $table->string('link_color')->nullable();
            $table->string('link_hover')->nullable();
            $table->string('header_color')->nullable();
            $table->string('btn_color')->nullable();
            $table->string('btn_cancel')->nullable();
            $table->string('btn_sukses')->nullable();
            $table->integer('product_tax')->default(0);
            $table->integer('product_tax_type')->default(0);
            $table->integer('pos_tax')->default(0);
            $table->integer('pos_discount')->default(0);
            $table->integer('pos_shipping')->default(0);
            $table->integer('module_purchases')->default(0);
            $table->integer('module_purchase_returns')->default(0);
            $table->integer('module_quotations')->default(0);
            $table->integer('module_expenses')->default(0);
            $table->integer('module_sale-returns')->default(0);
            $table->text('footer_text');
            $table->text('company_address');
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
        Schema::dropIfExists('settings');
    }
}

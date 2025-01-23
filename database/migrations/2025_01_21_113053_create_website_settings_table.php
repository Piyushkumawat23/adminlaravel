<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('site_name')->nullable(false); // Website name
            $table->string('site_url')->nullable(false); // Website URL
            $table->string('contact_email')->nullable(false); // Contact email
            $table->string('support_email')->nullable(); // Support email
            $table->string('phone_number')->nullable(); // Contact number
            $table->text('address')->nullable(); // Office address
            $table->text('footer_text')->nullable(); // Footer text
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_settings');
    }
}

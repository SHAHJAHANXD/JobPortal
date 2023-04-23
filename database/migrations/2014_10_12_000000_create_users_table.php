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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('wa_no')->unique()->nullable();
            $table->string('password')->nullable();
            $table->text('views')->default(0);
            $table->string('code')->nullable();
            $table->string('password_code')->nullable();
            $table->string('role')->nullable();
            $table->longText('about_me')->nullable();
            $table->longText('language')->nullable();
            $table->string('availability')->nullable();
            $table->string('age')->nullable();
            $table->longText('location')->nullable();
            $table->string('experience')->nullable();
            $table->string('avatar')->nullable();
            $table->string('designation')->nullable();
            $table->string('status')->default(1);
            $table->string('profile')->default(0);
            $table->string('account_status')->default(1);
            $table->string('email_status')->default(0);
            $table->string('c_name')->nullable();
            $table->string('c_email')->nullable();
            $table->string('c_position')->nullable();
            $table->string('c_phone')->nullable();
            $table->string('c_about_us')->nullable();
            $table->string('c_image')->nullable();
            $table->string('c_website')->nullable();
            $table->string('c_revenue')->nullable();
            $table->string('c_location')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

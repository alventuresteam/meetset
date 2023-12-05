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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('port')->nullable();
            $table->string('logo')->nullable();
            $table->string('file')->nullable();
            $table->string('ldap_host')->nullable();
            $table->string('ldap_username')->nullable();
            $table->string('ldap_password')->nullable();
            $table->string('ldap_port')->nullable();
            $table->string('ldap_base_dn')->nullable();
            $table->string('ldap_timeout')->nullable();
            $table->string('kiosk_password')->nullable();
            $table->longText('login_text')->nullable();
            $table->boolean('checked_invited')->default(false);
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
};

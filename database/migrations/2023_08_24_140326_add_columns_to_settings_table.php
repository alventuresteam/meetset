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
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ldap_host')->nullable();
            $table->string('ldap_username')->nullable();
            $table->string('ldap_password')->nullable();
            $table->string('ldap_port')->nullable();
            $table->string('ldap_base_dn')->nullable();
            $table->string('ldap_timeout')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('ldap_host');
            $table->dropColumn('ldap_username');
            $table->dropColumn('ldap_password');
            $table->dropColumn('ldap_port');
            $table->dropColumn('ldap_base_dn');
            $table->dropColumn('ldap_timeout');
        });
    }
};

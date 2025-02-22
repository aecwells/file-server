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
        Schema::create('smb_hosts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('host');
            
            $table->string('username');
            $table->string('password');
            $table->string('remote_path'); // Add this line
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smb_hosts');
    }
};

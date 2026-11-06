<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabla: user
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 120)->unique();
            $table->string('password_hash', 512);
            $table->string('role', 40);
        });

        DB::statement("ALTER TABLE "user" ADD CONSTRAINT ck_user_role CHECK (role IN ('admin', 'librarian'));");

        // 2. Tabla: category
        Schema::create('category', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 120)->unique();
        });

        DB::table('category')->insert([
            ['id' => '11111111-1111-4111-8111-111111111111', 'name' => 'Novela'],
            ['id' => '22222222-2222-4222-8222-222222222222', 'name' => 'Ciencia'],
            ['id' => '33333333-3333-4333-8333-333333333333', 'name' => 'Tecnología'],
            ['id' => '44444444-4444-4444-8444-444444444444', 'name' => 'Historia'],
            ['id' => '55555555-5555-4555-8555-555555552222', 'name' => 'Infantil'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('category');
        Schema::dropIfExists('user');
    }
};

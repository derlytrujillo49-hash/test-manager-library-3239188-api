<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 3. Tabla: book
        Schema::create('book', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 250);
            $table->string('author', 200);
            $table->char('isbn', 13);
            $table->uuid('category_id');
            $table->integer('total_copies');
            $table->integer('available_copies');
            $table->string('cover_key', 512)->nullable();
            $table->timestampTz('deleted_at')->nullable();

            $table->foreign('category_id')->references('id')->on('category')->onDelete('restrict');
        });

        DB::statement('ALTER TABLE book ADD CONSTRAINT ck_book_available_range CHECK (available_copies >= 0 AND available_copies <= total_copies);');
        DB::statement('CREATE UNIQUE INDEX book_isbn_active_unique ON book (isbn) WHERE deleted_at IS NULL;');
        DB::statement('CREATE INDEX idx_book_category_title ON book (category_id, title) WHERE deleted_at IS NULL;');

        // 4. Tabla: member
        Schema::create('member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name', 200);
            $table->string('document_number', 30)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member');
        Schema::dropIfExists('book');
    }
};

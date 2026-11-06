<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 5. Tabla: loan
        Schema::create('loan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('member_id');
            $table->uuid('loaned_by_user_id');
            $table->timestampTz('loaned_at');

            $table->foreign('member_id')->references('id')->on('member')->onDelete('restrict');
            $table->foreign('loaned_by_user_id')->references('id')->on('user')->onDelete('restrict');
        });

        // 6. Tabla: loan_item
        Schema::create('loan_item', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('loan_id');
            $table->uuid('book_id');
            $table->string('book_title', 250);
            $table->char('isbn', 13);
            $table->string('category_name', 120);
            $table->timestampTz('due_at');
            $table->timestampTz('returned_at')->nullable();

            $table->foreign('loan_id')->references('id')->on('loan')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('book')->onDelete('restrict');
            $table->unique(['loan_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_item');
        Schema::dropIfExists('loan');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penulis_id')
                ->constrained('penulis')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->string('isbn')->unique();
            $table->year('tahun_terbit');
            $table->unsignedInteger('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('cover_path')->nullable();
            $table->string('ebook_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};

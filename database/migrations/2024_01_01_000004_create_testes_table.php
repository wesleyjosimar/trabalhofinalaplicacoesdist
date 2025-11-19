<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atleta_id')->constrained('atletas')->onDelete('cascade');
            $table->date('data_coleta');
            $table->string('competicao')->nullable();
            $table->string('laboratorio');
            $table->enum('resultado', ['pendente', 'negativo', 'positivo'])->default('pendente');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testes');
    }
};


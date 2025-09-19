<?php

// database/migrations/AAAA_MM_DD_HHMMSS_create_sublistado_contratistas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSublistadoContratistasTable extends Migration
{
    public function up()
    {
        Schema::create('sublistados_contratistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contratista_id')->constrained('contratistas')->onDelete('cascade');
            $table->foreignId('catalogo_id')->nullable()->constrained('catalogos')->onDelete('set null');
            $table->foreignId('extraordinario_id')->nullable()->constrained('extraordinarios')->onDelete('set null');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublistados_contratistas');
    }
}
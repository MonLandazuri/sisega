<?php

// database/migrations/..._create_anticipos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnticiposTable extends Migration
{
    public function up()
    {
        Schema::create('anticipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyecto')->constrained('proyectos')->onDelete('cascade');
            $table->foreignId('id_contratista')->constrained('contratistas')->onDelete('cascade');
            $table->decimal('porcentaje', 5, 2); // Porcentaje de anticipo, por ejemplo 20.00%
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anticipos');
    }
}
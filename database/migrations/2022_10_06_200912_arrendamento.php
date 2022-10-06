<?php

use App\Models\pessoa;
use App\Models\propriedade;
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
        Schema::create('arrendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(propriedade::class);
            $table->foreignIdFor(pessoa::class);
            $table->date('data_Inicio');
            $table->string('duracao');
            $table->string('estado')->default('Em curso');
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
        Schema::dropIfExists('arrendamentos');
    }
};

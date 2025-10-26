<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('table_id')->nullable(false);
            $table->string('category')->nullable();
            $table->string('part_no')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('po_number')->nullable();
            $table->string('vsl')->nullable();
            $table->string('bl_num')->nullable();
            $table->date('etd')->nullable();
            $table->date('revised_etd')->nullable();
            $table->date('eta')->nullable();
            $table->date('revised_eta')->nullable();
            $table->date('cleared_date')->nullable();
            $table->date('container_no')->nullable();
            $table->date('no_of_cantainer')->nullable();
            $table->date('location')->nullable();
            $table->date('clearing_agent')->nullable();
            $table->date('cusdec_ref')->nullable();
            $table->date('reason_for_kpi_failure')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_rows');
    }
};

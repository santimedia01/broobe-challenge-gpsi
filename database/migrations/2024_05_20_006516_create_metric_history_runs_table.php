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
        Schema::create('metric_history_runs', function (Blueprint $table) {
            $table->id();

            $table->string('url');

            $table->unsignedBigInteger('strategy_id');
            $table->foreign('strategy_id')->references('id')->on('strategies');

            $table->float('accessibility_metric')->nullable();
            $table->float('pwa_metric')->nullable();
            $table->float('performance_metric')->nullable();
            $table->float('seo_metric')->nullable();
            $table->float('best_practices_metric')->nullable();

            $table->boolean('saved')->nullable()->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metric_history_runs');
    }
};

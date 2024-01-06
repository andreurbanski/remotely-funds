<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fund_company', function (Blueprint $table) {
            $table->uuid("id");
            $table->uuid("company_id");
            $table->uuid("fund_id");

            $table->foreign("company_id")->references("id")->on("company");
            $table->foreign("fund_id")->references("id")->on("funds");

            $table->primary("id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_company');
    }
};

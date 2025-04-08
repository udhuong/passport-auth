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
        Schema::create('oauth_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resource');
            $table->string('scope')->index('idx_scope');

            $table->unique(['resource', 'scope'], 'uq_resource_scope');
            $table->comment('Scope tương ứng với resource, dùng để phân quyền cho client');
        });

        Schema::create('oauth_client_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('client_id');
            $table->integer('scope_id')->unsigned();

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade');
            $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
            $table->comment('Đánh dấu xem các client nào có quyền truy cập vào scope nào');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oauth_scopes');
        Schema::dropIfExists('oauth_client_scopes');
    }
};

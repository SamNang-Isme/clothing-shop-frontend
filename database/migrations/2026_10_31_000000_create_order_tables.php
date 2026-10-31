<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorytbl', function (Blueprint $t) {
            $t->id('cateid');
            $t->string('catetitle');
            $t->text('description')->nullable();
            $t->string('status')->default('Active');
            $t->timestamps();
            $t->text('img')->nullable();
        });

        Schema::create('producttbl', function (Blueprint $t) {
            $t->id('proid');
            $t->unsignedBigInteger('cateid')->index();
            $t->string('proname');
            $t->integer('qty')->default(0);
            $t->double('price')->default(0);
            $t->text('img1')->nullable();
            $t->text('img2')->nullable();
            $t->text('img3')->nullable();
            $t->text('img4')->nullable();
            $t->timestamps();
        });

        Schema::create('settingtbl', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('img1')->nullable();
            $t->text('description')->nullable();
            $t->string('type');
            $t->string('status')->default('Active');
            $t->timestamps();
        });

        Schema::create('pagetbl', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('img1')->nullable();
            $t->text('description')->nullable();
            $t->text('content')->nullable();
            $t->string('status')->default('Active');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagetbl');
        Schema::dropIfExists('settingtbl');
        Schema::dropIfExists('producttbl');
        Schema::dropIfExists('categorytbl');
    }
};
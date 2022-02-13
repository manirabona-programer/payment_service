<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->default(Role::USER)->after('id');
            $table->integer('royalty_points')->default(0)->after('password');
            $table->boolean('is_member')->default(false)->after('royalty_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('roles');
        Schema::table('users', function (Blueprint $table) {
            Schema::dropColumns('role_id');
            Schema::dropColumns('royalty_points');
            Schema::dropColumns('is_member');
        });
    }
}
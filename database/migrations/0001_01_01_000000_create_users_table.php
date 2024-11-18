<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_name');
            $table->timestamps();
        });

        // Insertar datos en la tabla departments
        DB::table('departments')->insert([
            ['department_name' => 'Ingeniería y Arquitectura'],
        ]);

        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('career_name');
            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // Insertar datos en la tabla careers
        DB::table('careers')->insert([
            ['career_name' => 'Ingeniería de Sistemas Informáticos', 'department_id' => 1],
        ]);

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->timestamps();
        });

        // Insertar datos en la tabla roles
        DB::table('roles')->insert([
            ['role_name' => 'admin'],
            ['role_name' => 'user'],
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('career_id')
                ->constrained('careers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('remote_user_id');
//            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('roles_id')
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
//            $table->rememberToken();
            $table->timestamps();
        });

        $this->init();

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function init() {
        // Buscar el nombre "admin", o el id 1:
        $rol = DB::table('users')->where('roles_id', 1)->first();
        if ($rol) {
            return response()->json([
                "message" => "Base de datos ya inicializada",
                "success" => false
            ]);
        }

        $user = new User();
        $user->name = "admin";
        $user->email = "admin@admin.com";
        $user->password = Hash::make(env("ADMIN_PASSWORD"));
        $user->career_id = '1';
        $user->roles_id = '1';
        $user->remote_user_id = '0'; // <- No se usa en la aplicación
        $user->save();

        return response()->json([
            "message" => "Base de datos inicializada",
            "success" => true
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('careers');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

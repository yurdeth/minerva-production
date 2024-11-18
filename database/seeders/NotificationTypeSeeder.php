<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class NotificationTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run(): void {
        try {
            NotificationType::create(['type' => 'Recuperación de contraseña olvidada']);
            NotificationType::create(['type' => 'Solicitud de clave de acceso por defecto']);
            NotificationType::create(['type' => 'Otra']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

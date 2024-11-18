<?php

namespace Database\Seeders;

use App\Models\Careers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CareersSeeder extends Seeder {
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void {
        try {
            $careers = $this->readJsonCareers();
            foreach ($careers as $career) {
                Careers::create($career);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // O puedes lanzar la excepción si prefieres que falle el seeder
            throw $e;
        }
    }

    private function readJsonCareers(): array {
        $jsonCareers = file_get_contents(base_path('/careers.json'));

        // Verifica si el archivo fue leído correctamente
        if ($jsonCareers === false) {
            throw new \Exception('Archivo no encontrado o error al leerlo');
        }

        $departmentsArray = json_decode($jsonCareers, true);

        // Verifica si hay errores al decodificar JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }

        return $departmentsArray['careers']; // Retorna solo el array de departamentos
    }
}

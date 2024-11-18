<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DepartmentsSeeder extends Seeder {
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void {
        try {
            $departments = $this->readJsonDepartments();
            foreach ($departments as $department) {
                Departments::create($department);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // O puedes lanzar la excepción si prefieres que falle el seeder
            throw $e;
        }
    }

    private function readJsonDepartments(): array {
        $jsonDepartments = file_get_contents(base_path('/departments.json'));

        // Verifica si el archivo fue leído correctamente
        if ($jsonDepartments === false) {
            throw new \Exception('Archivo no encontrado o error al leerlo');
        }

        $departmentsArray = json_decode($jsonDepartments, true);

        // Verifica si hay errores al decodificar JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }

        return $departmentsArray['departments']; // Retorna solo el array de departamentos
    }
}

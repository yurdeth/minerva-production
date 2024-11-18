<?php

namespace App\Services;

use App\Enum\ValidationTypeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ValidateUpdateService extends ValidationService {

    protected $request;
    protected $validationType;

    public function __construct($request, $validationType) {
        parent::__construct($request, $validationType);
        $this->request = $request;
        $this->validationType = $validationType;
    }

    public function ValidateRequest(): ?JsonResponse {

        if ($this->validationType == ValidationTypeEnum::DEPARTMENT) {
            return $this->validateDepartmentName($this->request->department_name);
        }

        if ($this->validationType == ValidationTypeEnum::CAREER) {
            return $this->validateCareerName($this->request->career_name);
        }

        return null;
    }

    protected function errorResponse($message): JsonResponse {
        return response()->json([
            'message' => $message,
            'success' => false
        ]);
    }

    protected function validateDepartmentName($departmentName): ?JsonResponse {
        $response = parent::validateDepartmentName($departmentName);
        if ($response) {
            return $response;
        }

        return $this->departmentExists($departmentName);
    }

    private function departmentExists($departmentName): ?JsonResponse {
        $department = DB::table('departments')->where('department_name', $departmentName)->first();
        if ($department) {
            return $this->errorResponse("Este departamento ya está registrado");
        }

        return null;
    }

    protected function validateCareerName($careerName): ?JsonResponse {
        $response = parent::validateCareerName($careerName);
        if ($response) {
            return $response;
        }

        if (strlen($this->request->career_name) > 0 && strlen(trim($this->request->career_name)) == 0){
            return $this->errorResponse("Ingrese el nombre de la carrera");
        }

        return $this->careerExists($careerName);
    }

    private function careerExists($careerName): ?JsonResponse {
        $currentCareer = DB::table('careers')
            ->where('id', $this->request->career_id)
            ->first();

        if ($currentCareer && $currentCareer->career_name === $careerName) {
            return null;
        }

        $careerExists = DB::table('careers')
            ->where('department_id', $this->request->department_id)
            ->where('career_name', $careerName)
            ->exists();

        if ($careerExists) {
            return $this->errorResponse("La carrera ya existe");
        }

        return null;
    }
}

<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

use App\Enum\ValidationTypeEnum;

class ValidationService {

    protected $request;
    protected $validationType;

    public function __construct($request, $validationType) {
        $this->request = $request;
        $this->validationType = $validationType;
    }

    public function ValidateRequest(): ?JsonResponse {
        if ($this->validationType == ValidationTypeEnum::REGISTER_USER || $this->validationType == ValidationTypeEnum::UPDATE_USER) {
            return $this->validateRegister();
        }

        if ($this->validationType == ValidationTypeEnum::DEPARTMENT) {
            return $this->validateDepartmentName($this->request->department_name);
        }

        if ($this->validationType == ValidationTypeEnum::CAREER) {
            return $this->validateCareerName($this->request->career_name);
        }

        if ($this->validationType == ValidationTypeEnum::NOTIFICATION) {
            return $this->validateNotificationRequest();
        }

        return null;
    }

    protected function errorResponse($message): JsonResponse {
        return response()->json([
            'message' => $message,
            'success' => false
        ]);
    }

    protected function validateRegister(): ?JsonResponse {
        if (!$this->request->name && !$this->request->email && !$this->request->career &&
            !$this->request->password && !$this->request->password_confirmation) {
            return $this->errorResponse("Todos los campos son requeridos");
        }

        if (!$this->request->name) {
            return $this->errorResponse("El nombre es requerido");
        }

        // No permitir numeros en el campo nombre en ningun lado:
        if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/", $this->request->name)) {
            return $this->errorResponse("No se permite el uso de números ni caracteres especiales en el nombre");
        }

        if (is_numeric($this->request->name)) {
            return $this->errorResponse("El nombre no puede ser un valor numérico");
        }

        if (strlen($this->request->name) < 3) {
            return $this->errorResponse("El nombre debe tener al menos 3 caracteres");
        }

        if (!$this->request->email) {
            return $this->errorResponse("El correo es requerido");
        }

        if (is_numeric($this->request->email)) {
            return $this->errorResponse("El correo no puede ser un valor numérico");
        }

        if(strlen(explode("@", $this->request->email)[0]) < 5) {
            return $this->errorResponse("El correo no coincide con los formatos permitidos");
        }

        if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ@.1234567890 ]*$/", $this->request->email)) {
            return $this->errorResponse("No se permite el uso de caracteres especiales en el correo");
        }

        if (substr_count($this->request->email, '@') != 1) {
            return $this->errorResponse("El correo debe contener exactamente una arroba (@)");
        }

        if (substr_count($this->request->email, '.') > 3) {
            return $this->errorResponse("El correo debe contener un máximo de tres puntos (.)");
        }

        if (!$this->request->career) {
            return $this->errorResponse("Seleccione su carrera");
        }

        if($this->validationType != ValidationTypeEnum::UPDATE_USER){
            if (!$this->request->password) {
                return $this->errorResponse("La contraseña es requerido");
            }

            if (!$this->request->password_confirmation) {
                return $this->errorResponse("La confirmación de la contraseña es requerida");
            }
        }

        if ($this->request->password != $this->request->password_confirmation) {
            return $this->errorResponse("Las contraseñas no coinciden");
        }

        return null;
    }
    protected function validateNotificationRequest(): ?JsonResponse {

        if (is_numeric($this->request->email)) {
            return $this->errorResponse("El correo no puede ser un valor numérico");
        }

        if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ@.1234567890 ]*$/", $this->request->email)) {
            return $this->errorResponse("No se permite el uso de caracteres especiales en el correo");
        }

        if (substr_count($this->request->email, '@') > 1) {
            return $this->errorResponse("El correo debe contener exactamente una arroba (@)");
        }

        if (substr_count($this->request->email, '.') > 3) {
            return $this->errorResponse("El correo debe contener un máximo de tres puntos (.)");
        }
        return null;
    }


    protected function validateDepartmentName($departmentName): ?JsonResponse {
        $maxLength = 50;

        if (is_numeric($departmentName)) {
            return $this->errorResponse('Error: el nombre del departamento no puede ser un valor numérico');
        }

        if (strlen($departmentName) > $maxLength) {
            return $this->errorResponse('Error: el nombre del departamento no puede exceder los ' . $maxLength . ' caracteres');
        }

        if (strlen($departmentName) < 5) {
            return $this->errorResponse('Error: el nombre del departamento debe tener al menos 5 caracteres');
        }

        if ($departmentName == null) {
            return $this->errorResponse('Error: el nombre del departamento no puede estar vacío');
        }

        if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $departmentName)) {
            return $this->errorResponse('Error: el nombre del departamento no puede contener símbolos o caracteres especiales, excepto las tildes.');
        }

        return null;
    }

    protected function validateCareerName($careerName): ?JsonResponse {
        $maxLength = 50;

        if (is_numeric($careerName)) {
            return $this->errorResponse('Error: el nombre de la carrera no puede ser un valor numérico');
        }

        if (strlen($careerName) > $maxLength) {
            return $this->errorResponse('Error: el nombre de la carrera no puede exceder los ' . $maxLength . ' caracteres');
        }

        if (strlen($careerName) < 5) {
            return $this->errorResponse('Error: el nombre de la carrera debe tener al menos 5 caracteres');
        }

        if ($careerName == null) {
            return $this->errorResponse('Error: el nombre de la carrera no puede estar vacío');
        }

        if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $careerName)) {
            return $this->errorResponse('Error: el nombre de la carrera no puede contener símbolos o caracteres especiales, excepto las tildes.');
        }

        return null;
    }
}

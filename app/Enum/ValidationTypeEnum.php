<?php

namespace App\Enum;

enum ValidationTypeEnum: string {
    case REGISTER_USER = "register";
    case UPDATE_USER = "update";
    case CAREER = "career";
    case DEPARTMENT = "department";
    case NOTIFICATION = "notification";
}

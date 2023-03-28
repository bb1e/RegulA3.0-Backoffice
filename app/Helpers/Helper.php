<?php
namespace App\Helpers;
use App\Enum;

enum UserRole {
    case AdminRole;
    case TerapeutaRole;
    case OtherRole;
}


class Helper {
    // @return UserRole
    public static function getRole($firebaseUser) {
        $customUserClaims = $firebaseUser->customClaims;
        if(array_key_exists('admin',$customUserClaims)){
            return UserRole::AdminRole;
        } else if (array_key_exists('terapeuta',$customUserClaims)) {
            return UserRole::TerapeutaRole;
        }
        return UserRole::OtherRole;
    }

    // Não existe "setRole" genérico para limitar o setRoleOther
    public static function setRoleTerapeuta($auth,$uid) {
        $auth->setCustomUserClaims($uid,['terapeuta' => true]);
    }
    public static function setRoleAdmin($auth,$uid) {
        $auth->setCustomUserClaims($uid,['admin' => true]);
    }
}

<?php 

namespace Utils;

class SaneaValida{
    public static function validarLogin($data){
        $alertas = [];
        if(isset($data)){
            $email = $data['email'];
            $password = $data['password'];

            if (empty($email)){
                $alertas["error"][] = 'El campo email es obligatorio.';
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $alertas["error"][] = "El formato del email es inválido";
            }

            if (empty($password)){
                $alertas["error"][] = 'El campo password es obligatorio.';
            }elseif(strlen($password) < 6 or strlen($password) > 20){
                $alertas["error"][] = "La contraseña tiene que estar entre 6 y 20 caracteres";
            }
                
        }
        return $alertas;
    }
    
    public static function validarRegistro($data){
        $alertas = [];
        if(isset($data)){
            
            if (empty($data['email'])){
                $alertas["error"][] = 'El campo email es obligatorio.';
            }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $alertas["error"] = "El formato del email es inválido";
            }

            if (empty($data['password'])){
                $alertas["error"][] = 'El campo password es obligatorio.';
            }elseif(strlen($data['password']) < 8){
                $alertas["error"][] = "La contraseña tiene que estar entre 8 y 20 caracteres";
            }
            if (empty($data['telefono'])){
                $alertas["error"][] = 'El campo nombre es obligatorio.';
            }elseif(strlen($data['telefono']) != 9){
                $alertas["error"][] = 'El campo nombre es obligatorio.';
            }

            if (empty($data['nombreUsuario'])){
                $alertas["error"][] = 'El campo email es obligatorio.';
            }

            if(empty($data['fotografo'])){
                $alertas['error'][] = 'Debes seleccionar si eres fotografo o no';
            }
        }
        return $alertas;
    }

    public static function validaEmail($email){
        $alertas = [];
        if (empty($email)){
            $alertas["error"][] = 'El campo email es obligatorio.';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $alertas["emerrorail"] = "El formato del email es inválido";
        }
        return $alertas;
    }

    public static function validaPassword($password){
        $alertas = [];
        if (empty($password)){
            $alertas["error"][] = 'El campo password es obligatorio.';
        }elseif(strlen($password) < 8 or strlen($password) > 20){
            $alertas["error"] = "La contraseña tiene que estar entre 8 y 20 caracteres";
        }
        return $alertas;
    }

    public static function categoria($nombre, $imagen){
        $alertas = [];
        if (empty($nombre)){
            $alertas["error"][] = 'El campo nombre es obligatorio.';
        }
        
        if(empty($imagen['tmp_name'])){
            $alertas["error"][] = 'Debes subir una imagen';
        }

        return $alertas;
    }

    public static function ValidaInfo($data, $imagen){
        $alertas = [];
        

        if (empty($data['descripcion'])){
            $alertas["error"][] = 'El campo descripcion es obligatorio.';
        }

        if(empty($imagen['tmp_name'])){
            $alertas["error"][] = 'Debes subir una imagen';
        }

        return $alertas;
    }

    public static function validarReportaje($data, $imagen){
        $alertas = [];
        if (empty($data['nombre'])){
            $alertas["error"][] = 'El campo nombre es obligatorio';
        }

        if (empty($data['fecha'])){
            $alertas["error"][] = 'El campo fecha es obligatorio';
        }

        if (empty($data['descripcion'])){
            $alertas["error"][] = 'El campo descripcion es obligatorio';
        }

        if (empty($imagen['tmp_name'])){
            $alertas["error"][] = 'Debes subir una imagen';
        }

        return $alertas;
    }

    public static function validaContacto($data){
        $alertas = [];
        if (empty($data['nombre'])){
            $alertas["error"][] = 'El campo nombre es obligatorio';
        }

        if (empty($data['telefono'])){
            $alertas["error"][] = 'El campo telefono es obligatorio.';
        }elseif(strlen($data['telefono']) != 9){
            $alertas["error"][] = 'El campo telefono tiene que tener 9 digitos.';
        }

        if (empty($data['email'])){
            $alertas["error"][] = 'El campo email es obligatorio.';
        }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $alertas["error"] = "El formato del email es inválido";
        }

        return $alertas;
    }
}


<?php

namespace Controllers;

use Models\Users;
use Lib\ResponseHttp;
use Lib\Security;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiUsersController{
    private Users $user;

    public function __construct(){
        $this->user = new Users();
    }

    public function login($data){
        $logueado = false;
        $data = json_decode($data);
        
        $this->user->setPassword($data->password);
        $user = $this->user->login($data->email);

        if ($user && is_object($user)){ //Vamos a comprobar que rol es el usuario para iniciar variables de sesion
            if ($user->admi === 1){
                $_SESSION['admin'] = true;
                $_SESSION['nombre'] = $user->nombreUsuario;
                $_SESSION['login'] = true;
            }elseif($user->fotografo === 1){
                $_SESSION['fotografo'] = true;
                $_SESSION['nombre'] = $user->nombreUsuario;
                $_SESSION['login'] = true;
            }else{
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $user->nombreUsuario;
            }
        }

        if($user){
            $this->user->setEmail($data->email);
            $key = Security::claveSecreta();
            $token = Security::crearToken($key, [$data->email]);
            $jwt = JWT::encode($token,$key,'HS256');

            $this->user->setToken($jwt);
            //$this->user->setToken_esp($token["exp"]); //Ahora mismo no se funcionalidad de esto TODO
            $this->user->updateToken();
            //http_response_code(200);
            ResponseHttp::statusMessage(200,'Ok');
            $logueado = true;
            return $logueado;
        }
    }

    public function existeUsuario($email){
        $data = json_decode($email);
        $usuario = $this->user->buscaMail($data->email);
        return $usuario;
    }

    public function registrar($data){
        $data = json_decode($data);
        //Vamos a asignar los datos a cada una de las propiedades del objeto
        $this->user->setEmail($data->email);
        $this->user->setPassword(password_hash($data->password, PASSWORD_BCRYPT));
        $this->user->setTelefono($data->telefono);
        //Establecemos si es fotografo o no según la información dada
        if($data->fotografo === 'si'){
            $this->user->setFotografo(1);
        }else{
            $this->user->setFotografo(0);
        }
        
        $this->user->setNombreUsuario($data->nombreUsuario);

        //Creamos el token para poder asignarselo
        $key = Security::claveSecreta();
        $token = Security::crearToken($key, [$data->email]);
        $jwt = JWT::encode($token, $key, 'HS256');
        $this->user->setToken($jwt);

        //Registramos la cuenta
        $registrado = $this->user->registro();
        return $registrado;
    }

    public  function where($columna, $valor){
        $valor = json_decode($valor);
        $this->user->where($columna, $valor);
    }

    public function find($data){
        $data = json_decode($data);
        $usuario = $this->user->buscaMail($data->email);
        return $usuario;
    }

    public function findId($id){
        $id = json_decode($id);
        $usuario = $this->user->findId($id);
        return $usuario;
    }

    public function confirmacion($usuario){
        $usuario = json_decode($usuario);
        $confirmado = $this->user->updateConfirmado($usuario);
        return $confirmado;
    }

    public function crearToken($data){
        $data = json_decode($data);
        
        //Creamos el token para poder asignarselo
        $key = Security::claveSecreta();
        $token = Security::crearToken($key, [$data->email]);
        $jwt = JWT::encode($token, $key, 'HS256');
        $this->user->setToken($jwt); //Asignamos el token al usuario
        $this->user->setEmail($data->email); //Asignamos el email al usuario para poder actualizar el token

        $this->user->updateToken();
    }

    public function actualizarRecuperacionPassw($usuario){
        $usuario = json_decode($usuario);
        $resultado = $this->user->actualizarRecuperacionPassw($usuario);
        return $resultado;
    }

    public function registrarInfo($data, $imagen){
        $data = json_decode($data);
        $imagen = json_decode($imagen);

        $resultado = $this->user->registrarInfo($data, $imagen);
        var_dump($resultado);
        return $resultado;
    }


    public function existePerfil($id){
        $id = json_decode($id);
        $perfil = $this->user->existePerfil($id);
        return $perfil;
    }

    public function buscarFotografo($data){
        $data = json_decode($data);
        $fotografo = $this->user->buscarFotografo($data->nombre);
        return $fotografo;
    }

    
    public function borrarRegistrosReportajesFotografo($idFotografo){
        $idFotografo = json_decode($idFotografo);
        $this->user->borrarRegistrosReportajesFotografo($idFotografo);
    }

    public function borrarRegistroInfoFotografo($idFotografo){
        $idFotografo = json_decode($idFotografo);
        $this->user->borrarRegistroInfoFotografo($idFotografo);
    }

    public function borrarFotografo($idFotografo){
        $idFotografo = json_decode($idFotografo);
        $this->user->borrarFotografo($idFotografo);
    }
}
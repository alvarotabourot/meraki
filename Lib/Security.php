<?php

namespace Lib;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDOException;

class Security{
    final public static function claveSecreta(){
        $dotenv = Dotenv::createImmutable(dirname(__DIR__ .'../'));
        $dotenv->safeLoad();
        return $_ENV['SECRET_PASSWORD'];
    }

    final public static function encriptaPassw(string $passw): string{
        $passw = password_hash($passw,PASSWORD_DEFAULT);
        return $passw;
    }

    final public static function validaPassw(string $passw, string $passwhash):bool{
        if (password_verify($passw,$passwhash)){return true;}
        else{
        return false;}
    }

    final public static function crearToken(string $key, array $data){
        $time = strtotime("now");
        $token = array(
            "iat"=>$time,
            "exp"=>$time + 3600,
            "data"=>$data
        );
        return $token;
    }

    final public static function getToken(){
        $headers = apache_request_headers();
        if(!isset($headers['Authorization'])){
            return $response['message'] = json_decode(ResponseHttp::statusMessage(403,'Acceso denegado'));
        }
        try{
            $authorizationArr = explode(' ', $headers['Authorization']);
            $token = $authorizationArr[1];
            $decodeToken = JWT::decode($token, new Key(Security::clavesecreta(), 'HS256'));
            return $decodeToken;
        }catch (PDOException $exception){
            return $response['message'] = json_encode(ResponseHttp::statusMessage(401, 'Token expirado o invalido'));
        }
    }

    final public static function validateToken(){
        $info = self::getToken();
        if(isset($info->data)){
            return true;
        }else{
            return false;
        }
    }
}
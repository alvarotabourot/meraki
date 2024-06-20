<?php 

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;

class Users extends BaseDatos{
    private string $id;
    private string $email;
    private string $password;
    private int $telefono;
    private string $nombreUsuario;
    private int $verificado;
    private string $token;
    private int $admin;
    private int $fotografo;

    public function __construct(){
        parent::__construct();
    }

    public function getId():string{return $this->id;}
    public function setId(string $id){$this->id = $id;}
    public function getEmail():string{return $this->email;}
    public function setEmail(string $email){$this->email = $email;}
    public function getPassword():string{return $this->password;}
    public function setPassword(string $password){$this->password = $password;}
    public function getTelefono():int{return $this->telefono;}
    public function setTelefono(int $telefono){$this->telefono = $telefono;}
    public function getNombreUsuario():string{return $this->nombreUsuario;} 
    public function setNombreUsuario(string $nombreUsuario){$this->nombreUsuario = $nombreUsuario;}
    public function getVerificado():int{return $this->verificado;}
    public function setVerificado(int $verificado){$this->verificado = $verificado;}
    public function getToken():string{return $this->token;}
    public function setToken(string $token){$this->token = $token;}
    public function getAdmin():int{return $this->admin;}
    public function setAdmin(int $admin){$this->admin = $admin;}
    public function getFotografo():int{return $this->fotografo;}
    public function setFotografo(int $fotografo){$this->fotografo = $fotografo;}

    /** FUNCION PARA HACER EL LOGIN */
    public function login($email){
        $result = false;
        $password = $this->getPassword();
        $usuario = $this->buscaMail($email); //Buscamos en la BBDD si existe un usuario con ese email y lo devuelve.

        if(is_object($usuario)){ // Compruebo si es un objeto
            $verify = password_verify($password, $usuario->password); //Compruebo si la contraseña es correcta
            if($verify){
                $result = $usuario;
            }
        }
        return $result;
    }

    /** FUNCION QUE DEVUELVE EL USUARIO SI EXISTE */
    public function buscaMail($email){
        $result = false;

        $cons = $this->prepara("SELECT * FROM users WHERE email = :email");
        $cons->bindParam(':email', $email, PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons && $cons->rowCount()==1){
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    /** FUNCION PARA REGISTRAR USUARIOS */
    public function registro(){ 
        $stmt = $this->prepara("INSERT INTO users( email, password, telefono, nombreUsuario, token,  fotografo) VALUES( :email, :password, :telefono, :nombreUsuario,:token,  :fotografo );");

        $email = $this->email;
        $password = $this->password;
        $telefono = $this->telefono;
        $nombreUsuario = $this->nombreUsuario;
        $fotografo = $this->fotografo;
        $token = $this->token;
    
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':fotografo', $fotografo, PDO::PARAM_INT);
    
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }

    /** FUNCION PARA PODER ACTUALIZAR EL TOKEN DEL USUARIO QUE SERÁ NECESARIO PARA VARIAS FUNCIONALIDADES DE LA PAGINA */
    public function updateToken(){
        $this->consulta("UPDATE users SET token = '$this->token' WHERE email = '$this->email'");

        try{
            return $this->filasAfectadas();
        }catch(PDOException $err){
            return false;
        }
    }

    /** FUNCION AUXILIAR QUE UTILIZO PARA BUSCAR EN LA TABLA USERS INDEPENDIENTEME DEL CAMPO QUE NECESITE */
    public  function where($columna, $valor){
        $result = false;

        $cons = $this->prepara("SELECT * FROM users WHERE $columna = ':$valor'");
        $cons->bindParam(':'.$valor.'', $valor, PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons && $cons->rowCount()==1){
                $result = $cons->fetch(PDO::FETCH_OBJ);
                $result->verificado = 1;
                $result->token = null;
                $this->guardar($result);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    /** FUNCION PARA OPTIMIZAR CODIGO */
    public function guardar($result){
        if(!is_null($result->id)){
            $this->actualizar($result);
        }
        
    }

    /** LAS SIGUIENTES DOS FUNCIONES REALIZAN LA MISMA FUNCIÓN PERO NO TIENEN LOS MISMOS TIPOS DE DATOS, POR ESO DEBO REPETIR EL CODIGO (FIJARSE EN EL PDO::PARAM) */
    public function actualizar($result){
        $resultado = false;
        $cons = $this->prepara("UPDATE users SET verificado = :verificado, token = :token, WHERE id = :id");
        $cons->bindParam(':id',$result->id,PDO::PARAM_STR);
        $cons->bindParam(':confirmado',$result->verificado,PDO::PARAM_STR);
        $cons->bindParam(':token',$result->token,PDO::PARAM_STR);
    
        try{
            $cons->execute();
            $resultado = true;
        }catch(PDOException $err){
            $resultado = false;
        }
        return $resultado;
    }

    public function updateConfirmado($usuario){
        $result = false;
        $cons = $this->prepara("UPDATE users SET verificado = :verificado, token = :token WHERE id = :id");

        $cons->bindParam(':id', $usuario->id, PDO::PARAM_INT);
        $cons->bindParam(':verificado',$usuario->verificado, PDO::PARAM_INT);
        $cons->bindParam(':token',$usuario->token, PDO::PARAM_STR);
        
        try{
            $cons->execute();
            $result = true;
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    /** FUNCION QUE NOS PERMITE OBTENER UN USUARIO BUSCANDO POR SU ID */
    public function findId($id){
        $result = false;

        $cons = $this->prepara("SELECT * FROM users WHERE id = :id");
        $cons->bindParam(':id', $id, PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons && $cons->rowCount()==1){
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    /** FUNCION QUE NOS PERMITE ACTUALIZAR NUESTRA CONTRASEÑA */
    public function actualizarRecuperacionPassw($usuario){
        $result = false;
        $cons = $this->prepara("UPDATE users SET password = :password, token = :token WHERE id = :id");

        $cons->bindParam(':id', $usuario->id, PDO::PARAM_INT);
        $cons->bindParam(':password',$usuario->password, PDO::PARAM_STR);
        $cons->bindParam(':token',$usuario->token, PDO::PARAM_STR);
        
        try{
            $cons->execute();
            $result = true;
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }
    
    /** FUNCION QUE NOS PERMITE REGISTRAR LA INFO DEL FOTOGRAFO */
    public function registrarInfo($data, $imagen){
        $stmt = $this->prepara("INSERT INTO informacionfotografo ( nombre, descripcion, url, userId) VALUES( :nombre, :descripcion, :url, :userId);");

        $url = $imagen;
        $userId = $_SESSION['id'];
    
        $stmt->bindParam(':nombre', $data->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':url', $url, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }
    /** FUNCION QUE NOS DEVUELVE EL FOTOGRAFO SI EXISTE INFORMACION SOBRE EL*/
    public function existePerfil($id){
        $result = false;
        $cons = $this->prepara("SELECT * FROM informacionfotografo WHERE userId = :userId");
        $cons->bindValue(':userId', $id, PDO::PARAM_INT);

        try{
            $cons->execute();
            $result = $cons->fetch(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }
    /** FUNCION PARA BUSCAR UN FOTOGRAFO POR SU NOMBRE COMPLETO */
    public function buscarFotografo($nombre){
        $cons = $this->prepara("SELECT * FROM informacionfotografo WHERE nombre = :nombre");
        $cons->bindParam(':nombre', $nombre, PDO::PARAM_STR);

        try{
            $cons->execute();
            $result = $cons->fetch(PDO::FETCH_OBJ);
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    
    /** FUNCION PARA BORRAR REGISTROS DE REPORTAJES DEL FOTOGRAFO */
    public function borrarRegistrosReportajesFotografo($idFotografo){
        $cons = $this->prepara("DELETE FROM reportajes WHERE usersId = :usersId");
        $cons->bindParam(':usersId', $idFotografo, PDO::PARAM_INT);

        try{
            $cons->execute();
            return true;
        }catch(PDOException $err){
            return false;
        }
    }

    /** FUNCIÓN PARA BORRAR LA INFORMACIÓN DEL FOTOGRAFO */
    public function borrarRegistroInfoFotografo($idFotografo){
        $cons = $this->prepara("DELETE FROM informacionfotografo WHERE userId = :userId");
        $cons->bindParam(':userId', $idFotografo, PDO::PARAM_INT);

        try{
            $cons->execute();
            return true;
        }catch(PDOException $err){
            return false;
        }
    }

    /** FUNCION PARA BORRAR EL FOTOGRAFO EN SI */
    public function borrarFotografo($idFotografo){
        $cons = $this->prepara("DELETE FROM users WHERE id = :id");
        $cons->bindParam(':id', $idFotografo, PDO::PARAM_INT);

        try{
            $cons->execute();
            return true;
        }catch(PDOException $err){
            return false;
        }
    }
}
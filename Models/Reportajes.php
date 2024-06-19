<?php 

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;

class Reportajes extends BaseDatos{

    private string $id;
    private string $nombre;

    private string $fecha;

    private string $descripcion;

    private string $url;

    private string $usersId;

    private string $categoriaId;


    public function __construct(){
        parent::__construct();
    } 

    public function getId(){return $this->id;}
    public function setId($id){$this->id = $id;}
    public function getNombre(){return $this->nombre;}
    public function setNombre($nombre){$this->nombre = $nombre;}
    public function getFecha(){return $this->fecha;}
    public function setFecha($fecha){$this->fecha = $fecha;return $this;} 
    public function getDescripcion(){return $this->descripcion;}
    public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
    public function getUrl(){ return $this->url;} 
    public function setUrl($url){$this->url = $url;}
    public function getUsersId(){return $this->usersId;}
    public function setUsersId($usersId){$this->usersId = $usersId;}
    public function getCategoriaId(){return $this->categoriaId;}
    public function setCategoriaId($categoriaId){$this->categoriaId = $categoriaId;}

    public function registrar($data, $imagen, $idFotografo, $idCategoria){
        $stmt = $this->prepara("INSERT INTO reportajes( nombre, fecha, descripcion, url, usersId, categoriaId) VALUES( :nombre, :fecha, :descripcion, :url, :usersId, :categoriaId);");
        
        $stmt->bindParam(':nombre', $data->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $data->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':url', $imagen, PDO::PARAM_STR);
        $stmt->bindParam(':usersId', $idFotografo, PDO::PARAM_INT);
        $stmt->bindParam(':categoriaId', $idCategoria, PDO::PARAM_INT);
    
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }

    public function buscarContenidoReportaje($idReportaje){
        $result = false;

        $cons = $this->prepara("SELECT * FROM reportajes WHERE id = :id");
        $cons->bindParam(':id', $idReportaje, PDO::PARAM_STR);

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

    public function buscarFotosReportaje($idReportaje){
        $result = false;

        $cons = $this->prepara("SELECT * FROM fotosreportajes WHERE reportajeId = :id");
        $cons->bindParam(':id', $idReportaje, PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons){
                $result = $cons->fetchAll(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function buscarNombreFotografo($idFotografo){
        $result = false;

        $cons = $this->prepara("SELECT * FROM informacionfotografo WHERE userId = :id");
        $cons->bindParam(':id', $idFotografo, PDO::PARAM_STR);

        try{
            $cons->execute();
            if($cons){
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;

    }

    public function subirFotoAlReportaje($idReportaje, $nombreImagen){
        $stmt = $this->prepara("INSERT INTO fotosreportajes( url, reportajeId) VALUES( :url, :reportajeId);");
        
        $stmt->bindParam(':url', $nombreImagen, PDO::PARAM_STR);
        $stmt->bindParam(':reportajeId', $idReportaje, PDO::PARAM_STR);
    
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }

    public function buscarReportajes($id){
        $result = false;

        $cons = $this->prepara("SELECT * FROM reportajes WHERE usersId = :id LIMIT 5");
        $cons->bindParam(':id', $id, PDO::PARAM_INT);

        try{
            $cons->execute();
            if($cons){
                $result = $cons->fetchAll(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;

    }

    public function buscarReportajesFotografo($idFotografo){
        $result = false;

        $cons = $this->prepara("SELECT * FROM reportajes WHERE usersId = :id");
        $cons->bindParam(':id', $idFotografo, PDO::PARAM_INT);

        try{
            $cons->execute();
            if($cons){
                $result = $cons->fetchAll(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function buscarFotosFotografo($idReportaje){
        $result = false;

        $cons = $this->prepara("SELECT * FROM fotosreportajes WHERE reportajeId = :id");
        $cons->bindParam(':id', $idReportaje, PDO::PARAM_INT);

        try{
            $cons->execute();
            if($cons){
                $result = $cons->fetchAll(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function borrarFotosReportajesFotografo($idReportaje){
        $cons = $this->prepara("DELETE FROM fotosreportajes WHERE reportajeId = :reportajeId");
        $cons->bindParam(':reportajeId', $idReportaje, PDO::PARAM_INT);

        try{
            $cons->execute();
            return true;
        }catch(PDOException $err){
            return false;
        }
    }

}
<?php 

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;


class Categorias extends BaseDatos{
    
    private string $id;
    private string $url;
    private string $nombre;


    public function __construct(){
        parent::__construct();
    }

    public function getId():string{return $this->id;}

    public function setId(string $id){$this->id = $id;}

    public function getUrl():string{return $this->url;}

    public function setUrl(string $url){$this->url = $url;}

    public function getNombre():string{return $this->nombre;}

    public function setNombre(string $nombre){$this->nombre = $nombre;}


    public function registro($nombre, $imagen){ 
        $stmt = $this->prepara("INSERT INTO categorias( url, nombre) VALUES( :url, :nombre);");
    
        $stmt->bindParam(':url', $imagen, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $err){
            return $err;
        }
    }

    public function mostrarCategorias(){
        $result = false;
        $categorias = "SELECT * FROM categorias";
        $stmt = $this->prepara($categorias);

        try{
            $stmt->execute();
            if($stmt){
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }

    public function mostrarTipoCategoria($id){
        $result = false;
        $categorias = "SELECT * FROM reportajes where categoriaId = :categoriaId";
        $stmt = $this->prepara($categorias);
        $stmt->bindParam(':categoriaId', $id, PDO::PARAM_INT);


        try{
            $stmt->execute();
            if($stmt){
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err){
            $result = false;
        }
        return $result;
    }
}
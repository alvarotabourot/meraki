<?php 

namespace Controllers;

use Models\Categorias;


class ApiCategoriasController{
    private Categorias $categorias;

    public function __construct(){
        $this->categorias = new Categorias();
    }

    public function registrar($nombre, $imagen){
        $nombre = json_decode($nombre);
        $imagen = json_decode($imagen);
        $result = $this->categorias->registro($nombre, $imagen);
        return $result;
    }

    public function mostrarCategorias(){
        $categorias = $this->categorias->mostrarCategorias();
        return $categorias;
    }

    public function mostrarTipoCategoria($id){
        $id = json_decode($id);
        $categorias = $this->categorias->mostrarTipoCategoria($id);
        return $categorias;
    }
}
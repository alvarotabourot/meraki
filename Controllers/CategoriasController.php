<?php

namespace Controllers;

use Controllers\ApiCategoriasController;
use Utils\SaneaValida;
use Lib\Pages;

class CategoriasController{
    private ApiCategoriasController $apiCategorias;
    private Pages $pages;

    public function __construct(){
        $this->apiCategorias = new ApiCategoriasController();
        $this->pages = new Pages();
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; // Guardamos en la variable los datos que vienen del formulario
                $nombre = $data['nombre'];
                $imagen = $_FILES['imagen'];

                $alertas = SaneaValida::categoria($nombre, $imagen);
                if(empty($alertas)){

                    //Subida de archivos

                    //Crear carpeta

                    $carpetaImagenes = '../public/img/categorias/';

                    if(!is_dir($carpetaImagenes)){
                        mkdir($carpetaImagenes, 0777, true);
                    }
                    $nombreImagen = md5( uniqid( rand(), true)).'.jpg';
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

                    $nombre = json_encode($nombre); 
                    $url = json_encode($nombreImagen);
                    $result = $this->apiCategorias->registrar($nombre, $url);
                    if($result){
                        $alertas['exito'][] = 'Se ha añadido correctamente la categoria';
                        $this->pages->render('admi/panel', ['alertas' => $alertas]);
                    }

                }
            }
        }
        $this->pages->render('admi/panel', ['alertas' => $alertas]);
    }

    public function mostrarCategorias(){
        $categorias = $this->apiCategorias->mostrarCategorias();
        return $categorias;
    }

    public function mostrarTipoCategoria($id){
        $_SESSION['categoriaId'] = $id;
        $id = json_encode($id);
        $reportajes = $this->apiCategorias->mostrarTipoCategoria($id);
        $this->pages->render('categoria/reportajes', 
        ['reportajes' => $reportajes]);
    }
}
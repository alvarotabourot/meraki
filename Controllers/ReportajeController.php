<?php 

namespace Controllers;

use Controllers\ApiReportajeController;
use Lib\Pages;
use Utils\SaneaValida;

class ReportajeController{
    private ApiReportajeController $apiReportaje;
    private Pages $pages;

    public function __construct(){
        $this->apiReportaje = new ApiReportajeController();
        $this->pages = new Pages();
    }

    public function añadirReportaje($idCategoria){
        $alertas = [];
        $idFotografo = $_SESSION['id'];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; 
                $imagen = $_FILES['imagen'];
                $alertas = SaneaValida::validarReportaje($data, $imagen); 
                if(empty($alertas)){
                    //Subida de archivos

                    //Crear carpeta

                    $carpetaImagenes = '../public/img/reportajes/';

                    if(!is_dir($carpetaImagenes)){
                        mkdir($carpetaImagenes, 0777, true);
                    }
                    $nombreImagen = md5( uniqid( rand(), true)).'.jpg';
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

                    $data = json_encode($data);
                    $imagen = json_encode($nombreImagen);
                    $idCategoria = json_encode($idCategoria);
                    $idFotografo = json_encode($idFotografo);
                    $result = $this->apiReportaje->registrar($data, $imagen, $idFotografo, $idCategoria);
                    if($result){
                        $idCategoria = json_decode($idCategoria);
                        //var_dump($idReportaje)
                        header('Location: '.$_ENV['BASE_URL']. 'categoria/tipo/'.$idCategoria);
                    }
                }
            }
        }

        $this->pages->render('reportajes/crear', ['alertas' => $alertas, 'idCategoria' => $idCategoria]);

        
    }

    public function mostrarContenidoReportaje($idReportaje){
        $idReportaje = json_encode($idReportaje);
        $reportaje = $this->apiReportaje->buscarContenidoReportaje($idReportaje);
        $fotosReportaje = $this->apiReportaje->buscarFotosReportaje($idReportaje);
        $nombreFotografo = $this->apiReportaje->buscarNombreFotografo(json_encode($reportaje->usersId));

        $this->pages->render('reportajes/mostrarContenido', 
        ['reportaje' => $reportaje, 'fotos' => $fotosReportaje, 'fotografo' => $nombreFotografo]);

    }

    public function subirFotoAlReportaje($idReportaje){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $imagen = $_FILES['imagen'];
                //Subida de archivos
                //Crear carpeta

                $carpetaImagenes = '../public/img/fotosReportaje/';

                if(!is_dir($carpetaImagenes)){
                    mkdir($carpetaImagenes, 0777, true);
                }

                $nombreImagen = md5( uniqid( rand(), true)).'.jpg';
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

                $idReportaje = json_encode($idReportaje);
                $nombreImagen = json_encode($nombreImagen);
                $this->apiReportaje->subirFotoAlReportaje($idReportaje, $nombreImagen);  

                $idReportaje = json_decode($idReportaje);
                header('Location: '.$_ENV['BASE_URL'].'reportaje/contenido/'.$idReportaje);
        }
    }
}
    
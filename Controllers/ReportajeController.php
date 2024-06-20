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

    /** FUNCION PARA REGISTRAR UN REPORTAJE */
    public function añadirReportaje($idCategoria){
        $alertas = [];
        $idFotografo = $_SESSION['id'];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; //Guardamos los valores que vienen por POST en la variable
                $imagen = $_FILES['imagen']; // Guardamos todo lo relacionado con la imagen
                $alertas = SaneaValida::validarReportaje($data, $imagen); //Validamos si se han introducido todos los campos
                if(empty($alertas)){
                    //Subida de archivos

                    //Crear carpeta

                    $carpetaImagenes = '../public/img/reportajes/';

                    if(!is_dir($carpetaImagenes)){
                        mkdir($carpetaImagenes, 0777, true);
                    }
                    $nombreImagen = md5( uniqid( rand(), true)).'.jpg'; //Creamos un nombre unico para la imagen
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen); //Movemos la imagen a la carpeta

                    /** Codifico los datos */
                    $data = json_encode($data);
                    $imagen = json_encode($nombreImagen);
                    $idCategoria = json_encode($idCategoria);
                    $idFotografo = json_encode($idFotografo);
                    $result = $this->apiReportaje->registrar($data, $imagen, $idFotografo, $idCategoria); //Devuelve true o false, depende de si consigue registrar el reportaje.
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
    /** FUNCION QUE NOS SIRVE PARA MOSTRAR EL CONTENIDO DEL REPORTAJE */
    public function mostrarContenidoReportaje($idReportaje){
        $idReportaje = json_encode($idReportaje);
        $reportaje = $this->apiReportaje->buscarContenidoReportaje($idReportaje);
        $fotosReportaje = $this->apiReportaje->buscarFotosReportaje($idReportaje);
        $nombreFotografo = $this->apiReportaje->buscarNombreFotografo(json_encode($reportaje->usersId));

        $this->pages->render('reportajes/mostrarContenido', 
        ['reportaje' => $reportaje, 'fotos' => $fotosReportaje, 'fotografo' => $nombreFotografo]);

    }

    /** FUNCION QUE NOS PERMITE SUBIR UNA FOTO AL REPORTAJE */
    public function subirFotoAlReportaje($idReportaje){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $imagen = $_FILES['imagen'];
                //Subida de archivos
                //Crear carpeta

                $carpetaImagenes = '../public/img/fotosReportaje/';

                if(!is_dir($carpetaImagenes)){
                    mkdir($carpetaImagenes, 0777, true);
                }

                $nombreImagen = md5( uniqid( rand(), true)).'.jpg'; //Creamos nombre unico para la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen); //La subimos a la carpeta de imagenes

                $idReportaje = json_encode($idReportaje);
                $nombreImagen = json_encode($nombreImagen);
                $this->apiReportaje->subirFotoAlReportaje($idReportaje, $nombreImagen);  //Registra en la BBDD la foto

                $idReportaje = json_decode($idReportaje);
                header('Location: '.$_ENV['BASE_URL'].'reportaje/contenido/'.$idReportaje);
        }
    }
}
    
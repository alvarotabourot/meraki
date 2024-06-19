<?php 

namespace Controllers;

use Models\Reportajes;


class ApiReportajeController{
    private Reportajes $reportajes;

    public function __construct(){
        $this->reportajes = new Reportajes();
    }

    public function registrar($data, $imagen, $idFotografo, $idCategoria){
        $data = json_decode($data);
        $imagen = json_decode($imagen);
        $idCategoria = json_decode($idCategoria);
        $idFotografo = json_decode($idFotografo);
        $result = $this->reportajes->registrar($data, $imagen, $idFotografo, $idCategoria);
        return $result;
    }

    public function buscarContenidoReportaje($idReportaje){
        $idReportaje = json_decode($idReportaje);
        $reportaje = $this->reportajes->buscarContenidoReportaje($idReportaje);
        return $reportaje;
    }

    public function buscarNombreFotografo($idUsuario){
        $idUsuario = json_decode($idUsuario);
        $nombreFotografo = $this->reportajes->buscarNombreFotografo($idUsuario);
        return $nombreFotografo;
    }

    public function subirFotoAlReportaje($idReportaje, $nombreImagen){
        $idReportaje = json_decode($idReportaje);
        $nombreImagen = json_decode($nombreImagen);
        $this->reportajes->subirFotoAlReportaje($idReportaje, $nombreImagen);
    }

    public function buscarReportajes($id){
        $reportajes = $this->reportajes->buscarReportajes($id);
        return $reportajes;
    }

    public function buscarReportajesFotografo($idFotografo){
        $idFotografo = json_decode($idFotografo);
        $reportajes = $this->reportajes->buscarReportajesFotografo($idFotografo);
        return $reportajes;
    }


    /**BUSCAMOS LAS FOTOS QUE CORRESPONDAN A LOS REPORTAJES DE UN FOTOGRAFO EN CONCRETO PARA BORRARLAS DE LA CARPETA DE IMG, LAS DEVOLVEMOS Y LUEGO SE HACE LA FUNCION DE BORRAR TODAS LAS FOTOS DE LA BBDD */
    
    public function buscarFotosReportaje($idReportaje){
        $idReportaje = json_decode($idReportaje);
        $fotos = $this->reportajes->buscarFotosReportaje($idReportaje);
        return $fotos;
    }

    public function borrarFotosReportajesFotografo($idReportaje){
        $idReportaje = json_decode($idReportaje);
        $this->reportajes->borrarFotosReportajesFotografo($idReportaje);
        
    }
    

}
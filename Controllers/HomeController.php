<?php

namespace Controllers;

use Controllers\CategoriasController;
use Lib\Pages;

class HomeController{
    private CategoriasController $categorias;
    private Pages $pages;

    public function __construct(){
        $this->categorias = new CategoriasController();
        $this->pages = new Pages();
    }

    /** FUNCION QUE RENDERIZA LA VISTA PRINCIPAL Y ADEMÁS SE LE PASAN LAS CATEGORIAS QUE EXISTAN */
    public function home(){
        $this->pages->render('home/index', ['categorias' => $this->mostrarCategorias()]);
    }

    /** FUNCION QUE RENDERIZA LA VISTA DE NOSOTROS */
    public function nosotros(){
        $this->pages->render('home/nosotros');
    }

    /** FUNCION AUXILIAR PARA MOSTRAR LAS CATEGORIAS EN EL INDEX */
    public function mostrarCategorias(){
        return $this->categorias->mostrarCategorias();
    }

    
}



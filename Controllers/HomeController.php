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

    public function home(){
        $this->pages->render('home/index', ['categorias' => $this->mostrarCategorias()]);
    }

    public function nosotros(){
        $this->pages->render('home/nosotros');
    }

    public function mostrarCategorias(){
        return $this->categorias->mostrarCategorias();
    }

    
}



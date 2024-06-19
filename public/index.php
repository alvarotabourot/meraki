<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$autoloadPath =  '../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die('Autoloader not found. Please run "composer install"');
}
require_once $autoloadPath;

use Controllers\HomeController;
use Controllers\UsersController;
use Controllers\CategoriasController;
use Controllers\ReportajeController;
use Dotenv\Dotenv;
use Lib\Router;

// Configurar la base URI dinámica
$baseUri = '/blogfotografiasTFG/public/'; // Para local
if ($_SERVER['SERVER_NAME'] === 'meraki.organify.es') {
    $baseUri = '/public/'; // Para producción
}
Router::setBaseUri($baseUri);

$dotenv = Dotenv::createImmutable(__DIR__);
if (!$dotenv->safeLoad()) {
    die('Unable to load .env file');
}

session_start();

// Cargar vista principal
Router::add('GET', '/', function(){ return (new HomeController())->home(); });
Router::add('GET', '/nosotros', function(){ return (new HomeController())->nosotros(); });

// Login de usuarios
Router::add('GET', '/login', function(){ return (new UsersController())->login(); });
Router::add('POST', '/login', function(){ return (new UsersController())->login(); });

// Cerrar Sesion
Router::add('GET', '/logout', function(){ return (new UsersController())->logout(); });

// Registro de usuarios
Router::add('GET', '/registro', function(){ return (new UsersController())->registro(); });
Router::add('POST', '/registro', function(){ return (new UsersController())->registro(); });

// Confirmar cuenta
Router::add('GET', '/mensaje', function(){ return (new UsersController())->mensaje(); });
Router::add('GET', '/confirmarCuenta/:id', function($id){ return (new UsersController())->confirmar($id); });

// Recuperar contraseña
Router::add('GET', '/olvide', function(){ return (new UsersController())->olvide(); });
Router::add('POST', '/olvide', function(){ return (new UsersController())->olvide(); });

Router::add('GET', '/recuperar/:id', function($id){ return (new UsersController())->recuperar($id); });
Router::add('POST', '/recuperar/:id', function($id){ return (new UsersController())->recuperar($id); });

// CONTACTAR POR EMAIL
Router::add('POST', '/contacto/:id', function($id){ return (new UsersController())->sacarMensajeEmail($id); });
Router::add('POST', '/enviarEmailAdmi', function(){ return (new UsersController())->enviarCorreoAdmi(); });

// ADMIN
Router::add('GET', '/admi/panel', function(){ return (new UsersController())->sacarPanelAdmi(); });
Router::add('POST', '/categoria/registrar', function(){ return (new CategoriasController())->registrar(); });
Router::add('POST', '/fotografo/buscar', function(){ return (new UsersController())->buscarFotografo(); });
Router::add('POST', '/fotografo/eliminar', function(){ return (new UsersController())->eliminarFotografo(); });

// FOTOGRAFOS
Router::add('GET', '/fotografo/nuevo-perfil', function(){ return (new UsersController())->sacarInfoFotografo(); });
Router::add('POST', '/fotografo/nuevo-perfil', function(){ return (new UsersController())->registrarInfoFotografo(); });
Router::add('GET', '/fotografo/perfil/:id', function($id){ return (new UsersController())->sacarPerfilFotografo($id); });

// CATEGORIAS
Router::add('GET', '/categoria/tipo/:id', function($id){ return (new CategoriasController())->mostrarTipoCategoria($id); });
Router::add('GET', '/categoria/tipo/:id', function($id){ return (new CategoriasController())->mostrarTipoCategoria($id); });

// REPORTAJES
Router::add('GET', '/reportaje/registrar/:id', function($id){ return (new ReportajeController())->añadirReportaje($id); });
Router::add('POST', '/reportaje/registrar/:id', function($id){ return (new ReportajeController())->añadirReportaje($id); });
Router::add('GET', '/reportaje/contenido/:id', function($id){ return (new ReportajeController())->mostrarContenidoReportaje($id); });
Router::add('POST', '/reportaje/subirFoto/:id', function($id){ return (new ReportajeController())->subirFotoAlReportaje($id); });

// Manejar la solicitud y despachar la ruta correspondiente
Router::dispatch();

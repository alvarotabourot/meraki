<?php 

namespace Controllers;

use Controllers\ApiUsersController;
use Controllers\ApiReportajeController;
use Utils\SaneaValida;
use Lib\Pages;
use \Lib\Email;


class UsersController{
    private ApiUsersController $apiUsers;
    private ApiReportajeController $apiReportajes;
    private Pages $pages;

    public function __construct(){
        $this->apiUsers = new ApiUsersController();
        $this->apiReportajes = new ApiReportajeController();
        $this->pages = new Pages();
    }


    /*********************************************** LOGIN DE LOS USUARIOS *********************************************/

    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; // Guardamos en la variable los datos que vienen del formulario

                $alertas = SaneaValida::validarLogin($data); // Vamos a sanear y validar los datos que nos han envidado

                if(empty($alertas)){
                    $data = json_encode($data);
                    //Compruebo si existe el usuario buscando en la BBDD por su email
                    $usuario = $this->apiUsers->existeUsuario($data);

                    if(is_object($usuario)){
                        $usuario = json_encode($usuario);
                        $comprobacion = $this->comprobarPasswordAndVerificado($data, $usuario); //Compruebo si la contraseña que nos han dado por pantalla es igual a la de BBDD y tambien si la cuenta está verificada
                        
                        if($comprobacion){ //Inicio todas las variables de sesión que quiera
                            $usuario = json_decode($usuario);
                            //Creamos variables de sesion que van a ser comunes a todos los usuarios
                            $_SESSION['nombre'] = $usuario->nombreUsuario;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['login'] = true;
                        
                            if ($usuario->admin == 1 && $usuario->admin != NULL){
                                $_SESSION['admin'] = true;
                                header('Location: '.$_ENV['BASE_URL'].'admi/panel');
                                
                            }elseif($usuario->fotografo == 1 && $usuario->fotografo !=null){
                                $_SESSION['fotografo'] = true;
                                $perfil = $this->apiUsers->existePerfil($_SESSION['id']);

                                if(is_object($perfil)){
                                    $_SESSION['reportajes'] = $this->sacarReportajes($perfil->id);
                                    header('Location: '.$_ENV['BASE_URL']. 'fotografo/perfil/'.$_SESSION['id']);
                                }else{
                                    header('Location: '.$_ENV['BASE_URL']. 'fotografo/nuevo-perfil');
                                }
                            }else{
                                header('Location: '.$_ENV['BASE_URL']);
                            }
                            

                        }else{
                            $alertas['error'][] = 'La contraseña es incorrecta o la cuenta no está verificada.';
                            $this->pages->render('users/login', ['alertas' => $alertas]);
                        }
                    }
                }else{
                    $this->pages->render('users/login', ['alertas' => $alertas]);
                }
            }
        }else{
            $this->pages->render('users/login');
        }
    }

    /*********************************************** REGISTRO DE LOS USUARIOS *********************************************/
    public function registro(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; // Guardamos en la variable los datos que vienen del formulario
                $alertas = SaneaValida::validarRegistro($data); // Vamos a sanear y validar los datos que nos han envidado
                if(empty($alertas)){
                    $data = json_encode($data);
                    $usuario = $this->apiUsers->existeUsuario($data); //Se comprueba si hay una cuenta con el email asociado
                    
                    if(is_object($usuario)){
                        $alertas['error'][] = 'El usuario ya existe';
                        $this->pages->render('users/registro', ['alertas' => $alertas]); // Si hay un registro del email se informa al usuario
                    }else{
                        $registrado = $this->apiUsers->registrar($data); //Mandamos los datos para que sean registrados
                        
                        //Una vez registrado vamos a buscarlo para obtener el id y poder mandarle un correo para que verifique su cuenta
                        $usuario = $this->apiUsers->find($data);
                        
                        //Mandamos email de confirmación de la cuenta
                        $email = new Email($usuario->email, $usuario->nombreUsuario, $usuario->id );
                        $email->enviarConfirmacion();

                        if($registrado){

                            header('Location: '.$_ENV['BASE_URL']. 'mensaje');
                        } 
                    }
                }else{
                    $this->pages->render('users/registro', ['alertas' => $alertas]);
                }

            }
        }else{
            $this->pages->render('users/registro');
        }
    }

    public function mensaje(){
        $this->pages->render('users/mensaje');
    }


    /*********************************************** CONFIRMAR CUENTA DEL USUARIO *********************************************/
    public function confirmar($id){
        $alertas = [];
        $id = json_encode($id);

        $usuario = $this->apiUsers->findId($id);
        if(is_object($usuario)){
            $usuario->verificado = 1;
            $usuario->token = null;
            $usuario = json_encode($usuario);
            $this->apiUsers->confirmacion($usuario);

        }
        $usuario = json_decode($usuario);
        $alertas['exito'][] = 'Cuenta comprobada correctamente';
        $this->pages->render('users/confirmarCuenta', ['alertas' => $alertas, 'usuario' => $usuario]);
    }

    /*********************************************** RECUPERAR CONTRASEÑA *********************************************/

    public function olvide(){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data'];
                $alertas = SaneaValida::validaEmail($data['email']);

                if(empty($alertas)){
                    $data = json_encode($data);
                    $usuario = $this->apiUsers->existeUsuario($data);
                    if($usuario->verificado == 1){
                        $this->apiUsers->crearToken($data);

                        if($usuario->token){
                            $email = new Email($usuario->email, $usuario->nombreUsuario, $usuario->id);
                            $email->enviarInstrucciones();
                        }
                    }
                }
            }
        }
        $this->pages->render('users/olvidePassword', ['alertas' => $alertas]);
    }


    public function recuperar($id){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data'];
                $alertas = SaneaValida::validaPassword($data['password']);
                if(empty($alertas)){
                    $id = json_encode($id);
                    $usuario = $this->apiUsers->findId($id);
                    if(is_object($usuario)){
                        $usuario->password = password_hash($data['password'], PASSWORD_BCRYPT);
                        $usuario->token = null;
                        $usuario = json_encode($usuario);
                        $actualizado = $this->apiUsers->actualizarRecuperacionPassw($usuario);
                        if($actualizado){
                            header('Location: '.$_ENV['BASE_URL']. 'login');
                        }
                        
                    }
                }
            }

        }else{
            $this->pages->render('users/nuevapass', ['id' => $id]);
        }
    }

    public function logout(){
        if($_SESSION['login']){
            unset($_SESSION['nombre']);
            unset($_SESSION['email']);
            unset($_SESSION['id']);
            unset($_SESSION['login']);
            unset($_SESSION['admin']);
            unset($_SESSION['fotografo']);
            unset($_SESSION['categoriaId']);
            unset($_SESSION['loginNormal']);
            header('Location: '.$_ENV['BASE_URL']);
        }
    }



    //Funciones auxiliares

    public function comprobarPasswordAndVerificado($data, $usuario){
        $data = json_decode($data);
        $usuario = json_decode($usuario);

        $resultado = password_verify($data->password, $usuario->password);
        if(!$resultado || !$usuario->verificado){
            return false;
        }else{
            return true;
        }
    }


    /** VAMOS A REALIZAR METODOS DE USUARIO ADMINISTRADOR */

    public function sacarPanelAdmi(){
        $this->pages->render('admi/panel');
    }

    public function buscarFotografo(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST['data'];
            $data = json_encode($data);
            $fotografo = $this->apiUsers->buscarFotografo($data);
            if(is_object($fotografo)){
                $this->sacarPerfilFotografo($fotografo->userId);
            }else{
                $this->sacarPanelAdmi();
            }
            
        }
    }

    public function eliminarFotografo(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST['data'];
            $data = json_encode($data);
            $fotografo = $this->apiUsers->buscarFotografo($data);
            
            //Borrar todo lo que haya en a BBDD con el id del fotografo;

            $idFotografo = $fotografo->userId;
            $idFotografo = json_encode($idFotografo);

            //Necesitamos buscar registros de reportaje
            $reportajes = $this->apiReportajes->buscarReportajesFotografo($idFotografo);
            

            foreach($reportajes as $reportaje){
                $idReportaje = $reportaje->id;
                $idReportaje = json_encode($idReportaje);
                $fotosReportajes = $this->buscarFotosReportaje($idReportaje);
            
                foreach($fotosReportajes as $fotoReportaje){
                    $imagen = $fotoReportaje->url;
                    $carpetaFotosReportajes = '../public/img/fotosReportaje/';
                    unlink($carpetaFotosReportajes.$imagen);
                }
            }
            
            foreach($reportajes as $reportaje){
                $this->borrarFotosReportajesFotografo($reportaje->id);
            }
            
            
            //BORRAMOS DE LA CARPETA DE IMAGENES LAS FOTOS DE LOS REPORTAJES QUE SE VAN A ELIMINAR
            foreach($reportajes as $reportaje){
                $imagen = $reportaje->url;
                $carpetaReportajes = '../public/img/reportajes/';
                unlink($carpetaReportajes.$imagen);
            }

            //SE ELIMINAN LOS REPORTAJES QUE EXISTAN DE ESE FOTOGRAFO
            $this->borrarRegistrosReportajesFotografo($idFotografo);

            //SE BUSCA EL PERFIL DEL USUARIO PARA SACAR LA FOTO Y BORRARLA DE LA CARPETA DE IMAGENES
            $info = $this->apiUsers->existePerfil($idFotografo);

            $imagen = $info->url;
            $carpetaperfiles = '../public/img/perfiles/';
            unlink($carpetaperfiles.$imagen);

            //Se borra el registro de info del fotografo
            $this->borrarRegistroInfoFotografo($idFotografo);


            $this->borrarFotografo($idFotografo);

            header('Location: '.$_ENV['BASE_URL'].'admi/panel');
        }
    }

    public function buscarFotosReportaje($idReportaje){
        $fotos = $this->apiReportajes->buscarFotosReportaje($idReportaje);
        return $fotos;
    }

    public function borrarFotosReportajesFotografo($idReportaje){
        $this->apiReportajes->borrarFotosReportajesFotografo($idReportaje);
    }

    public function borrarRegistrosReportajesFotografo($idFotografo){
        $idFotografo = json_decode($idFotografo);
        $this->apiUsers->borrarRegistrosReportajesFotografo($idFotografo);
    }

    public function borrarRegistroInfoFotografo($idFotografo){
        $this->apiUsers->borrarRegistroInfoFotografo($idFotografo);
    }

    public function borrarFotografo($idFotografo){
        $idFotografo = json_decode($idFotografo);
        $this->apiUsers->borrarFotografo($idFotografo);
    }

    /** VAMOS A REALIZAR METODOS DE FOTOGRAFO */

    public function sacarInfoFotografo(){
        $this->pages->render('fotografo/info');
    }

    public function registrarInfoFotografo(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; // Guardamos en la variable los datos que vienen del formulario
                $imagen = $_FILES['url'];

                $alertas = SaneaValida::ValidaInfo($data, $imagen);
                if(empty($alertas)){

                    //Subida de archivos

                    //Crear carpeta

                    $carpetaImagenesFotografos = '../public/img/perfiles/';

                    if(!is_dir($carpetaImagenesFotografos)){
                        mkdir($carpetaImagenesFotografos, 0777, true);
                    }

                    $nombreImagen = md5( uniqid( rand(), true)).'.jpg';
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenesFotografos.$nombreImagen);

                    $data = json_encode($data); 
                    $url = json_encode($nombreImagen);
                    $result = $this->apiUsers->registrarInfo($data, $url);

                    if($result){
                        header('Location: '.$_ENV['BASE_URL']. 'fotografo/perfil/'.$_SESSION['id']);
                    }

                }
            }
        }
        $this->pages->render('fotografo/info', ['alertas' => $alertas]);
    }

    public function sacarPerfilFotografo($id){
        $perfil = $this->apiUsers->existePerfil($id);
        $_SESSION['reportajes'] = $this->sacarReportajes($id);
        $this->pages->render('fotografo/perfil', ['perfil' => $perfil]);
    }

    public function sacarReportajes($id){
        $reportajes = $this->apiReportajes->buscarReportajes($id);
        return $reportajes;
    }


    //Poder mandar y recibir emails

    public function sacarMensajeEmail($idFotografo){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data']; // Guardamos en la variable los datos que vienen del formulario
                $alertas = SaneaValida::ValidaContacto($data);
                if(empty($alertas)){
                    $idFotografo = json_encode($idFotografo);
                    $fotografo = $this->apiUsers->findId($idFotografo);

                $email = new Email($fotografo->email, '', '', $data);
                $email->enviarEmailFotografo();

                $idFotografo = json_decode($idFotografo);
                header('Location: '.$_ENV['BASE_URL']. 'fotografo/perfil/'.$idFotografo);
                }
            }
        }
        $this->pages->render('fotografo/info', ['alertas' => $alertas]);
    }


    public function enviarCorreoAdmi(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $email = $_POST['data']['email'];
                $email = new Email('', '', '', $email);
                $email->enviarCorreoAdmi();

                header('Location: '.$_ENV['BASE_URL']);
            }
        }
}
    

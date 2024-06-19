<?php 

namespace Lib;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $id;
    public $mensaje;

    public function __construct($email = '', $nombre = '', $id = '', $mensaje = ''){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->mensaje = $mensaje;        
    }

    public function enviarConfirmacion(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'merakifotografiatfg@gmail.com';
        $mail->Password = 'ebbq epen quch enjm';

        $mail->setFrom('merakifotografiatfg@gmail.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        //Set html

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>". $this->nombre."</strong> Has creado tu cuenta en Meraki, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='https://meraki.organify.es/public/confirmarCuenta/" . $this->id . "'>Confirmar Cuenta</a>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    public function enviarInstrucciones(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'merakifotografiatfg@gmail.com';
        $mail->Password = 'ebbq epen quch enjm';

        $mail->setFrom('merakifotografiatfg@gmail.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Restablece tu contraseña';

        //Set html

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>". $this->nombre."</strong> Has solicitado reestablecer tu contraseña, sigue las instrucciones para hacerlo</p>";
        $contenido .= "<p>Presiona aquí: <a href='https://meraki.organify.es/public/recuperar/" . $this->id . "'>Reestablecer contraseña</a>";
        $contenido .= "<p>Si tu no solicitaste reestablecerla, puedes ignorar el mensaje</p>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    public function enviarCorreoAdmi(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'merakifotografiatfg@gmail.com';
        $mail->Password = 'ebbq epen quch enjm';

        $mail->setFrom('merakifotografiatfg@gmail.com');
        $mail->addAddress('merakifotografiatfg@gmail.com', 'Administrador');
        $mail->Subject = 'Problemas con la web';

        //Set html

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola , tengo problemas para realizar algunas operaciones dentro de su página.</p>";
        $contenido .= "<p>Por favor contacteme. Mi correo es: </p>";
        $contenido .= "<li>".$this->mensaje."</li>";
        $contenido .= "<p>Muchas gracias</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }


    public function enviarEmailFotografo(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'merakifotografiatfg@gmail.com';
        $mail->Password = 'ebbq epen quch enjm';

        $mail->setFrom('merakifotografiatfg@gmail.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Datos de contacto';

        //Set html

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola , te han enviado unos datos de contacto a través de nuestra plataforma</p>";
        $contenido .= "<p>Datos: </p>";
        $contenido .= "<li>".$this->mensaje['nombre']."</li>";
        $contenido .= "<li>".$this->mensaje['email']."</li>";
        $contenido .= "<li>".$this->mensaje['telefono']."</li>";
        $contenido .= "<p>¡¡Esperemos que te vaya todo bien!! ¡¡Nos vemos en la proxima!!</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

}
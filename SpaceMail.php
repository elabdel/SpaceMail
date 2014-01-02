<?php

/**
 * Description of SpaceMail
 * Sistema de aviso vía correo del estado de uso del espacio de una unidad (HDD) de nuestro servidor, utilizando una Class de PHP y
 * la libreria de envio de E-mails "sendmail".
 * Uso habitual desde la consola de comandos.
 * @author Abdel
 */
class SpaceMail {
    //Atributos
    //Atributos de la comprobación
    private $dev = NULL;
    private $procentaje = NULL;
    private $espacioLibre = NULL;
    private $espacioTotal = NULL;
    private $espacioLibreGB = NULL;
    private $espacioTotalGB = NULL;
    private $espacioLibreProcentaje = NULL;
    private $procentajeUsado = NULL;
    //Atributos del envio del E-mail
    private $destinatario = NULL;
    private $remitente = NULL;
    private $asunto = NULL;
    private $texto = NULL;
    private $cabeceras = NULL;

    //Constructor
    public function __construct() {
        
    }

    //Funciones Setters
    //Set Unidad
    public function setDev($dev) {
        if (isset($dev)) {
            $this->dev = $dev;
        } else {
            $this->dev = "c:/";
        }
    }
    
    //Set Procentaje
    public function setProcentaje($procentaje=NULL) {
        if (isset($procentaje)) {
            $this->procentaje = $procentaje;
        } else {
            $this->procentaje = 90;
        }
    }
    
    //Set Espacio Libre
    private function setEspacioLibre() {
        $dev = $this->getDev();
        if (isset($dev)) {
            $this->espacioLibre = disk_free_space($dev);
        } else {
            $this->espacioLibre = "0";
        }
    }

    //Set Espacio Total
    private function setEspacioTotal() {
        $dev = $this->getDev();
        if (isset($dev)) {
            $this->espacioTotal = disk_total_space($dev);
        } else {
            $this->espacioTotal = "0";
        }
    }

    //Set Espacio Libre en GB
    private function setEspacioLibreGB() {
        $espacioLibre = $this->espacioLibre;
        if (isset($espacioLibre)) {
            $this->espacioLibreGB = $espacioLibre / 1024 / 1024 / 1024;
        } else {
            $this->espacioLibreGB = "0";
        }
    }

    //Set Espacio Total en GB
    private function setEspacioTotalGB() {
        $espacioTotal = $this->espacioTotal;
        if (isset($espacioTotal)) {
            $this->espacioTotalGB = $espacioTotal / 1024 / 1024 / 1024;
        } else {
            $this->espacioTotalGB = "0";
        }
    }

    //Set Procentaje Espacio Libre
    private function setEspacioLibreProcentaje() {
        $espacioLibre = $this->espacioLibre;
        $espacioTotal = $this->espacioTotal;
        if (isset($espacioLibre) and isset($espacioTotal)) {
            $this->espacioLibreProcentaje = ($espacioLibre / $espacioTotal) * 100;
        } else {
            $this->espacioLibreProcentaje = "0";
        }
    }

    //Set Procentaje Usado
    private function setProcentajeUsado() {
        $espacioLibre = $this->espacioLibre;
        $espacioTotal = $this->espacioTotal;
        if (isset($espacioLibre) and isset($espacioTotal)) {
            $this->procentajeUsado = (1 - ($espacioLibre / $espacioTotal)) * 100;
        } else {
            $this->procentajeUsado = "0";
        }
    }

    //Set Destinatario
    public function setDestinatario($destinatario = NULL) {
        if (isset($destinatario)) {
            $this->destinatario = $destinatario;
        } else {
            $this->destinatario = "micuenta@localhost";
        }
    }

    //Set Remitente
    public function setRemitente($remitente = NULL) {
        if (isset($remitente)) {
            $this->remitente = $remitente;
        } else {
            $this->remitente = "aviso@localhost";
        }
    }

    //Set Asunto
    public function setAsunto($asunto = NULL) {
        if (isset($asunto)) {
            $this->asunto = $asunto;
        } else {
            $this->asunto = "Aviso del espacio libre en el disco duro";
        }
    }

    //Set el texto del mensaje enviado
    public function setTexto($texto = NULL) {
        if (isset($texto)) {
            $this->texto = $texto;
        } else {
            $this->texto = "Aviso del espacio libre en el disco duro.";
        }
    }

    //Set las cabeceras del mensaje
    public function setCabeceras($cabeceras = NULL) {
        if (isset($cabeceras)) {
            $this->cabeceras = $cabeceras;
        } else {
            $this->cabeceras = "MIME-Version: 1.0\r\n";
            $this->cabeceras .= "Content-type: text/html; charset=utf-8\r\n";
            $this->cabeceras .= "From: " . $this->getRemitente() . " \r\n";
        }
    }

    //Funciones Getters
    //Get Unidad
    private function getDev() {
        return $this->dev;
    }
    
    //Get Procentaje
    private function getProcentaje() {
        return $this->procentaje;
    }
    
    //Get Espacio Libre
    private function getEspacioLibre() {
        return $this->espacioLibre;
    }

    //Get Espacio Total
    private function getEspacioTotal() {
        return $this->espacioTotal;
    }

    //Get Espacio Libre en GB
    private function getEspacioLibreMB() {
        return $this->espacioLibreGB;
    }

    //Get Espacio Total en GB
    private function getEspacioTotalMB() {
        return $this->espacioTotalGB;
    }

    //Get Procentaje Espacio Libre
    private function getEspacioLibreProcentaje() {
        return $this->espacioLibreProcentaje;
    }

    //Get Procentaje Usado
    private function getProcentajeUsado() {
        return $this->procentajeUsado;
    }

    //Get Destinatario
    private function getDestinatario() {
        return $this->destinatario;
    }

    //Get Remitente
    private function getRemitente() {
        return $this->remitente;
    }

    //Get Asunto
    private function getAsunto() {
        return $this->asunto;
    }

    //Get Texto
    private function getTexto() {
        return $this->texto;
    }

    //Get Cabezeras
    private function getCabezeras() {
        return $this->cabeceras;
    }

    //Metodos
    //Comprobar Espacio
    public function comprobarEspacio() {
        $this->setEspacioLibre();
        $this->setEspacioTotal();
        $this->setEspacioLibreGB();
        $this->setEspacioTotalGB();
        $this->setEspacioLibreProcentaje();
        $this->setProcentajeUsado();
        echo "Unidad : " . $this->dev . " <br>";
        $texto = "Espacio Libre en GB : " . $this->espacioLibreGB . " GB <br>";
        $texto .= "Espacio Total en GB : " . $this->espacioTotalGB . " GB <br>";
        $texto .= "Procentaje del espacio libre : " . $this->espacioLibreProcentaje . " %<br>";
        $texto .= "Procentaje del espacio usado : " . $this->procentajeUsado . " % <br>";
        $texto .= "<br>";
        if ($this->procentajeUsado >= $this->getProcentaje()) {
            $texto .= "El procentaje de de uso es mayor que el " . $this->getProcentaje(). " % <br>";
            echo $texto;
            $this->setTexto($texto);
            $this->enviarMail();
        } else {
            $texto .= "El procentaje de de uso es menor que " . $this->getProcentaje(). " % <br>";
            echo $texto;
        }
    }

    //Enviar Correo
    private function enviarMail() {
        $this->setAsunto();
        $this->setCabeceras();
        $destinatario = $this->getDestinatario();
        $asunto = $this->getAsunto();
        $texto = $this->getTexto();
        $cabeceras = $this->getCabezeras();

        mail($destinatario, $asunto, $texto, $cabeceras);
    }

}

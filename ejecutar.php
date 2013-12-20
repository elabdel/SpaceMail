<?php
include 'SpaceMail.php';
$SpaceMail = new SpaceMail();
$SpaceMail->setDev("c:/");
$SpaceMail->setProcentaje(90);
$SpaceMail->setDestinario("micorreo@midominio.com");
$SpaceMail->setRemitente("aviso@midominio.com");
$SpaceMail->comprobarEspacio();
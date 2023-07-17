<?php
require_once '../classe/s_locais.php';
ob_start();
require_once '../Model/validacao_login.php';
ini_set('default_charset','UTF-8');



$s_locais = new s_locais();

if(isset($_POST['enviar'])){
    
    $nomeLocal = $_POST['nomeLocal'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
            
    $s_locais->setNomeLocal($nomeLocal);
    $s_locais->setLatitude($latitude);
    $s_locais->setLongitude($longitude);
     
}
if($s_locais->inserirLocais()){
    $_SESSION['msg'] = "<div class='alert alert-success' id='msg' role='alert'>Local cadastrado com sucesso!</div>";
    header("Location:../Viewer/locais.php");    
}else{
    $_SESSION['msg'] = "<div class='alert alert-success' id='msg' role='alert'>Funcionário cadastrado com sucesso!</div>";
    header("Location:../Viewer/locais.php");     
}
 
?>



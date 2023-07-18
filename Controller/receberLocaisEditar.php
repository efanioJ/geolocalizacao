<?php
require_once '../Model/s_locais.php';
ob_start();
require_once '../Model/validacao_login.php';
ini_set('default_charset','UTF-8');



$s_locais = new s_locais();

if(isset($_POST['excluir'])){
    $idLocal = $_POST['idLocal'];
    
    $s_locais->setIdLocal($idLocal);
 
    if($s_locais->deleteLocal($idLocal)){
        $_SESSION['msg'] = "<div class='alert alert-success' id='msg' role='alert'>Registro deletado com sucesso!</div>";
        header("Location:../Viewer/Locais.php");    
    }else{
        $_SESSION['msg'] = "<div class='alert alert-danger' id='msg' role='alert'>Erro: Local não excluído!</div>";
        header("Location:../Viewer/Locais.php");     
    }
     
  

}else{
    if(isset($_POST['enviar'])){
    
        $idLocal = $_POST['idLocal'];
        $nomeLocal = $_POST['nomeLocal'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $coordenadasPoligono = $_POST['coordenadasPoligono'];
        
        $s_locais->setIdLocal($idLocal);
        $s_locais->setNomeLocal($nomeLocal);
        $s_locais->setLatitude($latitude);
        $s_locais->setLongitude($longitude);
        $s_locais->setCoordenadasPoligono($coordenadasPoligono);
         
    }
    if($s_locais->atualizarLocais()){
        $_SESSION['msg'] = "<div class='alert alert-success' id='msg' role='alert'>Informação do local alterado com sucesso!</div>";
        header("Location:../Viewer/editarLocais.php?idLocal=$idLocal");    
    }else{
        $_SESSION['msg'] = "<div class='alert alert-danger' id='msg' role='alert'>Erro: Local não editado!</div>";
        header("Location:../Viewer/editarLocais.php?idLocal=$idLocal");     
    }
}

 
?>



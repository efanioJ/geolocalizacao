<?php
require_once 'Model/s_locais.php';
ini_set('default_charset','UTF-8');


?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Cadastro de locais - GeoLoca</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="estilo/estiloIndex2.css">
  </head>

  <body>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary mb-4">
          <a class="navbar-brand" href="#">GEOLOCA</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
              
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <ul class="navbar-nav mr-auto">
                    
                    <li class="nav-item active">
                          <a class="nav-link" href="">Sobre <span class="sr-only">(current)</span></a>
                    </li>  
                </ul>
            
            </form>  
          </div>
      </nav>
        
          <div class="row justify-content-center" >
          
              <div class="mt-9">
              <form id="formCadastrar" action="" method="post">  
                <form class="form-signin">
                      <div class="text-center mb-4">
                          <img class="mb-4" src="img/logoSEBRAE.jpg" alt="" width="230" height="110">
                          <h1 class="h3 mb-3 font-weight-normal">Sistema de cadastro de locais</h1>
                      </div>
                      
                      <div class="form-label-group">
                          <input type="text" id="inputEmail" name="inputEmail" class="form-control" :placeholder-shown="Usuário"  required autofocus>
                          <label for="inputEmail">E-mail</label>
                      </div>

                      <div class="form-label-group">
                          <input type="password" id="inputSenha" name="inputSenha" class="form-control" :placeholder-shown="Senha" required>
                          <label for="inputSenha">Senha</label>
                      </div>
                      <div class="">
                        <label>
                          <a class="" href="recuperarSenha.php">Esqueceu sua senha?</a>
                          
                        </label>
                      </div>
                      <div class="checkbox mb-3">
                        <label>
                          <input type="checkbox" value="remember-me"> Lembrar-me
                        </label>
                      </div>

                      <input type="submit" name="btn_login" class="btn btn-lg btn-primary btn-block" value="Entrar">
                      <br>
                      <?php
                      $s_locais = new s_locais();
                      if(isset($_POST["btn_login"])){
                          
                          $email = $_POST["inputEmail"];
                          $senha = $_POST["inputSenha"];
                          $s_locais->setEmail($email);
                          $s_locais->setSenha($senha);
                          $s_locais->login();
                                     
                             
                      }
                ?>
                      <!--<p class="mt-5 mb-3 text-muted text-center tamFontefooter">&copy; Desenvolvido por: Efânio Jeferson<br>2022 - SENAI Vitória da Conquista</p>-->
                </form>  
                
                
              </div>
          </div>

         
       </form>   
          
  </body>
</html>

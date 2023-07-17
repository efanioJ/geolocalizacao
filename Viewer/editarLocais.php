<?php
require_once '../Model/s_locais.php';
ob_start();
require_once '../Model/validacao_login.php';
ini_set('default_charset','UTF-8');
?>


<!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8">
      <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css"  media="screen,projection"/>
      <link rel="stylesheet" href="../css/estilo/estilo.css">
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Locais</title>
    </head>

    <body>   
        <?php
          include "menu.php";
          $s_locais = new s_locais(); 
          $idLocal = filter_input(INPUT_GET, 'idLocal', FILTER_SANITIZE_SPECIAL_CHARS);
          
          
          $resultado = $s_locais->buscarLocal($idLocal,"ID");
        ?> 
                 
        <br>
        <br>
        <br>
        <br>
        <main role="main" class="container">
            <div class="jumbotron">
              <h1>Gerenciar Locais</h1>
                   <?php
                    if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                    }
                    ?>
                  <h3>Editar Locais</h3>
                  <p class="lead"><span class="corCamposObri">* Campos obrigatórios</span></p>
                  <form id="formCadastrar" action="../controller/receberLocaisEditar.php" method="post" enctype="multipart/form-data">
                      <div class="form-row">
                          <?php
                                   foreach ($resultado as $res => $val) {
                          ?>
                          <div class="form-group col-md-1">
                            <label for="idLocal" class="lead">Nº<span class="corCamposObri">*</span></label>
                            <input type="text" name="idLocal" id="idLocal" class="form-control lead" placeholder="" value="<?php echo $val->idLocal ?>" ReadOnly>
                          </div>
                          <div class="form-group col-md-3">
                            <label for="nomeLocal" class="lead">Nome do Local<span class="corCamposObri">*</span></label>
                            <input type="text" name="nomeLocal" id="nomeLocal" class="form-control lead" placeholder="Digite o nome do local" value="<?php echo $val->nomeLocal ?>" required>
                          </div>
                          <div class="form-group col-md-2.5">
                            <label for="latitude" class="lead">Latitude<span class="corCamposObri">*</span></label>
                            <input type="text" name="latitude" id="latitude" class="form-control lead" placeholder="" value="<?php echo $val->latitude ?>" ReadOnly>
                          </div>
                          <div class="form-group col-md-2.5">
                            <label for="longitude" class="lead">Longitude<span class="corCamposObri">*</span></label>
                            <input type="text" name="longitude" id="longitude" class="form-control lead" placeholder="" value="<?php echo $val->longitude ?>" ReadOnly>
                          </div>
                          <div class="form-group col-md-2.5 align-self-end ">
                            <button type="button"  name = "buscarEditar" id="buscarEditar" role="button" class="btn btn btn-primary estiloFonte">Ver no mapa</button>
                          </div>
                          <div class="form-group col-md-2.5 align-self-end ">
                            
                            <a class="btn btn-success estiloFonte" href="locais.php">Novo</a>
                          </div>
                      </div>
                      <div class="row justify-content-end">
                          <div class="form-group col-md-3 align-self-end ">
                            <button type="submit"  name = "enviar" id="enviar" role="button" class="btn btn-success  estiloFonte">Salvar</button>
                            <button type="submit"  name = "excluir" id="excluir" role="button" class="btn btn-danger estiloFonte">Excluir</button>        
                          </div>
                          <?php 
                              }
                          ?>
                      </div>
                  </form>
                  <div id="map" name="map" hidden></div>
                  <h3>Locais Cadastrados</h3>
                  <div class="tabela rolagem">
                    <table class="table" id="tabela">
                        <?php
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                            $s_locais = new s_locais();
                            if(isset($_POST['buscar'])){
                                $buscaF = $_POST['buscaF'];
                                $valorF = $_POST['valorF'];
                        ?>
                                
                        <?php
                            }
                            $result = null; 
                            $result = $s_locais->buscarlocal("null","all");
                            
                            if($result == null){
                         ?>
                              <div class='alert alert-danger' id='msg' role='alert'>Não foi encontrado nenhum registro!</div>
                              
                          <?php
                            }else{
                              ?>
                                <thead class="table-active ">
                                  <tr class="nQuebra">
                                    <th class="trlinha lead" scope="col">Nº do Local</th>
                                    <th class="trlinha lead" scope="col">Nome do Local</th>
                                    <th class="trlinha lead" scope="col">Latitude</th>
                                    <th class="trlinha lead" scope="col">Longitude</th>
                                    <th class="trlinha lead" scope="col">Ações</th>
                                  </tr>
                                </thead>
                              <?php  
                              foreach ($result as $res => $value) {
                          ?>
                                <tbody>
                                    <tr class="nQuebra trlinhaBuscar">
                                      <td class="teste" class="lead tamLetraBuscar"><?php echo $value->idLocal;?></td>
                                      <td class="lead tamLetraBuscar"><?php echo $value->nomeLocal;?></td>
                                      <td class="lead tamLetraBuscar"><?php echo $value->latitude;?></td>
                                      <td class="lead tamLetraBuscar"><?php echo $value->longitude;?></td>
                                      <td ><a class="btn btn-warning" href="editarLocais.php?idLocal=<?php echo $value->idLocal?>">Editar</a></td>
                                          
                          <?php
                              }
                            }  
                          ?>
                                    </tr>
                                </tbody>

                    </table>
                  </div>
               </div>
              </main>


      <script type="text/javascript" src="../js/jquery-3.4.1.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="../js/js/bootstrap.min.js" ></script>
      <script type="text/javascript" src="../js/jquery.validate.min.js" ></script>
      <script type="text/javascript" src="../js/jquery.mask.min.js" ></script>
      <script type="text/javascript" src="../js/additional-methods.min.js" ></script>
      <script type="text/javascript" src="../js/localization/messages_pt_BR.js" ></script>
      <script type="text/javascript" src="../Validacao_JQ/validacao.js" ></script>
      
      
    </body>
  </html>
<?php
  $pdo = new PDO('mysql:host=localhost;dbname=bootstrap_projeto','root','');
  $sobre = $pdo->prepare("SELECT * FROM `tb_sobre`");
  $sobre->execute();
  $sobre = $sobre->fetch()['sobre'];
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

    <title>Painel CMS</title>
  </head>
  <body>
  <ul id="menu-principal" class="nav nav-tabs" >
  <li class="nav-item">
    <a class="nav-link active" href="#">Painel CMS</a>
  </li>
  <li class="nav-item">
    <a ref_sys="sobre" class="nav-link" href="#">Editar sobre</a>
  </li>
  <li class="nav-item">
    <a ref_sys="cadastrar_equipe" class="nav-link" href="#">Cadastrar equipe</a>
  </li>
  <li class="nav-item">
    <a ref_sys="lista_equipe" class="nav-link" href="#">Lista Equipe</a>
  </li>
</ul>
<div>
    <header id="header">
      <div class="container">
          <div class="row">
              <div class="col-md-9">
                <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Painel de controle</h2>
              </div>
              <div class="col-md-3">
                  <p><span class="glyphicon glyphicon-time"></span> Seu último login foi em: 12/06/2019</p>
              </div>
          </div>
      </div>
    </header>

    <section class="principal">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
                    <a href="#" class="list-group-item active cor-padrao" ref_sys="sobre">Sobre</a>
                      <a href="#" class="list-group-item" ref_sys="cadastrar_equipe">Cadastrar Equipe</a>
                   <a href="#" class="list-group-item" ref_sys="lista_equipe">
                    Lista Equipe <span class="badge badge-secondary">2</span></a>
                  </div>
                  <br />
          </div>
          <div class="col-md-3">
            <?php 
              if(isset($_POST['editar_sobre'])){
                $sobre = $_POST['sobre'];
                $pdo->exec("DELETE FROM `tb_sobre`");
                $sql = $pdo->prepare("INSERT INTO `tb_sobre` VALUES (null,?)");
                $sql->execute(array($sobre));
                if($sobre == '' ){
                  echo '<div class="alert alert-danger" role="alert"> O campo precisa ser preenchido :) </div>';
                } else {
                 echo '<div class="alert alert-success" role="alert"> o código html <b>Sobre</b> foi editado com sucesso !</div>'; }
              }
            ?>
            <div id="sobre_section" class="panel panel-default">
              <div>
                <h6 class="list-group-item active cor-padrao">Sobre</h6>
                </div>
                
                  <div class="panel-body">
                    <form method="post">
                  <div class="form-group">
                    <label for="email">Código HTML</label>
                    <textarea name="sobre" class="form-control"><?php echo $sobre;?></textarea>
                  </div>
                  <input type="hidden" name="editar_sobre" value="">
                  <button type="submit" name="acao" class="btn btn-outline-info">Submit</button>
                </form>
                </div>

                <div id="cadastrar_equipe_section" class="panel panel-default">
              <div class="panel-heading cor-padrao">
                <h6 class="list-group-item active cor-padrao">Cadastrar equipe</h6>
                </div>
                  <div class="panel-body">
                    <form>
                    <div class="form-group">
                    <label for="email">Nome do membro:</label>
                    <input type="text" name="nome_membro" class="form-control">

                  </div>
                  <div class="form-group">
                    <label for="email">Descrição do membro:</label>
                    <textarea class="form-control"></textarea>
                  </div>
                  <button type="submit" class="btn btn-outline-info">Submit</button>
                </form>
                </div>
               </div>
               
             

                <div id="lista_equipe_section"class="panel panel-default">
              <div class="panel-heading cor-padrao">
                <h6 class="list-group-item active cor-padrao">Membros da equipe:</h6>
                </div>
                  <div class="panel-body">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>ID:</th>
                              <th>Nome do membro:</th>
                              <th>#:</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                </div>
              </div>
        
            </div>
          </div>
        </div>
      </section>
        
</section>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(function(){

        cliqueMenu();
        scrollItem();
          function cliqueMenu(){
              $('#menu-principal a, .list-group a').click(function(){
                 $('.list-group a').removeClass('active').removeClass('cor-padrao');
                 $('#menu-principal a').parent().removeClass('active');
                 //console.log('#menu-principal a[ref_sys='+$(this).attr('ref_sys')+']');
                $('#menu-principal a[ref_sys='+$(this).attr('ref_sys')+']').parent().addClass('active');
                $('.list-group a[ref_sys='+$(this).attr('ref_sys')+']').addClass('active').addClass('cor-padrao');
                return false;
              })
          }
          
          function scrollItem(){
               $('#menu-principal a, .list-group a').click(function(){
                    var ref = '#'+$(this).attr('ref_sys')+'_section';
                    var offset = $(ref).offset().top;
                    $('html,body').animate({'scrollTop':offset-50});
                    if($(window)[0].innerWidth <= 768){
                    $('.icon-bar').click();

                    }
              }); 
          }
          
          $('button.deletar-membro').click(function(){
              var id_membro = $(this).attr('id_membro');
              var el = $(this).parent().parent();
              $.ajax({
                  method:'post',
                  data:{'id_membro':id_membro},
                  url:'deletar.php'
              }).done(function(){
                el.fadeOut(function(){
                 el.remove();
              });
              })
              
              
          })

      })
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
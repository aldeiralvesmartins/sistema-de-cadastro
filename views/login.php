<?php
session_start();

if(isset($_SESSION['usuarioLog']))
{
  header("location:cadastraProdutos.php");
  die();
}

include '../includes/header.php';
include '../classes/cadastro.php';

$c = new usuario("app_db", "localhost:3306", "r2soft", "r2147258369");
?>
      <form method="POST">
        <h2>LOGIN</h2>
        <input type="email" placeholder="Email" name="usuario" id="usuario">

        <input type="password"placeholder="Senha" name="senha_usuario" id="senha_usuario">

        <input type="submit" value=" Entrar" >
        <a id="t" href="fazerCadastro.php">Ainda não sou inscrito <strong>Cadastrar</strong></a>
      </form>
      <?php
    if(isset($_POST['usuario']))
    {
      $usuario = addslashes($_POST['usuario']);
      $senha = addslashes($_POST['senha_usuario']);

      if(!empty($usuario) && !empty($senha))
      {     
            $_SESSION['usuarioLog'] = true;
                  if($c->logar($usuario,$senha))
                  {
                    header("location:cadastraProdutos.php");
                  }else{
                    echo " Email e/ou senha estão incorretos!";
                  }

      }else{
        echo "Preencha todos os campos!";
      }

    }
    
    
    include '../includes/footer.php';

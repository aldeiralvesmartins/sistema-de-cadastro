<?php
include '../includes/header.php';
include '../classes/cadastro.php';

$c = new usuario();
        if(isset($_POST["nome"]))
        //clicou no botão cadastrar ou editar
        {
            $nome = addslashes($_POST['nome']);
            $usuario = addslashes($_POST['usuario']);
            $senha = addslashes($_POST['senha_usuario']);
            $confirmarsenha = addslashes($_POST['confSenha']);
               //verifica se esta preenchido 
            if(!empty($nome) && !empty($usuario) && !empty($senha) && !empty($confirmarsenha))
            {
              if($senha == $confirmarsenha)
              {
                      if($c->cadastrarUsuario($usuario,$senha ,$nome))
                      {
                          echo "usuario foi cadastrada!";
                      }else{
                        echo " Usuario cadastrado com sucesso!";
                      }
              }else{
                    echo "Senha não corresponde com confirmar senha!";
                   }  
            }
            else
            {
                    echo "preencha todos os campos";
            }

        }
  ?>
  
      <form method="POST">
        <h2>CADASTRAR USUARIO</h2>
        
        <input type="text"placeholder="Nome " name="nome" id="nome">

        <input type="email" placeholder="Email" name="usuario" id="usuario">

        <input type="password"placeholder="Senha" name="senha_usuario" id="senha_usuario">

        <input type="password" placeholder="Confirmar Senha" name="confSenha" id="confSenha">

        <input type="submit" value=" Cadastrar">
        <a id="t" href="login.php">Já é inscrito?<strong>Login</strong></a>
      </form>
    <?php
  
      include '../includes/footer.php';
      ?>
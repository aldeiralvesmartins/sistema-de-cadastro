<?php
require_once 'categoria.php';
$c = new Categoria("app_db", "localhost:3306", "r2soft", "r2147258369");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Categorias</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body> 
  <?php
if(isset($_POST["code_Categories"]))
//clicou no botão cadastrar ou editar
{
  //--------------editar----------------------------
       if(isset($_GET['id_up']) && !empty($_GET['id_up']))
       {
            $id_upd = addslashes($_GET["id_up"]);     
            $code = addslashes($_POST["code_Categories"]);
            $nome = addslashes($_POST["name_Categories"]);
            if(!empty($code) && !empty($nome))
            {
    
                $c->atualizarDados($id_upd, $code, $nome);
                header("location: index.php");
   
            }
            else
            {
            echo "preencha todos os campos";
            }
        }
  //----------------cadastrar----------------------
        else
        {

            $code = addslashes($_POST["code_Categories"]);
            $nome = addslashes($_POST["name_Categories"]);
            if(!empty($code) && !empty($nome))
            {
    
                if(!$c->cadastrarCategorias($code, $nome))
                {
                    echo "Essa Categoria ja foi cadastrada";
                }
  
            }
            else
            {
                    echo "preencha todos os campos";
            }
          

        }
}
  ?>
  <?php
  
  if(isset($_GET['id_up']))
  {
    $id_update = addslashes($_GET['id_up']);
    $res = $c->buscarDadosCategoria($id_update);
  }
  ?>
     <section id="esquerda">
      <form method="POST">
        <h2>CADASTRAR CATEGORIA</h2>
        <label for="code_Categories">CODIGO</label>
        <input type="number" name="code_Categories" id="code_Categories"
        value="<?php if(isset($res)){echo $res['code_Categories'];} ?>"
        >
        <label for="nome">NOME</label>
        <input type="text" name="name_Categories" id="name_Categories"
        value="<?php if(isset($res)){echo $res['name_Categories'];} ?>"
        >
        <input type="submit" 
        value="<?php if(isset($res)){echo 'Atualizar';}else{echo 'Cadastrar';} ?>">
      </form>
     </section>
     <section id="direita">
      
      <table>
        <tr id="titulo">
          <td>CODIGO</td>
          <td colspan="2">NOME</td>
        </tr>
        <?php
      $dados = $c->buscarDados();
         if(count($dados)> 0)
         {
          for ($i=0; $i <count($dados) ; $i++) 
          { 
            echo "<tr>";
            foreach ($dados[$i] as $k => $v)
            {
              if($k != "id_Categories")
              {
                  echo "<td>".$v."</td>";
              }
            }
            ?>
            <td>
              <a href="index.php?id_up=<?php echo $dados[$i]['id_Categories'];?>">Editar</a>
              <a href="index.php?id_Categories=<?php echo $dados[$i]['id_Categories'];?>">Excluir</a>
            </td>
        <?php
             echo "</tr>";
          }
        
         }
         else
         {
          echo "O banco está vazio";
         }
      ?>
      </table>
     </section>
</body>
</html>


<?php

if(isset($_GET['id_Categories']))
{
  $id_categoria = addslashes($_GET['id_Categories']);
  $c->excluirCategoria($id_categoria);
  header("location: index.php");
}
?> 

<?php
session_start();

if(!isset($_SESSION['usuarioLog']))
{
  header("location: login.php");
  session_destroy();
}
include 'includes/header.php';
include 'classes/produto.php';


$p = new Produto();
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
                      header("location: cadastraProdutos.php");
        
                  }else{
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
                    if(!$p->cadastrarCategorias($code, $nome))
                            {
                                echo "Essa Categoria ja foi cadastrada";
                            }
                    }else{
                          echo "preencha todos os campos";
                        }
              }

      }
 
  if(isset($_GET['id_up']))
  {
    $id_update = addslashes($_GET['id_up']);
    $res = $p->buscarDadosCategoria($id_update);
  }

  ?>
     <section id="esquerda">
      <form method="POST">
        <h2>CADASTRAR PRODUTO</h2>
        
        <input type="number" placeholder="Codigo Do Produto" name="code_Categories" id="code_Categories"
        value="<?php if(isset($res)){echo $res['code_Categories'];} ?>"
        >
        
        <input type="text" placeholder="Nome " name="name_Categories" id="name_Categories"
        value="<?php if(isset($res)){echo $res['name_Categories'];} ?>"
        >
        <input type="submit" 
        value="<?php if(isset($res)){echo 'Atualizar';}else{echo 'Cadastrar';} ?>">
        
      </form><button><a href="logout.php">Sair</a></button>
    </section>
    <section id="direita">
      
      <table>
        <tr id="titulo">
          <td>CODIGO DO PRODUTO</td>
          <td colspan="3">NOME</td>
        </tr>
        <?php
      $dados = $p->buscarDados();
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
              <a id="editar" href="cadastraProdutos.php?id_up=<?php echo $dados[$i]['id_Categories'];?>">Editar</a>
              <a id="excluir" href="cadastraProdutos.php?id_Categories=<?php echo $dados[$i]['id_Categories'];?>">Excluir</a>
            </td>
      </section>
           
        <?php
             echo "</tr>";
          }
        
         }
         else
         {
          echo "O banco está vazio";
         }

    if(isset($_GET['id_Categories']))
    {
      $id = addslashes($_GET['id_Categories']);
      $p->excluirCategoria($id);
      header("location:cadastraProdutos.php");
    }

   

include 'includes/footer.php';
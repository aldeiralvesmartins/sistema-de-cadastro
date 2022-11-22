<?php

Class usuario {
    
    private $PDO; 

    public function __construct($dbname = "app_db", $dbhost ="localhost:3306", $use = "r2soft", $senha = "r2147258369")
    {
        try {
            $this->PDO = new PDO("mysql:dbname=".$dbname.";host=".$dbhost, $use, $senha);
         } 
         catch (PDOException $e) {
            return "erro de banco de dados: ".$e->getMessage();
         }
         catch (PDOException $e) {
             return "erro generico: ".$e->getMessage();
          }
       
    }


    public function buscarDados()
    {
        $res = array();
        $cmd = $this->PDO->query("SELECT * FROM cliente ORDER BY id");
        $res =$cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarUsuario($usuario,$senha,$nome)
    {
        $cmd = $this->PDO->prepare("SELECT id  FROM cliente WHERE usuario = :u");
        $cmd->bindValue(":u", $usuario);                      
        $cmd->execute();
        if($cmd->rowcount() > 0)
        {
            return false;
        } else {
            $cmd = $this->PDO->prepare("INSERT INTO  cliente (usuario, senha_usuario, nome) VALUES (:u, :s, :n)");
            $cmd->bindValue(":u",$usuario);
            $cmd->bindValue(":s",md5($senha));
            $cmd->bindValue(":n",$nome);
            $cmd->execute();
           
        }
    }
    public function logar($usuario, $senha )
    {
         //verifica se o email e senha estão cadastrado, se sim
         $sql = $this->PDO->prepare("SELECT  id  FROM cliente  WHERE usuario =:u AND senha_usuario = :s");
         $sql->bindValue(":u", $usuario); 
         $sql->bindValue(":s",md5($senha));
         $sql->execute();
         
         if($sql->rowCount() > 0)
         { //entrar no sistema (sessao)
            $dados = $sql->fetch();
            session_start();
            $_SESSION['id'] = $dados['id'];
            return true;//logado com sucesso

         }else{
            return false;//não foi possivel logar
         }

    }

    public function buscarDadosCategoria($id)
    {
        $res = array();
        $cmd = $this->PDO->prepare("SELECT * FROM cliente WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarDadosUsuario($id,$usuario,$nome,$senha)
    {
        $cmd = $this->PDO->prepare("UPDATE cliente SET usuario = :u,senha = :s, nome = :n WHERE id = :id");
        $cmd->bindValue(":u",$usuario);
        $cmd->bindValue(":n",$nome);
        $cmd->bindValue(":s",$senha);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }
    public function excluirCategoriaUsuario($id)
    {
        $cmd = $this->PDO->prepare("DELETE FROM cliente WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }

    public function atualizarDados($id,$code,$nome)
    {
        $cmd = $this->PDO->prepare("UPDATE Categories SET code_Categories = :c, name_Categories = :n WHERE id_Categories = :id");
        $cmd->bindValue(":c",$code);
        $cmd->bindValue(":n",$nome);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }
    public function excluirCategoria($id)
    {
        $cmd = $this->PDO->prepare("DELETE FROM Categories WHERE id_Categories = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }

}
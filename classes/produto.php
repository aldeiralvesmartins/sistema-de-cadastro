<?php


Class Produto {
    
    private $PDO; 

    public function __construct($dbname = "app_db", $dbhost = "localhost:3306", $use = "r2soft", $senha ="r2147258369")
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
        $cmd = $this->PDO->query("SELECT * FROM Categories ORDER BY id_categories");
        $res =$cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function valorTotal()
    {
        $cmd = $this->PDO->query("SELECT sum(code_Categories) as quantidade from Categories");
        $res =$cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    public function cadastrarCategorias($code, $nome)
    {
        $cmd = $this->PDO->prepare("SELECT id_Categories FROM Categories WHERE code_Categories = :c");
        $cmd->bindvalue(":c",$code);
        $cmd->execute();
        if($cmd->rowcount() > 0)
        {
            return false;
        } else {
            $cmd = $this->PDO->prepare("INSERT INTO Categories(code_Categories, name_Categories)VALUES(:c,:n)");
            $cmd->bindValue(":c",$code);
            $cmd->bindValue(":n",$nome);
            $cmd->execute();
            return true;
        }
    }

    public function buscarDadosCategoria($id)
    {
        $res = array();
        $cmd = $this->PDO->prepare("SELECT * FROM Categories WHERE id_Categories = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
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

    public static function connection(){

        $dbname = "app_db";
        $dbhost = "localhost:3306";
        $use = "r2soft";
        $senha = "r2147258369";
        try {
           return new PDO("mysql:dbname=".$dbname.";host=".$dbhost, $use, $senha);
        } 
        catch (PDOException $e) {
           return "erro de banco de dados: ".$e->getMessage();
        }
        catch (PDOException $e) {
            return "erro generico: ".$e->getMessage();
         }
        }
}
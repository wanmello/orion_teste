<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
    public function getUser($id)
    {
        return $this->query("SELECT * FROM Customer WHERE ID = " . $id);
    }

    public function getCar($placa)
    {
        return $this->query("SELECT * FROM Customer WHERE PLACA_CARRO LIKE '%".$placa."'");
    }

    public function delUser($id)
    {
        return $this->query("DELETE FROM Customer WHERE ID = " . $id);
    }

    public function addUser($nome, $tel, $cpf, $placa_car)
    {
        return $this->query("INSERT INTO Customer (`NOME`, `TELEFONE`, `CPF`, `PLACA_CARRO`) VALUES ('".$nome."','".$tel."','".$cpf."','".$placa_car."')");
    }

    public function updateUser($nome, $tel, $cpf, $placa_car, $id)
    {
        return $this->query("UPDATE Customer SET NOME = '".$nome."', TELEFONE = '".$tel."',  CPF = '".$cpf."',  PLACA_CARRO = '".$placa_car."' WHERE ID = ".$id);
    }

}
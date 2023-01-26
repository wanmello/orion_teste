<?php
class UserController extends BaseController
{
    /** 
* "/user/list" Endpoint - Get list of users 
*/
    public function cliente()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $id = $_GET['id'];

        switch (strtoupper($requestMethod)) 
        {
            case 'GET':
                try {
                    $userModel = new UserModel();
                   
                    $arrUsers = $userModel->getUser($id);
                    $responseData = json_encode($arrUsers);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                break;
            case 'DELETE':
                try {
                    $userModel = new UserModel();
                    
                    $arrUsers = $userModel->delUser($id);
                    $responseData = json_encode($arrUsers);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                break;
            case 'PUT':
                try {
                    $userModel = new UserModel();

                    $nome       = $_GET['nome'];
                    $tel        = $_GET['tel'];
                    $cpf        = $_GET['cpf'];
                    $placa_car  = $_GET['placa'];

                    //validando se CPF é válido
                    validaCPF($cpf);
                    
                    $arrUsers = $userModel->updateUser($nome, $tel, $cpf, $placa_car, $id);
                    $responseData = json_encode($arrUsers);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                break;
        }        
        
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function clienteCadastro()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $nome = $_GET['nome'];
        $tel = $_GET['tel'];
        $cpf = $_GET['cpf'];
        $placa_car = $_GET['placa'];

        //validando se CPF é válido
        validaCPF($cpf);

        switch (strtoupper($requestMethod)) 
        {
            case 'POST':
                try {
                    $userModel = new UserModel();
                   
                    $arrUsers = $userModel->addUser($nome, $tel, $cpf, $placa_car);
                    $responseData = json_encode($arrUsers);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                break;
        }        
        
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function finalPlaca()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $placa_car = filter_var($_GET['placa'], FILTER_SANITIZE_NUMBER_INT);

        switch (strtoupper($requestMethod)) 
        {
            case 'GET':
                try {
                    $userModel = new UserModel();
                   
                    $arrUsers = $userModel->getCar($placa_car);
                    $responseData = json_encode($arrUsers);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
                break;
        }        
        
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    function validaCPF($cpf) 
    {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}
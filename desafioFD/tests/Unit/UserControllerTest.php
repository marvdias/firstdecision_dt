<?php

use PHPUnit\Framework\TestCase;
// Utilizado para acessar os arquivos diretamente.
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);

require_once "app/core/init.php";
require_once "autoload_phpunit.php";

use MarcusDias\FirstDecisionDT\Model\User;


class UserControllerTest extends TestCase
{

    public function test_register_user_success()
    {
        
        // Dados de teste
        $requestData = [
            'name' => 'testuser2',
            'email' => 'testuser@example.com',
            'password' => 'testpassword',
            'password2' => 'testpassword',
        ];

        // End-point de registro de usuário
        $url = ROOT.'/user/register';

        // cURL com POST para o endpoint utilixando os dados de teste
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        // Verifica o código de status HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verificar se o código de status HTTP foi 201 (Status utilizado para indicar registro)
        $this->assertEquals(201, $httpCode, 'O código de status HTTP não é 201');

        $jsonResult = json_decode($result, true);

        // Verificar se o retorno JSON tem status = sucesso
        $this->assertEquals('sucesso', $jsonResult['status'], 'O status no JSON não é "sucesso"');

        $user = new User;
        // Busca no BD o registro a partir do ID
        $userCreated = $user->first(['id' => $jsonResult['data']['id']]);
        // Verificações para garantir que os dados retornados do BD são os mesmos que foram inseridos
        $this->assertEquals($requestData['name'], $userCreated->name);
        $this->assertEquals($requestData['email'], $userCreated->email);
        $this->assertEquals($requestData['password'], $userCreated->password);

        curl_close($ch);
    }

    public function test_register_user_error()
    {
        
        // Dados de teste
        $requestData = [
            'name' => 'te',
            'email' => 'testuser@',
            'password' => 'test111',
            'password2' => 'test222',
        ];

        // End-point de registro de usuário
        $url = ROOT.'/user/register';
        
        // cURL com POST para o endpoint utilixando os dados de teste
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        // Verifica o código de status HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        
        // Verifica se o 
        $this->assertEquals(400, $httpCode, 'O código de status HTTP não é 400');

        // Verifica o resultado da requisição
        $this->assertNotFalse($result, 'A requisição cURL falhou');

        

        $jsonResult = json_decode($result, true);

        // Verifique o código de status no JSON
        $this->assertEquals('erro', $jsonResult['status']);

        $this->assertContains('Email inválido', $jsonResult['message']);
        $this->assertContains('Senhas devem coincidir', $jsonResult['message']);
        $this->assertContains('Name deve ter entre 3 e 50 caracteres', $jsonResult['message']);

        curl_close($ch);
    }
}

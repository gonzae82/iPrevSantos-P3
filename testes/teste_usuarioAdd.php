<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/assets/db.php';
require_once __DIR__ . '/../src/assets/processaAddUsuarioFunc.php';

class teste_usuarioAdd extends TestCase
{
    private $mysqli;

    protected function setUp(): void
    {
        // Conectar a um banco de testes
        $this->mysqli = new mysqli('localhost', 'gonzae', 'siaemicr', 'gonzae_processos_judiciais');
    }

    public function testCadastroUsuario()
    {
        $nome = 'Teste de Unidade';
        $email = 'teste@teste.com.br';
        $senha = '123456';
        $cargo = 'Teste';

        $resultado = cadastrarUsuario($this->mysqli, $nome, $email, $senha, $cargo);

        $this->assertTrue($resultado['success'], 'Cadastro falhou: ' . $resultado['error']);
    }

    protected function tearDown(): void
    {
        // Limpar usuário de teste, se necessário
        $this->mysqli->query("DELETE FROM usuarios WHERE email = 'teste@teste.com.br'");
        $this->mysqli->close();
    }
}
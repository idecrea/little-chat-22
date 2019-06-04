<?php

// Damos un espacio de trabajo aislado.
use PHPUnit\Framework\TestCase;

// Importamos nuestro código.
include_once('../src/valida/usuarios_valida.php');

// Creamos el test
class UsuariosTest extends TestCase
{
    private $miUsuario = null;
    private $connection = null;
    private $resultado = null;


    function setUp(): void
    {
        $this->connection = new PDO("sqlite:../littlechat22test.sqlite", "root", "");
        $this->miUsuario = new UsuariosValida($this->connection);
    }


    public function testNewUsuario(): void
    {
        $this->assertTrue($this->resultado = $this->miUsuario->validaDatosRegistro("blabl","user2@correo.com","aaa","aaa"), implode(" - ",$this->miUsuario->getErrores()));        
    }

    public function testCompruebaEmailExiste(): void
    {
        $this->assertTrue($this->resultado = $this->miUsuario->validaDatosEmail("user@correo.com"), implode(" - ",$this->miUsuario->getErrores()));
        
    }
    public function testCompruebaContrasenyasCoinciden(): void
    {
        $this->assertTrue($this->resultado = $this->miUsuario->validaDatosContrasenyas("123","123"), implode(" - ",$this->miUsuario->getErrores()));
    }

    public function testCompruebaToken(): void
    {
        $this->assertTrue($this->resultado = $this->miUsuario->validaToken("1_a"), implode(" - ",$this->miUsuario->getErrores()));
    }

    
    
    
}

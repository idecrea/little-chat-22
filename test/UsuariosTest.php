<?php

// Damos un espacio de trabajo aislado.
use PHPUnit\Framework\TestCase;

// Importamos nuestro código.
include_once('../valida/usuarios_valida.php');

// Creamos el test
class UsuariosTest extends TestCase
{
    private $miUsuario = null;
    private $connection = null;
    private $resultado = null;


    function setUp(): void
    {
        $this->connection = new PDO("sqlite:littlechat22-test.sqlite", "root", "");
        $this->miUsuario = new UsuariosValida($this->connection);
    }


    public function testNewUsuario(): void
    {
        $accionSQL = true;

        //Primero miramos si los datos de entrada son válidos.
        $this->assertTrue($this->resultado = $this->miUsuario->validaDatosRegistro("user","user@correo.com","123","123"), implode(" - ",$this->miUsuario->getErrores()));
        
        //Si lo son, creamos nuevo registro
        if($this->resultado && $accionSQL){
            
        }
        
    }


    
    
}

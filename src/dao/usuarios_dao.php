<?php 
//======================================================================
// Clase
//======================================================================
class UsuariosDAO
{
   //-----------------------------------------------------
   // ATRIBUTOS
   //-----------------------------------------------------
   private $error = [];
   private $connection = null;
 

    /**
     * Constructor que realiza la conexión con DB en caso de no pasarle una por parámetro.
     */
    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
   }

   //-----------------------------------------------------
   // METODOS
   //-----------------------------------------------------

   // Muestra los errores de la operación anteriormente realizada.
   public function getErrores(){
      return $this->error;
   }

    //======================================================================
    // FUNCIONES REGISTRO
    //======================================================================
    /**
     * Función para comprobar datos antes de realizar un registro.
     * Es conveniente usarla tanto en la lógica, como antes de realizar una inserción
     * en la base de datos.
     * 
     * @param {string} - Recibe username
     * @param {string} - Recibe email
     * @param {string} - Recibe contraseña
     */

    public function newUsuario(string $susername = '',string $semail = '',string $spassword = '')
    {
        //Limpiamos SIEMPRE los errores de la operación anterior.
        $this->error=[];

      
        $stmt = $this->connection->prepare('INSERT INTO Usuarios (username,email,contrasenya,token,activo) VALUES (:username,:email,:contrasenya,:token,:activa)');
        $stmt->execute(
           array(
              'username' => $susername,
              'email' =>  $semail,
              'contrasenya' => password_hash($spassword, PASSWORD_BCRYPT),
              'token' => bin2hex(openssl_random_pseudo_bytes(16)),
              'activa' => 0
         )
      );

    }

    public function findUsuarioByEmail(string $semail = '')
    {
        //Adquirimos el usuario
        $stmt = $this->connection->prepare('SELECT * FROM Usuarios WHERE email = :email');
        $stmt->execute(array('email' => $semail));

       return $stmt->fetch(); 
    }


    

      
      
      

}


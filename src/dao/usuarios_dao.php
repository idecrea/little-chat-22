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
   public $id = "";
   public $username = "";
   public $email = "";
   public $contrasenya = "";
   public $name = "";
   public $activo = 0;
   public $estado = "";
   public $token = "";
   public $created_at = "";

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

    public function create()
    {
        //Limpiamos SIEMPRE los errores de la operación anterior.
        $this->error=[];

      
        $stmt = $this->connection->prepare('INSERT INTO Usuarios (username,email,contrasenya,token,activo,created_at) VALUES (:username,:email,:contrasenya,:token,:activo,:created_at)');
        $stmt->execute(
           array(
              'username' => $this->username,
              'email' =>  $this->email,
              'contrasenya' => password_hash($this->contrasenya, PASSWORD_BCRYPT),
              'token' => $this->token,
              'activo' => $this->activo,
              'created_at' => $this->created_at
         )
      );

    }

    public function findUsuarioByEmail()
    {
        //Adquirimos el usuario
        $stmt = $this->connection->prepare('SELECT * FROM Usuarios WHERE email = :email');
        $stmt->execute(array('email' => $this->email));

       return $stmt->fetch(); 
    }


    

      
      
      

}


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
   public $avatar = "";
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
    // FUNCIONES DE CREACION
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
   
   //======================================================================
   // FUNCIONES DE ACTUALIZACIÓN
   //======================================================================
   public function updateActivo()
   {
      //Actualizamos el usuario // Ponemos token a NULL
      $stmt = $this->connection->prepare('UPDATE Usuarios SET token = NULL, activa = 1 WHERE id = :id AND token = :token');
      $stmt->execute(
         array(
            'id' => $this->id, 
            'token' => $this->token
         )
      );
   }
   public function updateCambiaContrasenya()
   {
      //Actualizamos el usuario // Ponemos token a NULL
      $stmt = $this->connection->prepare('UPDATE Usuarios SET token = NULL, contrasenya = :contrasenya WHERE id = :id AND token = :token');
      $stmt->execute(
         array(
            'id' => $this->id, 
            'token' => $this->token, 
            'contrasenya' => password_hash($this->contrasenya, PASSWORD_BCRYPT)
         )
      );
   }
   
   public function updateAvatar(){
      //Actualizamos el usuario
      $stmt = $this->connection->prepare('UPDATE Usuarios SET avatar = :avatar WHERE id = :id');
      $stmt->execute(array('id' => $this->id, 'avatar' => $this->avatar));
   }

   public function updateEstado(){
      //Actualizamos el usuario
      $stmt = $this->connection->prepare('UPDATE Usuarios SET estado = :estado WHERE id = :id');
      $stmt->execute(array('id' => $this->id, 'estado' => $this->estado));
   }

   public function updateToken(){
      //Actualizamos el usuario
      $stmt = $this->connection->prepare('UPDATE Usuarios SET token = :token WHERE id = :id');
      $stmt->execute(array('id' => $this->id, 'token' => $this->token));
   }

   //======================================================================
   // FUNCIONES DE LECTURA
   //======================================================================
   /**
    * Función principal de usuario auth
    */
   public function findUsuarioByEmail()
   {
      //Adquirimos el usuario
      $stmt = $this->connection->prepare('SELECT * FROM Usuarios WHERE email = :email');
      $stmt->execute(array('email' => $this->email));

       return $stmt->fetch(); 
    }
   /**
    * Función que devuelve un usuario a través de su ID.
    */
   public function findUsuarioById()
   {
      //Adquirimos el usuario
      $stmt = $this->connection->prepare('SELECT * FROM Usuarios WHERE id = :id');
      $stmt->execute(array('id' => $this->id));

       return $stmt->fetch(); 
    }
    /**
     * Función principal de activación
     */
    public function findUsuarioByIdToken()
    {
        //Adquirimos el usuario
        $stmt = $this->connection->prepare('SELECT * FROM Usuarios WHERE id = :id AND token = :token');
        $stmt->execute(array('id' => $this->id, 'token' => $this->token));

       return $stmt->fetch(); 
    }
    /**
     * Función principal del Login
     */
    public function findUsuarioByUserPassword()
    {
        //Adquirimos el usuario
        $stmt = $this->connection->prepare('SELECT * FROM Usuarios WHERE username = :username AND password = :password');
        $stmt->execute(array('username' => $this->username, 'password' => $this->password));

       return $stmt->fetch(); 
    }



    

      
      
      

}


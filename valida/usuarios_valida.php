<?php 
//======================================================================
// Clase
//======================================================================
class UsuariosValida
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
     * @param {string} - Recibe username y lo valida, así como comprueba si existe o no.
     * @param {string} - Recibe email y lo valida, así como comprueba si existe o no.
     * @param {string} -  Recibe ambas contraseñas y devuelve si coinciden o no.
     */
    public function validaDatosRegistro() : bool 
    {
      $Args = func_get_args();
      //Forzamos un string en el primer parámetro
      $username = (count($Args) > 0) ? (is_string($Args[0]) ? $Args[0] : '' ) : '';
      $email = (count($Args) > 1) ? (is_string($Args[1]) ? $Args[1] : '' ) : '';
      $password = (count($Args) > 2) ? (is_string($Args[2]) ? $Args[2] : '' ) : '';
      $password2 = (count($Args) > 3) ? (is_string($Args[3]) ? $Args[3] : '' ) : '';
      
      return $this->parsedRegistro($username,$email,$password,$password2);
    }
   /**
    * Función que recibe los datos parseados de validaDatosRegistro
    */
    protected function parsedRegistro(string $susername = '',string $semail = '',string $spassword = '',string $spassword2 = ''): bool
    {
       //Limpiamos SIEMPRE los errores de la operación anterior.
       $this->error=[];

       return 
       //Validamos el campo de texto.
       $this->validaUsername($susername) & 
       //Validamos el campo de email.
       $this->validaEmail($semail) &
       //Validamos contraseñas
       $this->validaContrasenya($spassword,$spassword2);
    }
    //======================================================================
    // FUNCIONES COMPROBAR CORREO - RECUPERACIÓN DE CONTRASEÑA
    //======================================================================
    /**
     * Recibe correo, lo parsea y comprueba si existe.
     */
    public function validaDatosCambiaContrasenya() : bool 
    {
      //Limpiamos SIEMPRE los errores de la operación anterior.
      $this->error=[];
      $Args = func_get_args();
      //Forzamos un string en el primer parámetro
      $email = (count($Args) > 0) ? (is_string($Args[0]) ? $Args[0] : '' ) : '';
      
      return $this->validaEmail($email);
    }
    //======================================================================
    // FUNCIONES CAMBIAR CONTRASEÑA
    //======================================================================
    public function validaDatosContrasenya() : bool 
    {
      //Limpiamos SIEMPRE los errores de la operación anterior.
      $this->error=[];
      $Args = func_get_args();
      //Forzamos un string en el primer parámetro
      $password = (count($Args) > 0) ? (is_string($Args[0]) ? $Args[0] : '' ) : '';
      $password2 = (count($Args) > 1) ? (is_string($Args[1]) ? $Args[1] : '' ) : '';
      
      return $this->validaContrasenya($password,$password2);
    }


    //======================================================================
    // POR SI QUEREMOS EJECUTAR VALIDACIONES POR SEPARADO
    // Aunque es conveniente pasar los parámetros primero por una función
    // de validación de las anteriores, para recibir datos parseados.
    //======================================================================
      public function validaUsername(string $username = '') : bool 
      {
       if (strlen($username) < 4) $this->error['username'] = "Demasiado Corto!";
       if (trim($username) == '') $this->error['username'] = "Inserte texto";
       if (strlen($username) > 25) $this->error['username'] = "Demasiado Largo!";
       if ( !isset( $this->error['username'] )) {
          if($this->existeUsername($username)) $this->error['username'] = "El usuario ya existe";
       }
       
       return ( !count($this->error) ? True : False ); 
      }
      public function validaEmail(string $email = '') : bool 
      {
         if (trim($email) == '') $this->error['email'] = "Inserte email";
         if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) $this->error['email'] = "Inserta un correo válido!";
         if ( !isset( $this->error['email'] )) {
            if($this->existeEmail($email)) $this->error['email'] = "El email ya existe";
         }
         return ( !count($this->error) ? True : False ); 
      }
      public function validaContrasenya(string $password, string $password2): bool 
      {
         if (trim($password) == '') $this->error['password'] = "Por favor introduce una contraseña";
         if (trim($password2) == '') $this->error['password2'] = "Por favor introduce una contraseña";
         
         //Si han introducido ambas, no se produce error, comprobamos que coinciden.
         if ( !isset( $this->error['password'] ) & !isset( $this->error['password2'] ) )
         if ( $password != $password2 ) $this->error['password2'] = "Las contraseñas no coinciden";
         
         return ( !count( $this->error ) ? True : False );
      }

      //======================================================================
      // FUNCIONES DE ACCESO DIRECTO A DATOS PARA VALIDACIONES
      // Les pasaremos SIEMPRE el objeto PDO, para no crear múltiples conexiones a DB.
      //======================================================================

      private function existeUsername(string $username = ''): bool {

         $existeUsername = $this->connection->prepare('SELECT * FROM Usuarios WHERE username = :username');
         $existeUsername->execute(array('username' => $username));
         var_dump($existeUsername->fetch());
         return ( $existeUsername->fetch() ? True : False );
      }
      private function existeEmail(string $email = ''): bool {

         $existeEmail = $this->connection->prepare('SELECT * FROM Usuarios WHERE email = :email');
         $existeEmail->execute(array('email' => $email));

         return ( count( $existeEmail->fetch() ) ? True : False );
      }
      
      
      

}


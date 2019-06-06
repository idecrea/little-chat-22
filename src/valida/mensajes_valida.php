<?php 
//======================================================================
// Clase
//======================================================================
class MensajesValida
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
    // FUNCIONES
    //======================================================================
    public function validaDatos() : bool 
    {
      $Args = func_get_args();
      //Forzamos un string en el primer parámetro
      $texto = (count($Args) > 0) ? (is_string($Args[0]) ? $Args[0] : '' ) : '';
      $email = (count($Args) > 1) ? (is_string($Args[1]) ? $Args[1] : '' ) : '';
      $id_mensaje = (count($Args) > 2) ? (is_string($Args[2]) ? $Args[2] : '' ) : '';
      
      return $this->validaParsed($texto,$email,$id_mensaje);
    }

    protected function validaParsed(string $stexto = '',string $semail = '',string $id_mensaje): bool
    {
       //Limpiamos SIEMPRE los errores de la operación anterior.
       $this->error=[];
       //Validamos el campo de texto.
       $this->validaTexto($stexto);
       $this->validaEmail($semail);
       
       if ( !isset( $this->error['email'] )) {
         if(!$this->existeEmail($semail)) $this->error['email'] = "El email no existe";
      }
      if(strlen($id_mensaje)>0){
         $this->validaIdMensaje($id_mensaje);
         if ( !isset( $this->error['id'] ))
         if(!$this->existeMensajePadre((int)$id_mensaje)) $this->error['id'] = "No se puede responder a este mensaje";
      }
      
      
      return (!count($this->error) ? True : False); 
   }
   
   public function validaDatosEdita() : bool 
   {
      //Limpiamos SIEMPRE los errores de la operación anterior.
      $this->error=[];
      
      $Args = func_get_args();

      //Forzamos un string en el primer parámetro
      $texto = (count($Args) > 0) ? (is_string($Args[0]) ? $Args[0] : '' ) : '';
      $email = (count($Args) > 1) ? (is_string($Args[1]) ? $Args[1] : '' ) : '';
      $id = (count($Args) > 2) ? (is_string($Args[2]) ? $Args[2] : '' ) : '';

      $this->validaTexto($texto);
      $this->validaId($id);
      $this->validaEmail($email);

      if ( !isset( $this->error['id'] ))
      if(!$this->existeMensaje((int)$id)) $this->error['id'] = "No existe ese Mensaje";
      if ( !isset( $this->error['id'] ) && !isset( $this->error['email']) )
      if(!$this->esAutor((int)$id,$email)) $this->error['owner'] = "No es autor del mensaje";

      
      return (!count($this->error) ? True : False); 
    }
   public function validaDatosLike() : bool 
   {
      //Limpiamos SIEMPRE los errores de la operación anterior.
      $this->error=[];
      
      $Args = func_get_args();

      //Forzamos un string en el primer parámetro
      $email = (count($Args) > 0) ? (is_string($Args[0]) ? $Args[0] : '' ) : '';
      $id = (count($Args) > 1) ? (is_string($Args[1]) ? $Args[1] : '' ) : '';

      $this->validaId($id);
      $this->validaEmail($email);

      if ( !isset( $this->error['id'] ))
      if(!$this->existeMensaje((int)$id)) $this->error['id'] = "No existe ese Mensaje";
      if ( !isset( $this->error['id'] ) && !isset( $this->error['email']) )
      if($this->esAutor((int)$id,$email)) $this->error['owner'] = "No puedes dar like a tus mensajes";

      
      return (!count($this->error) ? True : False); 
    }



    protected function validaTexto(string $stexto = '') : bool {
      if(strlen($stexto) < 4) $this->error['texto'] = "Demasiado Corto!";
      if((trim($stexto) == '')) $this->error['texto'] = "Inserte texto";
      if(strlen($stexto) > 22) $this->error['texto'] = "Demasiado Largo!";
      return (!count($this->error) ? True : False); 
    }
    public function validaId(string $sid = '') : bool {
      //Solo comprobamos si el campo tenía valor
      if((trim($sid) == '')) $this->error['id'] = "Inserte ID";
      if((int)$sid <= 0) $this->error['id'] = "Inserta una ID válida";
      
      return (!count($this->error) ? True : False); 
    }
    protected function validaIdMensaje(string $sid = '') : bool {
      //Solo comprobamos si el campo tenía valor
      if(strlen(trim($sid)) > 0){
         if((int)$sid <= 0) $this->error['id'] = "Inserta una ID válida";
      }
      return (!count($this->error) ? True : False); 
    }
    protected function validaEmail(string $email = '') : bool 
    {
       if (trim($email) == '') $this->error['email'] = "Inserte email";
       if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) $this->error['email'] = "Inserta un correo válido!";

       return ( !count($this->error) ? True : False ); 
    }
      //======================================================================
      // FUNCIONES DE ACCESO DIRECTO A DATOS PARA VALIDACIONES
      // Les pasaremos SIEMPRE el objeto PDO, para no crear múltiples conexiones a DB.
      //======================================================================

      private function existeUsername(string $username = ''): bool {

         $existeUsername = $this->connection->prepare('SELECT * FROM Usuarios WHERE username = :username');
         $existeUsername->execute(array('username' => $username));
         
         return ( $existeUsername->fetch() ? True : False );
      }
      private function existeEmail(string $email = ''): bool {

         $existeEmail = $this->connection->prepare('SELECT * FROM Usuarios WHERE email = :email');
         $existeEmail->execute(array('email' => $email));

         return ( $existeEmail->fetch() ? True : False );
      }
      private function existeMensaje(string $id = ''): bool { 
            $existeMsg = $this->connection->prepare('SELECT * FROM Mensajes WHERE id = :id');
            $existeMsg->execute(array('id' => $id));

            return ( $existeMsg->fetch() ? True : False );
      }
      private function existeMensajePadre(string $id_mensaje = ''): bool { 
            $existeMsg = $this->connection->prepare('SELECT * FROM Mensajes WHERE id = :id AND id_mensaje IS NULL' );
            $existeMsg->execute(array('id' => $id_mensaje));

            return ( $existeMsg->fetch() ? True : False );
      }
      private function esAutor(string $id = '', string $email = ''): bool { 
            $existeMsg = $this->connection->prepare('SELECT * FROM Mensajes WHERE id = :id AND id_usuario = (SELECT id FROM Usuarios WHERE email = :email)' );
            $existeMsg->execute(array('id' => $id, 'email' => $email));

            return ( $existeMsg->fetch() ? True : False );
      }
    

}


<?php 
//======================================================================
// Clase
//======================================================================
class MensajesDAO
{
   //-----------------------------------------------------
   // ATRIBUTOS
   //-----------------------------------------------------
   private $error = [];
   private $connection = null;
   public $id = "";
   public $texto = "";
   public $likes = 0;
   public $id_usuario = "";
   public $id_mensaje = "";
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
       
       
       $stmt = $this->connection->prepare('INSERT INTO Mensajes (texto,likes,created_at,id_usuario,id_mensaje) VALUES (:texto,:likes,:created_at,'.($this->id_usuario == "" || $this->id_usuario == 'null' ? 'NULL' : ':id_usuario').','.($this->id_mensaje == "" || $this->id_mensaje == 'null' ? 'NULL' : ':id_mensaje').')');
       

       $param['texto'] = $this->texto;
       $param['likes'] = $this->likes;
       $param['created_at'] = $this->created_at;
       if($this->id_usuario !="" && strtolower( $this->id_usuario ) != 'null') 
            $param['id_usuario'] = $this->id_usuario;
       if($this->id_mensaje !="" && strtolower( $this->id_mensaje ) != 'null') 
           $param['id_mensaje'] = $this->id_mensaje;

       $stmt->execute($param);
       
      }
      
      public function editMensaje(){
         $stmt = $this->connection->prepare('UPDATE Mensajes SET texto = :texto WHERE id = :id');
         $param['texto'] = $this->texto;
         $param['id'] = $this->id;
         
         $stmt->execute($param);
   }
      public function likeMensaje(){
         $stmt = $this->connection->prepare('UPDATE Mensajes SET likes = likes + 1 WHERE id = :id');
         $param['id'] = $this->id;
         
         $stmt->execute($param);
   }

   public function delete()
   {
      $respuestas = $this->connection->prepare('SELECT * FROM Mensajes WHERE id_mensaje = :id_mensaje');
      $respuestas->execute(array('id_mensaje'=>$this->id));
      $data = $respuestas->fetchAll(PDO::FETCH_ASSOC);
      
      if($data)
      foreach($data as $respuesta){
         $smt = $this->connection->prepare('DELETE FROM Mensajes WHERE id = :id');
         $smt->execute(array('id'=>$respuesta['id']));
      }

      $smt = $this->connection->prepare('DELETE FROM Mensajes WHERE id = :id');
      $smt->execute(array('id'=>$this->id));
   }
   
   

    

      
      
      

}


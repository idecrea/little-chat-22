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
      
      return $this->validaParsed($texto);
    }

    protected function validaParsed(string $stexto = ''): bool
    {
       //Limpiamos SIEMPRE los errores de la operación anterior.
       $this->error=[];
       //Validamos el campo de texto.
       validaTexto($stexto);

         
       return (!count($this->error) ? True : False); 
    }

    protected function validaTexto(string $stexto = '') : bool {
      if(strlen($stexto) < 10) $this->error['texto'] = "Demasiado Corto!";
      if((trim($stexto) == '')) $this->error['texto'] = "Inserte texto";
      if(strlen($stexto) > 140) $this->error['texto'] = "Demasiado Largo!";
      return (!count($this->error) ? True : False); 
    }

    

}


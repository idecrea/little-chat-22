<?php
require_once('head.php');
require_once('menu.php');
?>
<section class="h-screen bg-teal-400 m-0 overflow-scroll fuente-medium">
    <div class="flex justify-center mt-16">
        <i class="fas fa-user-circle text-teal-800 fa-6x mb-4"></i>
    </div>
    <div class="flex justify-center mt-6">
        <label for="subir-img" class="fuente-bold flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-200 hover:text-teal-800 hover:opacity-100 text-center z-10 mb-10">
            Cambia tu imagen
            <input class="hidden" id="subir-img" type="file" value="Cambia tu imagen" name="subir-img">
        </label>
    </div>
    <div class="flex justify-center mt-5">
        <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Usuario ya mostrado" name="user">
    </div>
    <div class="flex justify-center mt-5">
        <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="E-mail ya mostrado" name="email">
    </div>
    <div class="flex justify-center mt-5">
        <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Nueva contrasenya" name="password">
    </div>
    <div class="flex justify-center mt-5">
        <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Repita la contraseña" name="repeat-password">
    </div>
    <div class="flex justify-center mt-12">
        <input class="fuente-bold flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-200 hover:text-teal-800 hover:opacity-100" type="submit" value="Guardar Cambios">
    </div>
    <div class="flex justify-center mt-6">
        <a class="fuente-bold flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-200 hover:text-teal-800 hover:opacity-100" href="usuario.php">Cancelar</a>
    </div>
</section>
</div>
</body>

</html>
<?php
require_once('head.php');
require_once('menu.php');
?>
<section class="h-screen bg-teal-400 m-0 overflow-scroll fuente-medium">
    <div class="flex justify-center mt-16">
        <i class="fas fa-user-circle text-teal-800 fa-6x mb-4"></i>
    </div>
    <div class="flex justify-center mt-4">
        <p class="fuente-bold text-teal-800 text-center mx-12 leading-normal ">Nombre del usuario</p>
    </div>
    <div class="flex justify-center mt-4">
        <p class="fuente-bold text-teal-800 text-center mx-12 leading-normal">Correo del usuario</p>
    </div>
    <div class="flex justify-center mt-12">
        <a class="fuente-bold flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-200 hover:text-teal-800 hover:opacity-100" href="modificar-usuario.php">Modificar datos</a>
    </div>
    <div class="flex justify-center mt-8">
        <a class="fuente-bold flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-200 hover:text-teal-800 hover:opacity-100" href="login.php">Cerrar sesión</a>
    </div>
    <div class="flex justify-center mt-12">
        <a class="fuente-bold flex text-teal-400 justify-center items-center h-12 w-56 bg-teal-200 hover:bg-teal-200 hover:text-teal-800 hover:opacity-100" href="borrar-usuario.php">Borrar cuenta</a>
    </div>
</section>
</div>
</body>

</html>
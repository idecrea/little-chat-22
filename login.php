<?php
    require_once('head.php');
?>
    <div id="app" class="fuente-bold">
        <nav class="bg-teal-800 h-16">
            Menu
        </nav>
        <section class="h-screen bg-teal-400 m-0">
            <h1 class="text-center text-teal-800 m-0 pt-16">Login</h1>
            <div class="flex justify-center mt-10">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Nombre de usuario">
            </div>
            <div class="flex justify-center mt-5">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Contraseña">
            </div>
            <div class="flex justify-center mt-10">
                <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Iniciar sesión">
            </div>
            <div class="flex justify-center mt-5">
                <a class="text-teal-800 fuente" href="">Recuperar Contraseña</a>
            </div>
            <div class="flex justify-center mt-16">
                <a class=" flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-100 hover:text-teal-800 hover:opacity-100" href="registro.php">Registrarse</a>
            </div>
        </section>
    </div>
</body>
</html>
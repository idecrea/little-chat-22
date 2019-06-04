<?php
    require_once('head.php');
?>
    <div id="app" class="fuente-bold">
        <nav class="bg-teal-800 h-16">
            Menu
        </nav>
        <section class="h-screen bg-teal-400 m-0">
            <h1 class="text-center text-teal-800 m-0 pt-16">Registro</h1>
            <div class="flex justify-center mt-10">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Nombre de usuario">
            </div>

                <!-- Error - El username ya está escogido -->
                <div class="flex justify-center mt-8">
                    <p class="fuente-bold text-red-700">El nombre de usuario ya existe</p>
                </div>

            <div class="flex justify-center mt-5">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Email">
            </div>

                <!-- Error - El email debe ser valido -->
                <div class="flex justify-center mt-8">
                    <p class="fuente-bold text-red-700">El email debe ser válido</p>
                </div>

            <div class="flex justify-center mt-5">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Contraseña">
            </div>
            <div class="flex justify-center mt-5">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Confirmar Contraseña">
            </div>
                <!-- Error - Las contrasenyas deben ser idénticas -->
                <div class="flex justify-center mt-8">
                    <p class="fuente-bold text-red-700">Las contraseñas deben ser idénticas</p>
                </div>

                <!-- Error Todos los campos son obligatorios -->
                <div class="flex justify-center mt-8">
                    <p class="fuente-bold text-red-700">Todos los campos son obligatorios</p>
                </div>

            <div class="flex justify-center mt-10">
                <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Regístrate">
            </div>
        </section>
    </div>
</body>
</html>
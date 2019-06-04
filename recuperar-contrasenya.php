<?php
    require_once('head.php');
    require_once('menu.php');
?>
        <section class="h-screen bg-teal-400 m-0">
            <h1 class="text-center text-teal-800 m-0 pt-16 leading-snug">Recuperar <br>Contraseña</h1>
            <div class="flex justify-center mt-10">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Introduce tu Email">
            </div>

                <!-- Error - No existe un usuario con este email -->
                <div class="flex justify-center mt-4">
                    <p class="fuente-bold text-red-700 text-center">No existe ningun usuario registrado con este email</p>
                </div>

                <!-- Error Todos los campos son obligatorios -->
                <div class="flex justify-center mt-5">
                    <p class="fuente-bold text-red-700">Todos los campos son obligatorios</p>
                </div>

            <div class="flex justify-center mt-16">
                <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Enviar">
            </div>
        </section>
    </div>
</body>
</html>
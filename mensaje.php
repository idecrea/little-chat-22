<?php
    require_once('head.php');
    require_once('menu.php');
?>

        <section class="h-screen bg-teal-100 m-0 flex items-center flex-col fuente-medium">
            <div class="w-11/12 mt-16 px-2 text-teal-800 flex justify-center fuente-bold">
                <h1 class="text-lg text-center">22</h1>
               <h1 class="text-lg text-center ml-1">Caracteres restantes</h1>
               <h1 class="text-lg text-center ml-1 text-red-600 hidden">¡Ya no puedes escribir más!</h1>
            </div>
            <form class="flex flex-col justify-center items-center px-2 mt-2">
                <textarea class="bg-teal-200 border border-teal-400 p-2
                 text-teal-800 focus:border-teal-800 placeholder1" name="mensaje" id="" cols="30" rows="12" placeholder="Escribe tu mensaje..."></textarea>
                <input class="mt-10 fuente-bold border border-teal-800 mt-4 bg-teal-800 text-teal-100 py-3 w-4/5 justify-center" type="submit" value="Enviar Mensaje">
            </form>
        </section>
    </div>
</body>
</html>
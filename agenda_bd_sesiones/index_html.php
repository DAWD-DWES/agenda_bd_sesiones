<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylesheet.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <title>Agenda</title>
    </head>
    <body>
        <form class="agenda" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>     
            <h1>Agenda</h1>
            <fieldset>
                <legend>Datos Agenda:</legend>
                <!-- Muestro las entradas de la agenda -->
            </fieldset>
            <!-- Creamos el formulario de introducción de un nuevo contacto -->
            <fieldset>
                <legend>Nuevo Contacto:</legend>
                <div class="form-section">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre">                      
                </div>
                <div class="form-section">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono">
                </div>                       
                <div class="form-section">
                    <input class="submit blue" type="submit" value="Añadir Contacto" name="crear_contacto">
                    <input class="submit green" type="reset" value="Limpiar Campos"/>
                </div>
            </fieldset>
            <!-- Si la agenda no está vacía -->
                <fieldset>
                    <legend>Vaciar Agenda</legend>
                <!--   <a class="submit red button" href="<?= "{$_SERVER['PHP_SELF']}?limpiar=1" ?>">Vaciar</a> -->
                    <input type="submit" class="submit red" name="limpiar"  value="Vaciar">
                </fieldset>
        </form>
    </body>
</html>

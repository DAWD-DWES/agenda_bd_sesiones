<?php
define('NOMBRE_INVALIDO', '**Nombre inválido');
define('TELEFONO_INVALIDO', '**Teléfono inválido');

require_once 'funciones_bd.php';
$bd = require_once 'conexion.php';

if (filter_has_var(INPUT_POST, 'crear_contacto')) {
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS));
    $nombreErr = filter_var($nombre, FILTER_VALIDATE_REGEXP,
                    ['options' => ['regexp' => "/^[a-z A-Záéíóúñ]{3,25}$/"]]) === false;
    $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS));
    $telefonoErr = filter_var($telefono, FILTER_VALIDATE_REGEXP,
                    ['options' => ['regexp' => "/^\+?[0-9]{9,15}$/"]]) === false;
    $error = $nombreErr || $telefonoErr;
    if (!$error) {
        try {
            $contactoInsertado = insertarContacto($bd, ucwords(strtolower($nombre)), $telefono);
        } catch (PDOException $ex) {
            error_log("Error al crear el contacto " . $ex->getMessage());
            $contactoInsertado = false;
        }
    }
} else if (filter_has_var(INPUT_GET, 'borrar_contacto')) {
    $id = filter_input(INPUT_GET, 'borrar_contacto');
    try {
        $contactoBorrado = borrarContacto($bd, $id);
    } catch (PDOException $ex) {
        error_log("Error al borrar el contacto" . $ex->getMessage());
        $contactoBorrado = false;
    }
} else if (filter_has_var(INPUT_POST, 'limpiar')) {
    try {
        $contactosBorrados = borrarContactos($bd);
    } catch (PDOException $ex) {
        error_log("Error al borrar el contacto" . $ex->getMessage());
        $contactosBorrados = false;
    }
}

try {
    $agenda = consultarContactos($bd);
} catch (PDOException $ex) {
    error_log("Error al recuperar los contactos " . $ex->getMessage());
    $agenda = [];
}

$bd = null;
?>
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
                <?php if (!($contactoInsertado ?? true)): ?>
                    <p class ="error error-visible">El contacto no ha podido ser insertado</p>
                <?php endif ?>
                <?php if (!($contactoBorrado ?? true)): ?>
                    <p class ="error error-visible">El contacto no ha podido ser borrado</p>
                <?php endif ?>
                <?php if (!($contactosBorrados ?? true)): ?>
                    <p class ="error error-visible">La agenda no se ha podido vaciar</p>
                <?php endif ?>
                <legend>Datos Agenda:</legend>
                <?php if (empty($agenda)): ?>
                    <p>La agenda está vacía</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agenda as $contacto): ?> <!-- Bucle de creación de las filas de la tabla -->
                                <tr>
                                    <td><?= $contacto->nombre ?></td>
                                    <td><?= $contacto->telefono ?></td>
                                    <td><a href="<?= "{$_SERVER['PHP_SELF']}?borrar_contacto={$contacto->id}" ?>"><i class="bi-trash"></i></a></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif ?>
            </fieldset>
            <!-- Creamos el formulario de introducción de un nuevo contacto -->
            <fieldset>
                <legend>Nuevo Contacto:</legend>
                <div class="form-section">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= ($error ?? false) ? $nombre : '' ?>">
                    <span class="error <?= ($nombreErr ?? false) ? 'error-visible' : '' ?>">
                        <?= NOMBRE_INVALIDO ?>
                    </span>                       
                </div>
                <div class="form-section">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?= ($error ?? false) ? $telefono : '' ?>">
                    <span class="error <?= ($telefonoErr ?? false) ? 'error-visible' : '' ?>">
                        <?= TELEFONO_INVALIDO ?>
                    </span>
                </div>                       
                <div class="form-section">
                    <input class="submit blue" type="submit" value="Añadir Contacto" name="crear_contacto">
                    <input class="submit green" type="reset" value="Limpiar Campos"/>
                </div>
            </fieldset>
            <!-- Si la agenda no está vacía -->
            <?php if (!empty($agenda)): ?>
                <fieldset>
                    <legend>Vaciar Agenda</legend>
                <!--   <a class="submit red button" href="<?= "{$_SERVER['PHP_SELF']}?limpiar=1" ?>">Vaciar</a> -->
                    <input type="submit" class="submit red" name="limpiar"  value="Vaciar">
                </fieldset>
            <?php endif ?>
        </form>
    </body>
</html>

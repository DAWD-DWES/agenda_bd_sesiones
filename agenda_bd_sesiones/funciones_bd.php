<?php
/**
 * borrarContacto borra un contacto correspondiente a un Id de la BD
 * 
 * @param PDO $bd
 * @param string $contactoId
 * @return bool
 */

function borrarContacto(PDO $bd, string $contactoId): bool {
    $sqlBorrarContacto = "delete from contactos where id=:id";
    $stmtBorrarContacto = $bd->prepare($sqlBorrarContacto);
    $resultado = $stmtBorrarContacto->execute([':id' => $contactoId]);
    $stmtBorrarContacto = null;
    return ($resultado);
}

/**
 * borrarContactos borra todos los contactos de la BD
 * 
 * @param PDO $bd
 * @return bool
 */

function borrarContactos(PDO $bd): bool {
    $sqlBorrarContactos = "delete from contactos;";
    $stmtBorrarContactos = $bd->prepare($sqlBorrarContactos);
    $resultado = $stmtBorrarContactos->execute();
    $stmtBorrarContactos = null;
    return ($resultado);
}

/**
 * consultaContactos Obtiene los contactos de la BD
 * 
 * @param PDO $bd
 * @return array
 */

function consultarContactos(PDO $bd): array {
    $sqlConsultarContactos = "select * from contactos order by nombre";
    $stmtConsultarContactos= $bd->prepare($sqlConsultarContactos);
    $stmtConsultarContactos->execute();
    $resultado = $stmtConsultarContactos->fetchAll(PDO::FETCH_OBJ);
    $stmtConsultarContactos = null;
    return $resultado;
}


/**
 * insertarContacto inserta un contacto en la BD
 * 
 * @param PDO $bd
 * @param string $nombre
 * @param string $telefono
 * @return bool
 */

function insertarContacto(PDO $bd, string $nombre, string $telefono): bool {
    $sqlInsertarContacto = "insert into contactos (nombre, telefono) values(:nombre, :telefono)";
    $stmtInsertarProducto = $bd->prepare($sqlInsertarContacto);
    $resultado = $stmtInsertarProducto->execute([
        ':nombre' => $nombre,
        ':telefono' => $telefono
    ]);
    $stmtInsertarProducto = null;
    return $resultado;
}

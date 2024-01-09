<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Procesar otros campos del formulario

  // Obtener la información de los archivos
  $archivos = $_FILES['archivos'];

  // Procesar y guardar los archivos en el servidor

  // Guardar las rutas de los archivos en la base de datos
  $rutaArchivos = "/ruta/del/servidor/a/tu/carpeta/archivos/"; // ajusta la ruta según tu configuración

  $rutasGuardadasEnBD = array();

  for ($i = 0; $i < count($archivos['name']); $i++) {
      $nombreArchivo = $archivos['name'][$i];
      $rutaGuardadaEnBD = $rutaArchivos . $nombreArchivo;
      $rutasGuardadasEnBD[] = $rutaGuardadaEnBD;
  }

  // Ahora $rutasGuardadasEnBD contiene las rutas de los archivos que puedes almacenar en tu base de datos

  // ... continuar con el resto del código ...

  // ... después de obtener las rutas $rutasGuardadasEnBD ...

// Convierte el array de rutas en una cadena para almacenar en la base de datos
$rutasString = implode(',', $rutasGuardadasEnBD);

// Consulta SQL para actualizar la columna archivos_ruta en la tabla cliente
$sqlUpdate = "UPDATE ticket.cliente SET archivos_ruta = '$rutasString' WHERE id_cliente = 123;"; // ajusta el id_cliente según tu caso

// Ejecutar la consulta SQL
$resultado = mysqli_query($conexion, $sqlUpdate);

// Verificar si la actualización fue exitosa
if ($resultado) {
    echo "Datos de archivos almacenados exitosamente en la base de datos.";
} else {
    echo "Error al almacenar datos de archivos en la base de datos: " . mysqli_error($conexion);
}

}

?>
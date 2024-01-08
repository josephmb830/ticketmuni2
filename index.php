<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');  

include './class_mysql.php';
include './config.php';

if(isset($_POST['dni_contacto']) && isset($_POST['asunto']) && isset($_POST['descripcion'])){
  $dni_contacto=MysqlQuery::RequestPost('dni_contacto');
  $nombres_contacto=MysqlQuery::RequestPost('nombres_contacto');
  $a_paterno_contacto=md5(MysqlQuery::RequestPost('a_paterno_contacto'));
  $a_materno_contacto=MysqlQuery::RequestPost('a_materno_contacto');
  $cargo_contacto=MysqlQuery::RequestPost('cargo_contacto');
  $correo_contacto=MysqlQuery::RequestPost('correo_contacto');
  $asunto=MysqlQuery::RequestPost('asunto');
  $descripcion=MysqlQuery::RequestPost('descripcion');
  //$archivos=MysqlQuery::RequestPost('archivos');

  
  if(MysqlQuery::Guardar("ticket2", "dni_contacto, nombres_contacto, a_paterno_contacto, a_materno_contacto, cargo_contacto, correo_contacto, asunto, descripcion", "'$dni_contacto', '$nombres_contacto', '$a_paterno_contacto', '$a_materno_contacto','$cargo_contacto', '$correo_contacto', '$asunto', '$descripcion'")){

      /*----------  Enviar correo con los datos de la cuenta ----*/
          
      

      echo '
          <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10000;"> 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="text-center">REGISTRO EXITOSO</h4>
              <p class="text-center">
                  Cuenta creada exitosamente, ahora puedes iniciar sesión, ya eres usuario.
              </p>
          </div>
      ';
  }else{
      echo '
          <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10000;"> 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="text-center">OCURRIÓ UN ERROR</h4>
              <p class="text-center">
                  ERROR AL REGISTRARSE: Por favor intente nuevamente.
              </p>
          </div>
      '; 
  }
}



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
<!DOCTYPE html>
<html>

<head>
  <title>Sistema de Ticket MDMM</title>
  <link rel="shortcut icon" href="img/logomuni.png">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <?php 
  include "./links.php"; 
  ?>

</head> 

<body>


<?php ?>

      <div class="col-md-12 border-login p-2 sombra w-50 mx-auto  ">
          <form action="" method="POST" style="margin: 20px;" enctype="multipart/form-data">
          <div class="row">
            <div class="d-flex justify-content-center align-items-center col-md-12">
            <img class="  " src="./img/boleto.png" width="150" alt="">
            </div>
          </div>



          
          <div class="col-md-12">
            <label><span class=""></span>INFORMACIÓN DEL CONTACTO</label>
            <div class="custom-flex-container">
              <div class="form-group col-md-3">
                <label><span class=""></span>DNI</label>
                <input type="text" class="form-control" name="dni_contacto" placeholder="Escribe tu DNI" required="" />
              </div>
              <div class="form-group col-md-3">
                <label><span class=""></span>Nombres</label>
                <input type="text" class="form-control" name="nombres_contacto" placeholder="Escribe tu nombre" required="" />
              </div>
              <div class="form-group col-md-3">
                <label><span class=""></span>Apellido Paterno</label>
                <input type="text" class="form-control" name="a_paterno_contacto" placeholder="Escribe tu Apellido Paterno" required="" />
              </div>
              <div class="form-group col-md-3">
                <label><span class=""></span>Apellido Materno</label>
                <input type="text" class="form-control" name="a_materno_contacto" placeholder="Escribe tu Apellido Materno" required="" />
              </div>
            </div>
            <div class="custom-flex-container">
              <div class="form-group col-md-5">
                <label><span class=""></span>Cargo</label>
                <input type="text" class="form-control" name="cargo_contacto" placeholder="Escribe el cargo" required="" />
              </div>
              <div class="form-group col-md-4">
                <label><span class=""></span>Correo Electrónico</label>
                <input type="email" class="form-control" name="correo_contacto" placeholder="Escribe tu correo electrónico" required="" />
              </div>
              <div class="form-group col-md-3">
                <!-- Puedes dejar este espacio en blanco o agregar elementos adicionales aquí -->
              </div>
            </div>
          </div>
            <div class="col-md-12">
                <label><span class=""></span>INFORMACIÓN DEL TICKET</label>

                <div class="form-group col-md-12">
                    <label><span class=""></span>Asunto</label>
                    <input type="text" class="form-control col-md-12" name="asunto" placeholder="Escribe el asunto" required=""/>
                </div>

                <div class="form-group col-md-12">
                    <label><span class=""></span>Descripción del Problema</label>
                    <textarea class="form-control col-md-12" name="descripcion" rows="4" placeholder="Escribe la descripción del problema" required=""></textarea>
                </div>

                <!-- Texto "Adjuntar archivo (Opcional)" en cursiva -->
                <div class="form-group col-md-12">
                    <label class="font-italic">Adjuntar archivos (Opcional)</label>
                </div>

                <!-- Cuadro de información -->  
                <div class="form-group col-md-12">
                    <div class="alert alert-info">
                        <strong>ℹ Información:</strong> Puede subir hasta 3 archivos (4MB cada uno).<br>
                        Formatos permitidos: .pdf, .jpeg, .jpg, .png
                    </div>
                </div>

                <!-- Botón para seleccionar archivos con evento onchange para validación -->
                <div class="form-group col-md-12">
                    <label><span class=""></span>Seleccionar Archivos</label>
                    <input type="file" class="form-control-file" name="archivos" accept=".pdf, .jpeg, .jpg, .png" multiple onchange="validarArchivos(this)" />
                </div>
            </div>
            <div class="row custom-flex-container">
              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
                <!-- <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button> -->
              </div>
            </div>


          </form>

      </div>

      <?php  ?>

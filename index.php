<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(file_exists("archivo.txt")){
    $jsonClientes = file_get_contents("archivo.txt");
    $aClientes = json_decode($jsonClientes, true);
} else {
    $aClientes = array();
}


if($_POST){
    $documento = trim($_POST["txtDocumento"]);
    $nombre = trim($_POST["txtNombre"]);
    $telefono = trim($_POST["txtTelefono"]);
    $correo = trim($_POST["txtCorreo"]);

    $aClientes[] = array("documento" => $documento, 
                         "nombre" => $nombre,
                         "telefono" => $telefono,
                         "correo" => $correo);


    //Convierte el array de clientes a jsonClientes
    $jsonClientes = json_encode($aClientes);

    //Almacena el string jsonClientes en el archivo "archivo.txt"
    file_put_contents("archivo.txt", $jsonClientes);

}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-12 text-center py-5">
                <h1>Registro de clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pb-2">
                        <label for="">Documento: *</label>
                        <input type="text" name="txtDocumento" id="txtDocumento" class="form-control" placeholder="Documento" required value="">
                    </div>
                    <div class="pb-2">
                        <label for="">Nombre: *</label>
                        <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" required value="">
                    </div>
                    <div class="pb-2">
                        <label for="">Telefono: *</label>
                        <input type="text" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Telefono" required value="">
                    </div>
                    <div class="pb-2">
                        <label for="">Correo: *</label>
                        <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="Correo" required value="">
                    </div>
                    <div class="pb-2">
                        <label for="">Archivo adjunto</label>
                        <input type="file" name="archivo" id="archivo" accept=".jpg, .jpeg, .png,">
                        <small class="d-block">Archivos admitidos: .jpg, .jpeg, .png</small>
                    </div>
                    <div class="pb-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="index.php" class="btn btn-danger my-2">Nuevo</a>
                    </div>
                </form>
            </div>
            <div class="col-6 py-4">
                <table class="table table-hover shadow border">
                    <tr>
                        <th>Imagen</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($aClientes as $cliente): ?>
                    <tr>
                        <td></td>
                        <td><?php echo $cliente["documento"]; ?></td>
                        <td><?php echo $cliente["nombre"]; ?></td>
                        <td><?php echo $cliente["correo"]; ?></td>
                        <td><i class="fa-solid fa-pencil"></i>
                        <i class="fa-solid fa-trash-can"></i>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
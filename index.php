<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Si existe el archivo.txt
if (file_exists("archivo.txt")) {

    $strJson = file_get_contents("archivo.txt");

    $aClientes = json_decode($strJson, true);
} else {

    $aClientes = array();
}

function e($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

$pos = isset($_GET["pos"]) && $_GET["pos"] >= 0 ? $_GET["pos"] : "";

if ($_POST) {
    $documento = trim($_POST["txtDocumento"]);
    $nombre = trim($_POST["txtNombre"]);
    $telefono = trim($_POST["txtTelefono"]);
    $correo = trim($_POST["txtCorreo"]);
    $nombreImagen = "";

    if ($pos >= 0) {
        if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
            $nombreAleatorio = date("Ymdhmsi");
            $archivo_tmp = $_FILES["archivo"]["tmp_name"];
            $extension = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));
            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                $nombreImagen = "$nombreAleatorio.$extension";
                move_uploaded_file($archivo_tmp, "imagenes/$nombreImagen");
            }
            //Elimina la imagen anterior
            if ($aClientes[$pos]["imagen"] != "" && file_exists("imagenes/".$aClientes[$pos]["imagen"])) {
                unlink("imagenes/".$aClientes[$pos]["imagen"]);
            }
        } else {
            //Mantiene el nombreImagen que teniamos antes
            $nombreImagen = $aClientes[$pos]["imagen"];
        }

        //Actualizar
        $aClientes[$pos] = array(
            "documento" => $documento,
            "nombre" => $nombre,
            "telefono" => $telefono,
            "correo" => $correo,
            "imagen" => $nombreImagen
        );
    } else {
        if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
            $nombreAleatorio = date("Ymdhmsi");
            $archivo_tmp = $_FILES["archivo"]["tmp_name"];
            $extension = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));
            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                $nombreImagen = "$nombreAleatorio.$extension";
                move_uploaded_file($archivo_tmp, "imagenes/$nombreImagen");
            }
        }
        //Insertar
        $aClientes[] = array(
            "documento" => $documento,
            "nombre" => $nombre,
            "telefono" => $telefono,
            "correo" => $correo,
            "imagen" => $nombreImagen
        );
    }

    //Convierte el array de clientes a jsonClientes
    $jsonClientes = json_encode($aClientes);

    //Almacena el string  jsonClientes en el archivo.txt
    file_put_contents("archivo.txt", $jsonClientes);
    header("location: index.php?ok=1");
    exit;
}


if (isset($_GET["do"]) && $_GET["do"] == "eliminar") {
    //Elimina del array  aClientes la posicion a borrar unset()
    unset($aClientes[$pos]);

    //Convierte el array de clientes a jsonClientes
    $jsonClientes = json_encode($aClientes);

    //Almacena el string jsonClientes en el archivo.txt
    file_put_contents("archivo.txt", $jsonClientes);
    header("location: index.php?ok=2");
    exit;
}

$editando = $pos !== "" && isset($aClientes[$pos]);
$clienteActual = $editando ? $aClientes[$pos] : array("documento" => "", "nombre" => "", "telefono" => "", "correo" => "", "imagen" => "");
$mensaje = "";
if (isset($_GET["ok"])) {
    $mensaje = $_GET["ok"] == "2" ? "Cliente eliminado correctamente." : "Cliente guardado correctamente.";
}

function iniciales($nombre)
{
    $partes = preg_split("/\s+/", trim($nombre));
    $ini = "";
    foreach (array_slice($partes, 0, 2) as $p) {
        $ini .= mb_strtoupper(mb_substr($p, 0, 1));
    }
    return $ini;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | ABM Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <header class="topbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="index.php" class="brand">
                <span class="brand-mark"><i class="fa-solid fa-users"></i></span>
                ABM Clientes
            </a>
            <span class="topbar-sub d-none d-sm-inline">Gestión de cartera de clientes</span>
        </div>
    </header>

    <main class="container py-4 py-lg-5">
        <div class="page-head">
            <div>
                <h1>Clientes</h1>
                <p>Registra, actualiza y organiza la información de tus clientes.</p>
            </div>
            <a href="index.php" class="btn btn-brand"><i class="fa-solid fa-plus me-2"></i>Nuevo cliente</a>
        </div>

        <?php if ($mensaje != "") : ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i><?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-panel">
                    <h2 class="panel-title">
                        <?php echo $editando ? '<i class="fa-solid fa-pen me-2"></i>Editar cliente' : '<i class="fa-solid fa-user-plus me-2"></i>Nuevo cliente'; ?>
                    </h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="txtDocumento" class="form-label">Documento</label>
                            <input type="text" name="txtDocumento" id="txtDocumento" class="form-control" placeholder="Ej. 1020304050" required value="<?php echo e($clienteActual["documento"]); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="txtNombre" class="form-label">Nombre completo</label>
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Ej. Laura Gómez" required value="<?php echo e($clienteActual["nombre"]); ?>">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6 col-lg-12 col-xl-6">
                                <label for="txtTelefono" class="form-label">Teléfono</label>
                                <input type="tel" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="300 123 4567" required value="<?php echo e($clienteActual["telefono"]); ?>">
                            </div>
                            <div class="col-sm-6 col-lg-12 col-xl-6">
                                <label for="txtCorreo" class="form-label">Correo</label>
                                <input type="email" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="correo@ejemplo.com" required value="<?php echo e($clienteActual["correo"]); ?>">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="archivo" class="form-label">Fotografía</label>
                            <input type="file" name="archivo" id="archivo" class="form-control" accept=".jpg,.jpeg,.png">
                            <div class="form-text">Formatos admitidos: JPG o PNG.</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-brand flex-fill"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar</button>
                            <?php if ($editando) : ?>
                                <a href="index.php" class="btn btn-light border">Cancelar</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-panel p-0">
                    <div class="table-toolbar">
                        <h2 class="panel-title m-0">Listado de clientes <span class="count-badge"><?php echo count($aClientes); ?></span></h2>
                        <div class="search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombre, documento o correo">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-clients align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-clientes">
                                <?php foreach ($aClientes as $i => $cliente) : ?>
                                    <tr>
                                        <td>
                                            <div class="client">
                                                <?php if ($cliente["imagen"] != "") : ?>
                                                    <img src="imagenes/<?php echo e($cliente["imagen"]); ?>" alt="" class="avatar">
                                                <?php else : ?>
                                                    <span class="avatar avatar-initials"><?php echo e(iniciales($cliente["nombre"])); ?></span>
                                                <?php endif; ?>
                                                <div>
                                                    <strong><?php echo e($cliente["nombre"]); ?></strong>
                                                    <small><?php echo e($cliente["correo"]); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo e($cliente["documento"]); ?></td>
                                        <td><?php echo e($cliente["telefono"]); ?></td>
                                        <td class="text-end text-nowrap">
                                            <a href="index.php?pos=<?php echo $i; ?>&do=editar" class="btn-icon" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                            <a href="index.php?pos=<?php echo $i; ?>&do=eliminar" class="btn-icon danger" title="Eliminar" data-nombre="<?php echo e($cliente["nombre"]); ?>"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (count($aClientes) == 0) : ?>
                        <div class="empty">
                            <i class="fa-regular fa-address-book"></i>
                            <p>Aún no hay clientes registrados.<br>Usa el formulario para crear el primero.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Filtro en vivo del listado
        document.getElementById("buscar").addEventListener("input", function () {
            const texto = this.value.toLowerCase();
            document.querySelectorAll("#tabla-clientes tr").forEach(function (fila) {
                fila.style.display = fila.textContent.toLowerCase().includes(texto) ? "" : "none";
            });
        });

        // Confirmación antes de eliminar
        document.querySelectorAll("a.danger").forEach(function (enlace) {
            enlace.addEventListener("click", function (e) {
                if (!confirm("¿Eliminar a " + this.dataset.nombre + "?")) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>

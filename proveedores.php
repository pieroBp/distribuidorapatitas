 <?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "proveedores";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
    if (!empty($_POST)) {
		$alert = "";
    if (empty($_POST['nombre']) || empty($_POST['ruc']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $ruc = $_POST['ruc'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $usuario_id = $_SESSION['idUser'];
        $estado=1;
        $query = mysqli_query($conexion, "SELECT * FROM proveedores where ruc = '$ruc'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El Ruc ya esta registrado
                    </div>';
        }else{
        

        $query_insert = mysqli_query($conexion, "INSERT INTO proveedores(ruc,nombre,telefono,direccion,usuario_id,estado) values ('$ruc', '$nombre', '$telefono', '$direccion','$usuario_id','$estado')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Proveedor Registrado
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar proveedor
                    </div>';
        }
        }
    }


    }



    ?>
 <button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_producto"><i class="fas fa-plus"></i></button>
 <?php echo isset($alert) ? $alert : ''; ?>
 <div class="table-responsive">
     <table class="table table-striped table-bordered" id="tbl">
         <thead class="thead-dark">
             <tr>
                 <th>#</th>
                 <th>RUc</th>
                 <th>Nombre-Proveedor</th>
                 <th>DIRECCION</th>
                 <th>TELEFONO</th>
                 <th>Estado</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>
             <?php
                include "../conexion.php";

                $query = mysqli_query($conexion, "SELECT * FROM proveedores");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        if ($data['estado'] == 1) {
                            $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                        } else {
                            $estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                        }
                ?>
                     <tr>
                         <td><?php echo $data['codproveedor']; ?></td>
                         <td><?php echo $data['ruc']; ?></td>
                         <td><?php echo $data['nombre']; ?></td>
                         <td><?php echo $data['direccion']; ?></td>
                         <td><?php echo $data['telefono']; ?></td>
                         <td><?php echo $estado ?></td>
                         <td>
                             <?php if ($data['estado'] == 1) { ?>
                                  <a href="editar_proveedor.php?id=<?php echo $data['codproveedor']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>

                                 <form action="eliminar_proveedor.php?id=<?php echo $data['codproveedor']; ?>" method="post" class="confirmar d-inline">
                                     <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                 </form>
                             <?php } ?>
                         </td>
                     </tr>
             <?php }
                } ?>
         </tbody>

     </table>
 </div>
 <div id="nuevo_producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <h5 class="modal-title" id="my-modal-title">Nuevo Proveedor</h5>
                 <button class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="" method="post" autocomplete="off">
                     <?php echo isset($alert) ? $alert : ''; ?>
                     <div class="form-group">
                         <label for="ruc">RUC</label>
                         <input type="text" placeholder="Ingrese ruc" name="ruc" id="ruc" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="nombre">NOMBRE</label>
                         <input type="text" placeholder="Ingrese nombre" name="nombre" id="nombre" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="telefono">TELEFONO</label>
                         <input type="text" placeholder="Ingrese telefono" name="telefono" id="telefono" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="direccion">DIRECCION</label>
                         <input type="text" placeholder="Ingrese direccion" class="form-control" name="direccion" id="direccion">
                     </div>
                      
                     <input type="submit" value="Guardar Proveedores" class="btn btn-primary">
                 </form>
             </div>
         </div>
     </div>
 </div>

 <?php include_once "includes/footer.php"; ?>

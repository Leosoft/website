<?php include("../template/cabecera.php"); ?>

<?php
      
      $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
      $txtNombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
      $txtImagen =  $txtID = (isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
      $accion=(isset($_POST['accion']))?$_POST['accion']:"";

      //incluyo la base de datos
      include("../config/bd.php");

      switch($accion){

        case "Agregar":

            //INSERT INTO `libros` (`id`,`nombre`,`imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');

            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen) VALUES (:nombre,:imagen);");
            //insertar informacion
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':imagen', $txtImagen);
            $sentenciaSQL->execute();

            break;

            case "Modificar":
                echo "Presionado boton de modificar";
                break;
                
            case "Cancelar":
                    echo "Presionado boton cancelar";
                    break;

            case "Seleccionar":
                        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
                        $sentenciaSQL->bindParam(':id', $txtID);
                        $sentenciaSQL->execute();
                        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                       $txtNombre = $libro['nombre'];
                       $txtImagen = $libro['imagen'];

                        break;

            case "Borrar":
                    
                            $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
                            $sentenciaSQL->bindParam(':id', $txtID);
                            $sentenciaSQL->execute();
                            
                            //echo "Presionado boton Borrar";
                        break;

                        
      }

      $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
      $sentenciaSQL->execute();
      $listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- b4 grid col -->
<div class="col-md-5">

<!-- card foot header --> 
<div class="card">
    <div class="card-header">
       Datos de Libros
    </div>

    <div class="card-body">

    <!-- Utilzo !crt form login en este caso -->
    <!-- formulario para agregar libros -->
    <form method="POST" enctype="multipart/form-data"> <!-- propiedad para enviar y recibir los archivos como fotos -->
     <div class = "form-group">
     <label for="txtID">ID:</label>
     <input type="text" class="form-control" value="<?php echo $txtID; ?> " name="txtID" id="txtID" placeholder="ID">
     </div>

     <div class = "form-group">
     <label for="txtNombre">Nombre:</label>
     <input type="text" class="form-control"  value="<?php echo $txtNombre; ?>  name="txtNombre" id="txtNombre" placeholder="Nombre del libro">
     </div>

     <div class = "form-group">
     <label for="txtNombre">Imagen:</label>
     <input type="file" class="form-control"  value="<?php echo $txtImagen; ?>  name="txtImagen" id="txtNombre" placeholder="Nombre del libro">
     </div>

     <!-- b4-bgroup-default -->
     
     <div class="btn-group" role="group" aria-label="">
         <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
         <button type="submit"  name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
         <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
     </div>

     </form>
        
    </div>
</div>
    

     
     
    
</div>

<div class="col-md-7">
    <!-- tabla de libros -->
    <!-- b4 table default --> 
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de libro</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach($listaLibros as $libro) { ?>
        
        
            <tr>
                <td><?php echo $libro['id'];?> </td>
                <td><?php echo $libro['nombre'];?></td>
                <td><?php echo $libro['imagen'];?></td>

                <td>
                    

                    <form method="post">

                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>" />

                        <input type="submit" name="accion" valuse="Seleccionar" class="btn btn-primary" />

                       <input type="submit" name="accion" value="Borrar"  class="btn btn-danger" />

                    </form>

                </td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include("../template/pie.php"); ?>
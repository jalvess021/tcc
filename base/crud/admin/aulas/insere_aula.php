<?php
    include "base/crud/atv_usu/atv.php";
    $usuario = $_SESSION['UsuarioNome'];
    $id_usuario = $_SESSION['UsuarioID'];

    $id_video           = substr($_POST['id_video'], 17);
    $aula              = $_POST["tit_aula"];
    $descricao         = $_POST["desc_aula"];
    $modulo          = $_POST["modulo"];
    $start                = $_POST['start'];
    $end                  = $_POST['end'];
      
   

    $sql = "insert into aula values ";
    $sql .= "('0','".$id_video."','".$aula."','".$descricao."','".$start."','".$end."', NOW(), NULL, NULL, '".$modulo."');";

    $resultado = mysqli_query($con, $sql)or die(mysqli_error());

    if($resultado){

        $usu_atv = mysqli_query($con, atvAdm($usuario, str_replace( array("'"), "\'", $sql), $id_usuario));
        if ($usu_atv) {
            header('Location: \tcc/plataforma.php?content_adm=lista_aula&msg=10');
            mysqli_close($con);
        }else{
            header('Location: \tcc/plataforma.php?content_adm=lista_aula&msg=6');
            mysqli_close($con);
        }
        
    }
?>
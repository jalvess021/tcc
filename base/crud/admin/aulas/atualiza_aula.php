<?php
    include "base/crud/atv_usu/atv.php";
    $usuario = $_SESSION['UsuarioNome'];
    $id_usuario = $_SESSION['UsuarioID'];

  $id_aula           = $_POST["id_aula"];
  $aula              = $_POST["tit_aula"];
  $descricao         = $_POST["desc_aula"];
  $id_video           = substr($_POST["id_video"], 17);
  $modulo            = $_POST['modulo'];
  $start                = $_POST['start'];
  $end                  = $_POST['end'];


   

    $sql = "update aula set ";
    $sql .= "id_video='".$id_video."', tit_aula='".$aula."', desc_aula='".$descricao."', start_aula='".$start."', end_aula='".$end."', id_mod='".$modulo."', dt_alteracao=NOW() , id_mod='".$modulo."'";
    $sql .= "where id_aula= '".$id_aula."';";


    $resultado = mysqli_query($con, $sql)or die(mysqli_error());

    if($resultado){

        $usu_atv = mysqli_query($con, atvAdm($usuario, str_replace( array("'"), "\'", $sql), $id_usuario));
        if ($usu_atv) {
            header('Location: \tcc/plataforma.php?content_adm=lista_aula&msg=11');
            mysqli_close($con);
        }else{
            header('Location: \tcc/plataforma.php?content_adm=lista_aula&msg=6');
            mysqli_close($con);
        }
        
    }
?>

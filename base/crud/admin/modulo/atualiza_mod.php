<?php
    
    include "base/crud/atv_usu/atv.php";
    $usuario = $_SESSION['UsuarioNome'];
    $id_usuario = $_SESSION['UsuarioID'];

  $formacao            = $_POST['formacao'];
  $id_mod           =  $_POST['id_mod'];
  $modulo           = $_POST['nome_mod'];
  $curso              = $_POST["curso"];
  $descricao         = $_POST["desc_mod"];
   

    $sql = "update modulo set ";
    $sql .= "nome_mod='".$modulo."', desc_mod='".$descricao."', id_curso='".$curso."', dt_alteracao=NOW() ";
    $sql .= "where id_mod= '".$id_mod."';";
    $res = mysqli_query($con, $sql)or die(mysqli_error());

    if($res){
        
    $usu_atv = mysqli_query($con, atvAdm($usuario, str_replace( array("'"), "\'", $sql), $id_usuario));
        if ($usu_atv) {
            header('Location: \tcc/plataforma.php?content_adm=lista_mod&msg=14');
            mysqli_close($con);
        }else{
            header('Location: \tcc/plataforma.php?content_adm=lista_mod&msg=6');
            mysqli_close($con);
        }
        
    }

?>
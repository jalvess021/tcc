<?php
    include "base/crud/atv_usu/atv.php";
    $usuario = $_SESSION['UsuarioNome'];
    $id_usuario = $_SESSION['UsuarioID'];

    $dificuldade    = $_POST['dificuldade']; 
    $enunciado      = $_POST['enunciado'];
    $c              = $_POST['correta'];
    $i1             = $_POST['incorreta1'];
    $i2             = $_POST['incorreta2'];
    $modulo          = $_POST["modulo"];
    
    // Pontuando a questão por dificuldade
    switch ($dificuldade) {
        case 1:
            $valor = 0.3;
            break;
        case 2:
            $valor = 0.6;
            break;
        case 3:
            $valor = 0.8;
            break;
    }


    $sql = "INSERT into questoes (id_quest, enunciado_quest, grau_dificuldade, pont_quest, opc_certa, opc_errada1, opc_errada2, id_mod) values ";
    $sql .= "('0', '".$enunciado."','".$dificuldade."','".$valor."', '".$c."', '$i1', '$i2','".$modulo."');";
    $res = mysqli_query($con, $sql)or die(mysqli_error());
 
    if($res){

            $usu_atv = mysqli_query($con, atvAdm($usuario, str_replace( array("'"), "\'", $sql), $id_usuario));
            if ($usu_atv) {
                header('Location: \tcc/plataforma.php?content_adm=lista_av&msg=16');
                mysqli_close($con);
            }else{
                header('Location: \tcc/plataforma.php?content_adm=lista_av&msg=6');
                mysqli_close($con);
            }
    } 
?>
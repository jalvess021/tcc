<?php
	//Definindo nível de acesso para esta página & fazendo a verificação.
	$nivel_necessario = 3;
	include "base/testa_nivel.php"; 

$id_usu = (int) $_GET['id'];

$sql = "update usuario set ";
$sql .= "status='0' ";
$sql .= "where id_usu = '".$id_usu."';";

$resultado = mysqli_query($con, $sql)or die(mysqli_error($con));

if($resultado){
	header('Location: \eadev/index.php?page=lista_usu&msg=3');
	mysqli_close($con);
}else{
	header('Location: \eadev/index.php?page=lista_usu&msg=6');
	mysqli_close($con);
}

?>

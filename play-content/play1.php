<?php 
    $nivel_necessario = 2;
    include "base/testa_nivel.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/all-play.css">
    <title> Conteúdo | Eadev</title>
</head>
<body>
<?php 
require "./base/config.php";
if (isset($_GET['page']) && $_GET['page'] === 'play_curso') {
    if (isset($_GET['curso'])) {

        $sigla = $_GET['curso'];
        //Selecionando as informações do curso através da url
        $sqlCur = mysqli_query($con, "SELECT * FROM curso WHERE sigla_curso = '".$_GET['curso']."';");
        $infoCur = mysqli_fetch_array($sqlCur);
        $cur = (int) $infoCur['id_curso'];

      if (mysqli_num_rows($sqlCur) > 0) {

            $id_usu = $_SESSION['UsuarioID'];
            $resAlu = mysqli_query($con, "SELECT * from aluno where id_usu = ".$id_usu.";");
            $infoAlu = mysqli_fetch_array($resAlu);
        
            //Conta todas as aulas que o aluno está inserido
            $percentAll = mysqli_query($con, "SELECT aa.* from aula_alu aa INNER JOIN aula a ON aa.id_aula = a.id_aula INNER JOIN modulo m on a.id_mod = m.id_mod INNER JOIN curso c ON m.id_curso = c.id_curso AND c.sigla_curso = '".$_GET['curso']."' WHERE aa.id_aluno = ".$infoAlu['id_aluno'].";");
            $numPercentAll = mysqli_num_rows($percentAll);
        
            //Conta todas as aulas que o aluno concluiu
            $percentCon = mysqli_query($con, "SELECT aa.* from aula_alu aa INNER JOIN aula a ON aa.id_aula = a.id_aula INNER JOIN modulo m on a.id_mod = m.id_mod INNER JOIN curso c ON m.id_curso = c.id_curso AND c.sigla_curso = '".$_GET['curso']."' WHERE aa.id_aluno = ".$infoAlu['id_aluno']." AND aa.status_aula = 2;");
            $numPercentCon = mysqli_num_rows($percentCon);
        
            //Verifica o progresso em porcentagem
            if ($numPercentAll == 0) {
                $progresso = 0;
            } else {
                $progresso = ($numPercentCon * 100) / $numPercentAll;
            }
            echo "
        
            <style>
                /*Crescimento da barra de progressão*/
                @keyframes view-class{
                    0%{
                        width: 0%;
                    }
                    100%{
                        width:".round($progresso, 1)."%;
                    }
                }
            </style>
            ";

            //Selecionando as informações dos módulos através do curso
            $sqlMod = mysqli_query($con, "SELECT * from modulo where id_curso = ".$cur.";");

            //Selecionando a qntde. de módulos através do curso
            $sql1 = mysqli_query($con, "SELECT COUNT(id_mod) FROM modulo m WHERE m.id_curso = '".$infoCur['id_curso']."';");
            $row1 = mysqli_fetch_array($sql1);

            //Selecionando a qntde. de aulas através do curso e do módulo
            $sql2 = mysqli_query($con, "SELECT COUNT(id_aula) FROM aula a INNER JOIN modulo AS m ON a.id_mod = m.id_mod AND m.id_curso = '".$infoCur['id_curso']."' ;");
            $row2 = mysqli_fetch_array($sql2);
            
    echo "
            <div class='d-flex flex-row view-overall'>
                <div class='gradient'>
                    <div class='zoom'>
                        <a href='?content_alu=conteudo'><button type='button' class='back'><i class='bi bi-arrow-left'></i> Voltar</button></a>
                        <br>
                        <button type='button' class='info-cur'>".$infoCur['sigla_curso']."</button>
                        <h2 class='title-cur'>".$infoCur['nome_curso']."</h2>
                        <p class='description-cur'>".$infoCur['desc_curso']."</p>
                        <p class='person-cur'>Preparado por: Eadev</p>
                        <div class='d-flex flex-row'>
                            <p class='number-cur'><i class='bi bi-layers-fill'></i> ".$row1[0]; echo ($row1[0] <= 1) ? " Módulo" : " Módulos"; echo "</p>";
                            echo "
                            <p class='quant-cur'><i class='bi bi-collection-play-fill '></i> ".$row2[0];  echo($row2[0] <= 1) ? ' Aula' : ' Aulas'; echo "</p>
                        
                        </div>

                        <hr noshade='noshade' class='line'>
                        <div class='d-flex flex-row'>
                            <div class='icon-cur'>
                                <i class='bi bi-star icon-star'></i>
                                <i class='bi bi-star icon-star'></i>
                                <i class='bi bi-star icon-star'></i>
                                <i class='bi bi-star icon-star'></i>
                                <i class='bi bi-star icon-star'></i>
                            </div>
                            <p class='av-cur'>Deixe sua avaliação</p>
                        </div>
                    </div>
                </div>
                <div class='all-class'>
                        <h4 class='title-class1'>Seu progresso</h4>
                        <div class='d-flex flex-row procent-class'>
                            <div class='progress-bar-cur'>
                                    <div class='view-class'></div>
                            </div>
                            <p class='porcent-class'>".round($progresso, 1)."%</p>
                        </div>
                        <h3 class='content-title-class'>Aulas</h3>

                        <div class='all-aula'>
                            <div class='all-aula1'> ";

                    while ($infoMod = mysqli_fetch_array($sqlMod)){
                       $sqlIsset = mysqli_query($con, "SELECT COUNT(id_aula) FROM aula a inner join modulo m ON a.id_mod = m.id_mod AND m.id_mod = ".$infoMod['id_mod'].";");
                       $resIsset = mysqli_fetch_array($sqlIsset);
                       
                                if ($resIsset[0] > 0) {
                                    echo "<h4 class='title-class2'>".$infoMod['nome_mod']."</h4>";
            
                                    //Selecionando as informações da aula através do módulo
                                    $sqlAula = mysqli_query($con, "SELECT * FROM aula where id_mod = '".$infoMod['id_mod']."';");
                                    while ($infoAula = mysqli_fetch_array($sqlAula)){

                                        // Duração da aula
                                        $start = $infoAula['start_aula'];
                                        $end = $infoAula['end_aula'];
                                        $total = $end - $start;
                                        
                                        echo "
                                        <a class='d-flex flex-row justify-content-between view-lesson' href='?page=play_video&curso=".$infoCur['sigla_curso']."&aula=".$infoAula['id_aula']."'>
                                            <div class='d-flex flex-row'>
                                                <i class='bi bi-camera-video cam'></i>
                                                <p class='name-class'>".$infoAula['tit_aula']."</p>
                                            </div>
                                            <div class='d-flex flex-row'>
                                                <p class='time-class'>00:".gmdate("i", $total).":".gmdate("s", $total)."</p>
                                                <span class='play'><i class='bi bi-play-circle'></i></span>
                                            </div>
                                        </a>";
                                    } 

                                        echo "<hr class='line-class'>";
                                }
                            }
                            
                            

                            echo "
                            </div>
                        </div>

                </div>
            </div>
            "; 
            
        } 
    }
}
?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</html>
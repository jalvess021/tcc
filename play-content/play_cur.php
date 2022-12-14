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
                    $percentAll = mysqli_query($con, "SELECT aa.* from aula_alu aa INNER JOIN aula as a ON aa.id_aula = a.id_aula INNER JOIN modulo as m on a.id_mod = m.id_mod INNER JOIN curso as c ON m.id_curso = c.id_curso AND c.sigla_curso = '".$_GET['curso']."' WHERE aa.id_aluno = ".$infoAlu['id_aluno'].";");
                    $numPercentAll = mysqli_num_rows($percentAll);
                
                    //Conta todas as aulas que o aluno concluiu
                    $percentCon = mysqli_query($con, "SELECT aa.* from aula_alu aa INNER JOIN aula as a ON aa.id_aula = a.id_aula INNER JOIN modulo as m on a.id_mod = m.id_mod INNER JOIN curso as c ON m.id_curso = c.id_curso AND c.sigla_curso = '".$_GET['curso']."' WHERE aa.id_aluno = ".$infoAlu['id_aluno']." AND aa.status_aula = 2;");
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
                    $sql1 = mysqli_query($con, "SELECT COUNT(id_mod) FROM modulo as m WHERE m.id_curso = '".$infoCur['id_curso']."';");
                    $row1 = mysqli_fetch_array($sql1);

                    //Selecionando a qntde. de aulas através do curso e do módulo
                    $sql2 = mysqli_query($con, "SELECT COUNT(id_aula) FROM aula as a INNER JOIN modulo AS m ON a.id_mod = m.id_mod AND m.id_curso = '".$infoCur['id_curso']."' ;");
                    $row2 = mysqli_fetch_array($sql2);
                    
            echo "
                        <div class='all-play-cur'>
                            <div class='all-play-gradient'>
                                <div class='zoom-gradient'>
                                    <div class=''>
                                        <a href='?content_alu=conteudo'><button type='button' class='back-gradient'><i class='bi bi-arrow-left'></i>Voltar</button></a>
                                    </div>
                                    <div class='all-play-gradient-description'>
                                        <div class='group-play-gradient-description'>
                                            <button type='button' class='gradient-info-cur'>".$infoCur['sigla_curso']."</button>
                                            <h2 class='gradient-title-cur'>".$infoCur['nome_curso']."</h2>
                                            <p class='gradient-description-cur'>".$infoCur['desc_curso']."</p>
                                            <p class='gradient-person-cur'>Preparado por: Eadev</p>
                                            <div class='gradient-group-num'>
                                                <p class='gradient-number-cur'><i class='bi bi-layers-fill'></i> ".$row1[0]; echo ($row1[0] <= 1) ? " Módulo" : " Módulos"; echo "</p>";
                                                echo "
                                                <p class='gradient-quant-cur'><i class='bi bi-collection-play-fill '></i> ".$row2[0];  echo($row2[0] <= 1) ? ' Aula' : ' Aulas'; echo "</p>
                                            </div>
                                            <div class='group-line'>
                                                <hr noshade='noshade' class='gradient-line'>
                                            </div>
                                            <div class='gradient-group-star'>
                                                <div class='gradient-icon-cur'>
                                                    <i class='bi bi-star icon-star'></i>
                                                    <i class='bi bi-star icon-star'></i>
                                                    <i class='bi bi-star icon-star'></i>
                                                    <i class='bi bi-star icon-star'></i>
                                                    <i class='bi bi-star icon-star'></i>
                                                </div>
                                                <p class='gradient-av-cur'>Deixe sua avaliação</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='all-play-view'>
                                    <div class='all-group-progress-view '>
                                        <h4 class='progress-title-class1'>Seu progresso</h4>
                                        <div class='group-progress-view'>
                                            <div class='progress-porcent-class'>
                                                <div class='progress-bar-cur-view'>
                                                    <div class='progress-view-class'></div>
                                                </div>
                                            </div>
                                            <p class='porcent-class-view'>".round($progresso, 1)."%</p>
                                        </div>
                                    </div>
                                    <div class='play-view'>
                                        <h3 class='content-title-class-view'>Aulas</h3>
                                        <div class='play-view-1'>
                                            <div class='play-view-2'>";

                                            while ($infoMod = mysqli_fetch_array($sqlMod)){
                                               $sqlIsset = mysqli_query($con, "SELECT COUNT(id_aula) FROM aula as a inner join modulo as m ON a.id_mod = m.id_mod AND m.id_mod = ".$infoMod['id_mod'].";");
                                               $resIsset = mysqli_fetch_array($sqlIsset);
                                               
                                                        if ($resIsset[0] > 0) {
                        
                                                            switch ($infoMod['tipo_mod']) {
                                                                case 1:
                                                                    $tipoMod = "Básico";
                                                                    break;
                                                                
                                                                case 2:
                                                                    $tipoMod = "Intermediário";
                                                                    break;
                                                        
                                                                case 3:
                                                                    $tipoMod = "Avançado";
                                                                    break;
                                                            }
                        
                                                            echo "<h4 class='title-class2'>".$tipoMod."</h4>";
                                    
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
                        </div>
                    "; 
                    
                } 
            }
        }
        ?>
        </body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        </html>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Véro Grué - ProyectoTema5 Ejercicio05</title>
        <link rel="stylesheet" href="../webroot/css/styleEjercicios.css">
        <style>
            h3{
                font-size: 24px;
            }
            table{
                border:solid;
                width: 80%;
                text-align: center;
                border-collapse: collapse;
            }
            th{
                border: solid;
                padding: 5px 0 5px 0;
                font-size: 20px;
                font-weight: 900;
                background-color: lightskyblue;
            }
            td{
                border: solid 1px;
                padding: 5px 0 5px 0;
                font-size: 18px;
                border-right: solid ;
            }
            .contenedorTabla{
                width: 100%;
                margin-bottom: 10px;
                height: auto;
                padding-top: 10px;
            }
        </style>
    </head>
    <body>
        <header class="header">
            <a href="../indexProyectoTema5.php">volver</a>
            <h1>Ejercicio 05</h1>
        </header>
        <main>
            <section>
                <?php
                /**
                 * @author: Véronique Grué
                 * @since 13/11/2025
                 * 
                 *  * Ejercicio 5
                 * * 	Página web que añade tres registros a nuestra tabla Departamento utilizando 
                 * tres instrucciones insert y una transacción, de tal forma que se añadan 
                 * los tres registros o no se añada ninguno. 
                 */
                // VERSION CON CONSULTA PREPARADA
                
                require_once '../config/confDBPDO.php';

                //Establecer la conexión en la base de datos
                
                echo'<h3 class="titulo">Inserción de 3 departamentos con transación</h3>';
                //Establecer la conexión en la base de datos

                $aDepartamentos = [
                    ['CodDpto' => 'FRA',
                        'DescDpto' => 'Francés',
                        'VolDpto' => 4567.98],
                    ['CodDpto' => 'ING',
                        'DescDpto' => 'Ingles',
                        'VolDpto' => 14567.98],
                    ['CodDpto' => 'ALE',
                        'DescDpto' => 'Aleman',
                        'VolDpto' => 4067.98]
                ];
                try {

                    echo'<h3 style="color:blue; font-weight:bold;">Conexion establecida con exito!!!!</h3><br></br>';

                    //Establecer la conexión en la base de datos
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $miDB->beginTransaction();
                    // Creacion de la consulta. Se puede utilizar heredoc para que se vea mejor el codigo
                    $sql = <<<SQL
                    INSERT INTO T_02Departamento 
                        (T02_CodDepartamento, 
                         T02_DescDepartamento, 
                         T02_VolumenDeNegocio)
                    VALUES (:codigo, :descripcion, :volumen)          
                    SQL;

                    //Empieza la transacción

                    $consultaPreparada = $miDB->prepare($sql);

                    //bucle for para el insert
                    foreach ($aDepartamentos as $departamento) {

                        $consultaPreparada->bindParam(':codigo', $departamento['CodDpto']);
                        $consultaPreparada->bindParam(':descripcion', $departamento['DescDpto']);
                        $consultaPreparada->bindParam(':volumen', $departamento['VolDpto']);

                        $consultaPreparada->execute();
                    }
                    $miDB->commit();
                    echo'<h3 style="color:blue; font-weight:bold;">Los 3 departamentos se han insertado correctamente!!!!</h3><br></br>';
                    
                    //SECCION DE LA TABLA
                    echo' <section class="contenedorTabla">';

                    try {
                        
                        //consulta preparada para devolver datos
                        $consultaPreparada2 = $miDB->prepare('SELECT * FROM T_02Departamento');
                        $consultaPreparada2->execute();
                        
                        //Mostrar los registros
                        //https://www.php.net/manual/es/pdostatement.fetch.php


                        echo'<table>';
                        echo '<tr>';
                        echo'<th> Codigo </th>';
                        echo '<th> Fecha Creación </th>';
                        echo '<th> Fecha Baja </th>';
                        echo '<th> Descripción </th>';
                        echo '<th> Volumen de Negocio</th>';
                        echo '</tr>';

                        while ($oRegistroObject = $consultaPreparada2->fetchObject()) {
                            echo '<tr>';
                            echo'<td> ' . $oRegistroObject->T02_CodDepartamento . '</td>';
                            $oFechaCreacion = new DateTime($oRegistroObject->T02_FechaCreacionDepartamento);
                            echo'<td> ' . $oFechaCreacion->format("d-m-Y") . '</td>';
                            if (!is_null($oRegistroObject->T02_FechaBajaDepartamento)) {
                                //si no se pone la condición la fecha no es null
                                $oFechaBaja = new DateTime($oRegistroObject->T02_FechaBajaDepartamento);
                                echo '<td>' . $oFechaBaja->format("d-m-Y") . '</td>';
                            } else {
                                echo '<td>Activo</td>';
                            }
                            echo'<td> ' . $oRegistroObject->T02_DescDepartamento . '</td>';
                            echo'<td> ' . number_format($oRegistroObject->T02_VolumenDeNegocio, 2, ',', '.') . '€</td>';
                            echo '</tr>';
                        }

                        $numRegistros = $miDB->prepare('SELECT COUNT(*) FROM T_02Departamento');
                        $numRegistros->execute();
                        $total = $numRegistros->fetchColumn();
                        echo '<tr>';
                        echo "<td class='registro' colspan=5><strong>Número de registros:</strong> $total</td>";
                        echo '</table>';
                    } catch (PDOException $miExceptionPDO) {
                        echo '<p style="color:purple; font-weight:bold;">Error: ' . $miExceptionPDO->getMessage() . '<br>' . 'Código de error: ' . $miExceptionPDO->getCode();
                    } finally {
                    }

                    echo'   </section>';
                } catch (PDOException $miExceptionPDO) {
                    //si falla algo, revierte todo
                    $miDB->rollBack();
                    echo '<h3 style="color:blue; font-weight:bold;">La transacción no se ha podido completar correctamente</h3>';
                    //echo '<p style="color:purple; font-weight:bold;">Error: ' . $miExceptionPDO->getMessage() . '<br>' . 'Código de error: ' . $miExceptionPDO->getCode();
                } finally {
                    //mejor dentro para que se cierre en todos los casos.
                    unset($miDB);
                }
                ?>

        </main>
        <footer class="footer">
            <div class="footerContent">
                <div><p class="copyright">
                        2025-26 IES LOS SAUCES. &#169;Todos los derechos reservados.</p> <address><a href="../../VGDWESProyectoDWES/indexProyectoDWES.html">Véronique Grué.</a> Fecha de Actualización :
                        <time datetime="2025-10-10"></time> 10-10-2025 </address>
                </div>

            </div>

        </footer>

    </body>
</html>


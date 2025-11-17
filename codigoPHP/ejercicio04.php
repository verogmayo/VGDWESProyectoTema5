<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Véro Grué - ProyectoTema5 Ejercicio04</title>
        <link rel="stylesheet" href="../webroot/css/styleEjercicios.css">
        <style>
            *{
                margin: 0 auto;
            }
            main{
                display: block;
                align-content: center;
                margin: auto;
                text-align: center;
            }
            h2{
                margin-bottom: 30px;
            }
            label{
                font-size: 20px;
                margin-bottom: 10px;
                display: inline-block;
            }

            input {
                height : 35px;
                margin-bottom: 20px;
                display: inline-block;
                padding-left: 5px;
                border-radius: 5px;
            }

            button{
                font-size: 20px;
                background-color: grey;
                color: white;
                padding: 0 10px;
                border-radius: 5px;
                position: absolute;
                font-family: Times New Roman;
                height: 35px;
            }


            section{
                display: inline-block;
                position: relative;
                height: 150px;
                width: 800px;
            }


            input#DescDpto{
                width: 500px;
                margin-right: 20px;
            }
            input#T02_CodDepartamento{
                width: 35px;
            }


            #DescDpto{
                font-weight: bold;
            }
            li{
                font-size: 20px;

            }
            h3{
                font-size: 25px;
                margin-bottom: 20px;
            }
            #T02_FechaCreacionDepartamento, #T02_FechaBajaDepartamento{
                background-color: gainsboro;
            }


            table{
                border:solid;
                width: 80%;
                text-align: center;
                border-collapse: collapse;
                margin-bottom: 20px
            }
            th{
                border: solid;
                padding: 5px 10px;
                font-size: 20px;
                font-weight: 900;
                background-color: lightskyblue;
                white-space: nowrap;
            }
            td{
                border: solid 1px;
                padding: 5px;
                font-size: 18px;
                border-right: solid ;
            }
            .titulo{
                text-align: center;
            }
            .registro{
                border: solid;
                font-size: 20px;
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
            <h1>Ejercicio 04</h1>
        </header>
        <main>

            <?php
            /**
             * @author: Véronique Grué
             * @since 13/11/2025
             * 
             *  * Ejercicio 4
             * * Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos) .
             */
            //CON CONSULTA PREPARADA
            //enlace para importar las librerías de validación de campos
            require_once '../core/libreriaValidacion.php';
            //enlace para la configuración de la conexion a la base de datos
            require_once '../config/confDBPDO.php';

            ///inicialización de variables
            /** @var array $aErrores Array para almacenar mensajes de error de validación. */
            $aErrores = [
                'DescDpto' => null
            ];
            /** @var array $aRespuestas Array para almacenar las repuestas. */
            $aRespuestas = [
                'DescDpto' => ''
            ];

            /** @boollean boolean $entradaOK Indica si los datos de entrada son correctos o no. */
            $entradaOK = true;

            //Para cada campo del formulario se valida la entrada y se actua en consecuencia
            if (isset($_REQUEST['buscar'])) {//se cumple si el boton es buscar
                // $aErrores['T02_DescDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['T02_DescDepartamento'], 255, 0, 0);
                if (!empty($_REQUEST['DescDpto'])) {
                    $aErrores['DescDpto'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['DescDpto'], 255, 0, 0);
                }

                //recorre el array de errores para detectar si hay alguno
                foreach ($aErrores as $valorCampo) {
                    if (!is_null($valorCampo) && $valorCampo !== '') {
                        $entradaOK = false;
                    }
                }
            } else {
                //Si no se ha aceptado el formulario
                $entradaOK = false;
            }
            //Tratamiento del formulario
            if ($entradaOK) {
                //REllenamos el array de respuesta con los valores que ha introducido el usuario

                $aRespuestas['DescDpto'] = ($_REQUEST['DescDpto']);
            }
            //si hay algún error se vuelve a mostrar el formulario
            ?>
            <section>
                <h2>Mantenimiento del Departamento.</h2>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                    <label for="DescDpto">Descripción:</label>
                    <a style='color:red'><?php echo $aErrores['DescDpto'] ?></a>
                    <input name="DescDpto" id="DescDpto" type="text" value="<?php echo(empty($aErrores['DescDpto'])) ? ($_REQUEST['DescDpto'] ?? '') : ''; ?>">

                    <button type="submit" name="buscar" id="buscar">Buscar</button>


                </form>  


            </section>
            <section class="contenedorTabla">
                <?php
                try {
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    if (empty($aRespuestas['DescDpto'])) {
                        $sql = "SELECT * FROM T_02Departamento ";
                    } else {
                        //Consulta si el usuario introduce parte o la totalidad de la descripción
                        $RespuestasSql = "%" . $aRespuestas['DescDpto'] . "%";

                        $sql = "SELECT * FROM T_02Departamento WHERE T02_DescDepartamento LIKE '$RespuestasSql'";
                    }
                    
                    //consulta preparada para devolver datos
                    $consultaPreparada2 = $miDB->prepare($sql);
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
                    unset($miDB);
                }
                ?>
            </section>

        </main>

        <footer class="footer">
            <div class="footerContent">
                <div><p class="copyright">
                        2025-26 IES LOS SAUCES. &#169;Todos los derechos reservados.</p> <address><a href="../../VGDWESProyectoDWES/indexProyectoDWES.html">Véronique Grué.</a> Fecha de Actualización :
                        <time datetime="2025-11-13"></time> 13-11-2025 </address>
                </div>

            </div>

        </footer>

    </body>
</html>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Véro Grué - ProyectoTema5 Ejercicio06</title>
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
            <h1>Ejercicio 06</h1>
        </header>
        <main>
            <section>
                <?php
                /**
                 * @author: Véronique Grué
                 * @since 12/11/2025
                 * 
                 *  * Ejercicio 6
                 * Página web que cargue registros en la tabla Departamento desde un array departamentos 
                 * nuevos utilizando una consulta preparada.
                 * 
                  /**
                 * Script para insertar departamentos en la base de datos mediante transacciones PDO
                 * 
                 * Este archivo realiza las siguientes operaciones:
                 * 1. Inserta departamentos usando transacciones
                 * 2. Consulta y muestra todos los registros de la tabla T_02Departamento
                 * 3. Formatea las fechas y valores monetarios para su visualización
                 */
                //enlace a los datos de conexión
                require_once '../config/confDBPDO.php';

                /**
                 * Array asociativo con los datos de los nuevos departamentos a insertar
                 * 
                 * @var array $aDepartamentos Contiene CodDpto, DescDpto y VolDpto de cada departamento
                 */
                $aDepartamentos = [
                    ['CodDpto' => 'RUS',
                        'DescDpto' => 'Ruso',
                        'VolDpto' => 4567.98],
                    ['CodDpto' => 'CHI',
                        'DescDpto' => 'Chino',
                        'VolDpto' => 14567.98],
                    ['CodDpto' => 'ITA',
                        'DescDpto' => 'Italiano',
                        'VolDpto' => 4067.98]
                ];

                try {
                    /**
                     * Conexión a la base de datos mediante PDO
                     * 
                     * @var PDO $miDB Objeto de conexión a la base de datos
                     */
                    //Establecer la conexión en la base de datos
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Inicia la transacción para garantizar la integridad de los datos
                    $miDB->beginTransaction();

                    /**
                     * Consulta SQL preparada para insertar departamentos
                     * 
                     * @var string $sql Sentencia INSERT con parámetros nombrados
                     */
                    // Creacion de la consulta. Se puede utilizar heredoc para que se vea mejor el codigo
                    $sql = <<<SQL
                    INSERT INTO T_02Departamento 
                        (T02_CodDepartamento, 
                         T02_DescDepartamento, 
                         T02_VolumenDeNegocio)
                    VALUES (:codigo, :descripcion, :volumen)          
                    SQL;

                    //Empieza la transacción

                    /**
                     * Consulta preparada para la inserción de departamentos
                     * 
                     * @var PDOStatement $consultaPreparada Statement preparado con la consulta SQL
                     */
                    $consultaPreparada = $miDB->prepare($sql);

                    /**
                     * Bucle para insertar cada departamento del array
                     * Vincula los parámetros y ejecuta la consulta para cada departamento
                     */
                    //bucle for para el insert
                    foreach ($aDepartamentos as $departamento) {

                        $consultaPreparada->bindParam(':codigo', $departamento['CodDpto']);
                        $consultaPreparada->bindParam(':descripcion', $departamento['DescDpto']);
                        $consultaPreparada->bindParam(':volumen', $departamento['VolDpto']);

                        $consultaPreparada->execute();
                    }

                    // Confirma la transacción
                    $miDB->commit();
                    echo "<h3 style='color:green; font-weight:bold;'>Todos los departamentos fueron insertados correctamente.</h3>";

                    try {
                        /**
                         * Nueva conexión para consultar los datos insertados
                         * 
                         * @var PDO $miDB Objeto de conexión a la base de datos
                         */
                        //Establecer la conexión en la base de datos
                        $miDB = new PDO(DNS, USUARIODB, PSWD);
                        echo'<h3 style="color:blue; font-weight:bold;">Conexion establecida con exito!!!!</h3><br></br>';

                        /**
                         * Resultado de la consulta SELECT
                         * 
                         * @var PDOStatement $resultadoConsulta Objeto con los resultados de la consulta
                         */
                        //query para devolver datos
                        $resultadoConsulta = $miDB->query('SELECT * FROM T_02Departamento');

                        /**
                         * Muestra los registros en formato tabla HTML
                         * Formatea fechas en formato d-m-Y y el volumen de negocio con separadores decimales
                         */
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

                        /**
                         * Itera sobre cada registro y lo muestra como fila de tabla
                         * 
                         * @var stdClass $oRegistroObject Objeto con los datos de cada registro
                         * @var DateTime $oFechaCreacion Objeto DateTime para formatear la fecha de creación
                         * @var DateTime $oFechaBaja Objeto DateTime para formatear la fecha de baja
                         */
                        while ($oRegistroObject = $resultadoConsulta->fetchObject()) {
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

                        /**
                         * Cuenta el número total de registros en la tabla
                         * 
                         * @var PDOStatement $numRegistros Resultado de la consulta COUNT
                         * @var int $total Número total de registros
                         */
                        $numRegistros = $miDB->query('SELECT COUNT(*) FROM T_02Departamento');
                        $total = $numRegistros->fetchColumn();
                        echo '<tr>';
                        echo "<td class='registro' colspan=5><strong>Número de registros:</strong> $total</td>";
                        echo '</table>';
                    } catch (PDOException $miExceptionPDO) {
                        /**
                         * Captura y muestra errores de PDO durante la consulta
                         * 
                         * @var PDOException $miExceptionPDO Excepción lanzada por PDO
                         */
                        echo '<p style="color:purple; font-weight:bold;">Error: ' . $miExceptionPDO->getMessage() . '<br>' . 'Código de error: ' . $miExceptionPDO->getCode();
                    } finally {
                        //mejor dentro para que se cierre en todos los casos.
                        unset($miDB);
                    }
                } catch (PDOException $miExceptionPDO) {
                    /**
                     * Captura errores durante la transacción y revierte los cambios
                     * 
                     * @var PDOException $miExceptionPDO Excepción lanzada por PDO
                     */
                    $miDB->rollBack();
                    echo '<h3 style="color:blue; font-weight:bold;">La transacción no se ha podido completar correctamente</h3>';
                    echo '<p style="color:purple; font-weight:bold;">Error: ' . $miExceptionPDO->getMessage() . '<br>' . 'Código de error: ' . $miExceptionPDO->getCode();
                } finally {
                    //mejor dentro para que se cierre en todos los casos.
                    unset($miDB);
                }
                ?>
            </section>        
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


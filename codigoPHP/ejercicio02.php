<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Véro Grué - ProyectoTema5 Ejercicio02</title>
        <link rel="stylesheet" href="../webroot/css/styleEjercicios.css">

    </head>
    <body>
        <header class="header">
            <a href="../indexProyectoTema5.php">volver</a>
            <h1>Ejercicio 02</h1>
        </header>
        <main>
            <section>
                <?php
                /**
                 * @author: Véronique Grué
                 * @since 15/11/2025
                 * 
                 * Ejercicio 2: Desarrollo de un control de acceso con identificación del usuario basado 
                 * en la función header() y en el uso de una tabla “Usuario” de la base de datos. (PDO).
                 */
                //si no se han enviado las credenciales hay que pedir autenticación
                if (!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
                    header('WWW-Authenticate: Basic Realm="Contenido restringido"');
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Usuario no reconocido!";

                    exit;
                }
                //si se han enviado las credenciales,se comprueban las credenciales, con la base de datos
                //enlace a los datos de conexión
                require_once '../config/confDBPDO.php';
                try {
                    $miDB = new PDO(DNS, USUARIODB, PSWD);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT T01_CodUsuario,T01_Password,T01_DescUsuario  FROM T_01Usuario 
                      WHERE T01_CodUsuario= :usuario";

                    $resultado = $miDB->prepare($sql);
                    $resultado->execute([':usuario' => $_SERVER['PHP_AUTH_USER']]);

                    $usuarioBD = $resultado->fetch();
                    // Si no exite, se vuelve a pedir las credenciales.
                    if (!$usuarioBD || $usuarioBD['T01_Password'] !== $_SERVER['PHP_AUTH_PW']) {
                        header('WWW-Authenticate: Basic Realm="Contenido restringido"');
                        header('HTTP/1.0 401 Unauthorized');
                        echo "Credenciales incorrectas!";

                        exit;
                    }
                } catch (Exception $ex) {
                    echo"Error: " . $ex->getMessage();
                    exit;
                }
                ?>
            </section>
            <h2>Bienvenido/a, <?php echo $usuarioBD['T01_DescUsuario']; ?> </h2>
            <p>Has iniciado sesión correctamente.</p>


        </main>

        <footer class="footer">
            <div class="footerContent">
                <div><p class="copyright">
                        2025-26 IES LOS SAUCES. &#169;Todos los derechos reservados.</p> <address><a href="../../VGDWESProyectoDWES/indexProyectoDWES.html">Véronique Grué.</a> Fecha de Actualización :
                        <time datetime="2025-11-15"></time> 15-11-2025 </address>
                </div>

            </div>

        </footer>

    </body>
</html>


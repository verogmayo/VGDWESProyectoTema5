<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Véro Grué - ProyectoTema5 Ejercicio01</title>
        <link rel="stylesheet" href="../webroot/css/styleEjercicios.css">

    </head>
    <body>
        <header class="header">
            <a href="../indexProyectoTema5.php">volver</a>
            <h1>Ejercicio 01</h1>
        </header>
        <main>
            <section>
                <?php
                /**
                 * @author: Véronique Grué
                 * @since 15/11/2025
                 * 
                 * Ejercicio 1: Desarrollo de un control de acceso con identificación del usuario basado en la función header().
                 */
                //https://www.php.net/manual/es/function.header.php
                /**
                 * @var array<string, string> $aUsuarios Array asociativo con los usuarios válidos, sus contraseñas nombres completos.
                 * La clave es el nombre de usuario y el valor es la contraseña y el nombre.
                 */
                
                $aUsuarios = [
                    "vero" => [password_hash('paso', "sha256"), "Véro Grué"],
                    "admin" => [password_hash('paso', "sha256"), "Juan López"],
                    "operadorweb" => [password_hash('paso', "sha256"), "Lucía Martin"]
                ];
                $pass = password_hash('paso',"sha256");
                //si no se han enviado las credenciales hay que pedir autenticación
                if (!isset($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'] )) {
                    header('WWW-Authenticate: Basic Realm="Contenido restringido"');
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Usuario no reconocido!";
                    //es obligatorio exit
                    exit;
                }
                //se comprueban las credenciales
                if (!array_key_exists($_SERVER['PHP_AUTH_USER'], $aUsuarios) || $aUsuarios[$_SERVER['PHP_AUTH_USER']][0] !== $_SERVER['PHP_AUTH_PW']) {
                    header('WWW-Authenticate: Basic Realm="Contenido restringido"');
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Credenciales incorrectas!";
                    //es obligatorio exit
                    exit;
                }
                ?>
            </section>
            <h2>Bienvenido/a, <?php echo $aUsuarios[$_SERVER['PHP_AUTH_USER']][1] ?> </h2>
            <p>Has iniciado sesión correctamente.</p>

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


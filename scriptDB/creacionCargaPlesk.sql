CREATE DATABASE IF  NOT EXISTS DBVGDWESProyectoTema5 ;
USE DBVGDWESProyectoTema5;
CREATE TABLE IF NOT EXISTS T_01Usuario (
                     T01_CodUsuario VARCHAR(15) PRIMARY KEY,
                     -- CodUsuario:8 letras maximo y 4 ninimo PK
                     T01_Password VARCHAR(256) NOT NULL ,
                     -- Password:8 letras maximo y 4 ninimo. Obligatorio
                     T01_DescUsuario VARCHAR(255),
                     --Alfanuemrico hasta 255 caracteres.Nombre y Apeliido del usuario. Obligatorio
                     T01_FechaHoraUltimaConexion DATETIME,
                     -- Fecha y hora de la ultima conexion del usuario. Valor automatico al conectarse. Obligatorio
                     T01_NumConexiones INT NOT NULL DEFAULT 1,
                     T01_Perfil VARCHAR(25) default 'usuario',
                     -- Valor usuario por defecto (podría ser usuario o adminsitrador). default (LOWER('usuario')
                     T01_ImagenUsuario MEDIUMBLOB default null)engine=innodb;
                     /*En este caso voy a guradar el nombre del archivo pero 
                     las fotos se puede guardar en la base de datos como tal, en este caso :
                     T01_ImagenUsuario BLOB, ( que serían fotos hastas 64KB)
                     T01_ImagenUsuario MEDIUMBLOB, ( que serían fotos hastas 16MB)
                     T01_ImagenUsuario LONGBLOB, ( que serían fotos hastas 4GB).*/


CREATE TABLE IF NOT EXISTS T_02Departamento (
                     T02_CodDepartamento VARCHAR(3) PRIMARY KEY, 
                     T02_DescDepartamento VARCHAR(255),
                     T02_FechaCreacionDepartamento datetime not null default now() ,
                     T02_VolumenDeNegocio FLOAT,
                     T02_FechaBajaDepartamento datetime default null)engine=innodb;
                     
                     

CREATE USER IF NOT EXISTS "userVGDWESProyectoTema5"@"%" IDENTIFIED by "paso";
GRANT ALL PRIVILEGES on *.* TO "userVGDWESProyectoTema5"@"%" WITH GRANT OPTION;
FLUSH PRIVILEGES;

USE DBVGDWESProyectoTema5;

INSERT INTO T_01Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_ImagenUsuario)
                VALUES
            ('vero',SHA2('paso',256),'Véro Grué',null),
            ('heraclio',SHA2('paso',256),'Heraclio Borbujo',null),
            ('alvaroA',SHA2('paso',256),'Alvaro Allen',null),
            ('alejandro',SHA2('paso',256),'Alejandro De La Huerga',null),
            ('alvaroG',SHA2('paso',256),'Alvaro García',null),
            ('gonzalo',SHA2('paso',256),'Gonzalo Junquera',null),
            ('cristian',SHA2('paso',256),'Cristian Mateos',null),
            ('alberto',SHA2('paso',256),'Alberto Méndez',null),
            ('enrique',SHA2('paso',256),'Enrique Nieto',null),
            ('james',SHA2('paso',256),'James Edward Nuñez',null),
            ('oscar',SHA2('paso',256),'Oscar Pozuelo',null),
            ('jesus',SHA2('paso',256),'Enrique Nieto',null),
            ('amor',SHA2('paso',256),'Amor Rodriguez',null),
            ('albertoB',SHA2('paso',256),'Alberto Bahillo',null)
;
            

/*INSERT INTO T_01Usuario (T01_CodUsuario,T01_Password,T01_NumConexiones,T01_FechaHoraUltimaConexion,T01_Perfil,T01_ImagenUsuario)
solo se inserta en los campos (T01_CodUsuario,T01_Password,T01_Perfil,T01_ImagenUsuario)
        T01_NumConexiones -  MySQL pone 0 (DEFAULT)
        T01_FechaHoraUltimaConexion -  queda NULL (usuario nunca se conectó)
        T01_ImagenUsuario - NULL hasta que subas una
*/

INSERT INTO T_02Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento)
                 VALUES 
            ('AUT','Automoción',now(),1285.50,NULL),
            ('AER','Aeronautica',now(),2285.50,NULL),
            ('DEF','Defensa',now(),3285.50,'2025-05-25');

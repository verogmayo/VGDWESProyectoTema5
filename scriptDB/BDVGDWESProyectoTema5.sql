CREATE DATABASE IF  NOT EXISTS DBVGDWESProyectoTema5 ;
USE DBVGDWESProyectoTema5;
CREATE TABLE IF NOT EXISTS T_01Usuario (
                     T01_CodUsuario VARCHAR(15) PRIMARY KEY,
                     T01_Password VARCHAR(256) NOT NULL,
                     T01_DescUsuario VARCHAR(255),
                     T01_FechaHoraUltimaConexion DATETIME,
                     T01_NumConexiones INT NOT NULL DEFAULT 1,
                     T01_Perfil VARCHAR(25) default 'usuario',
                     T01_ImagenUsuario MEDIUMBLOB default null)engine=innodb;
                    


CREATE TABLE IF NOT EXISTS T_02Departamento (
                     T02_CodDepartamento VARCHAR(3) PRIMARY KEY, 
                     T02_DescDepartamento VARCHAR(255),
                     T02_FechaCreacionDepartamento datetime not null default now() ,
                     T02_VolumenDeNegocio FLOAT,
                     T02_FechaBajaDepartamento datetime default null)engine=innodb;
                     
                     


USE DBVGDWESProyectoTema5;

INSERT INTO T_01Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_ImagenUsuario)
                VALUES
            ('vero',SHA2('veropaso',256),'Véro Grué',null),
            ('heraclio',SHA2('heracliopaso',256),'Heraclio Borbujo',null),
            ('alvaroA',SHA2('alvaroApaso',256),'Alvaro Allen',null),
            ('alejandro',SHA2('alejandropaso',256),'Alejandro De La Huerga',null),
            ('alvaroG',SHA2('alvaroGpaso',256),'Alvaro García',null),
            ('gonzalo',SHA2('gonzalopaso',256),'Gonzalo Junquera',null),
            ('cristian',SHA2('cristianpaso',256),'Cristian Mateos',null),
            ('alberto',SHA2('albertopaso',256),'Alberto Méndez',null),
            ('enrique',SHA2('enriquepaso',256),'Enrique Nieto',null),
            ('james',SHA2('jamespaso',256),'James Edward Nuñez',null),
            ('oscar',SHA2('oscarpaso',256),'Oscar Pozuelo',null),
            ('jesus',SHA2('jesuspaso',256),'Enrique Nieto',null),
            ('amor',SHA2('amorpaso',256),'Amor Rodriguez',null),
            ('albertoB',SHA2('albertoBpaso',256),'Alberto Bahillo',null),
            ('antonio',SHA2('antoniopaso',256),'Antonio Jañez',null)
;
            


INSERT INTO T_02Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento)
                 VALUES 
            ('INF','informática',now(),1285.50,NULL),
            ('LEN','Lengua',now(),2285.50,NULL),
            ('MAT','Matemáticas',now(),3285.50,'2025-05-25');


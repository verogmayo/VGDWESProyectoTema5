/*
Este cogido sql se ejecutará en el ide del entorno de desarrollo para cargar las tablas
En Netbeans se elije el conexion en la parte superior de la ventana del codigo y se hace clic en el icono de la base de datos amarilla y un flcha verde  */
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
            ('antonio',SHA2('antoniopaso',256),'Antonio Jañez',null),
            ('jorge',SHA2('jorgepaso',256),'Jorge Corral',null),
            ('claudio',SHA2('claudiopaso',256),'Claudio Lozano',null),
            ('gisela',SHA2('giselapaso',256),'Gisela Folgueral',null)
;
            

/*INSERT INTO T_01Usuario (T01_CodUsuario,T01_Password,T01_NumConexiones,T01_FechaHoraUltimaConexion,T01_Perfil,T01_ImagenUsuario)
solo se inserta en los campos (T01_CodUsuario,T01_Password,T01_Perfil,T01_ImagenUsuario)
        T01_NumConexiones -  MySQL pone 0 (DEFAULT)
        T01_FechaHoraUltimaConexion -  queda NULL (usuario nunca se conectó)
        T01_ImagenUsuario - NULL hasta que subas una
*/

INSERT INTO T_02Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento)
                 VALUES 
            ('INF','informática',now(),1285.50,NULL),
            ('LEN','Lengua',now(),2285.50,NULL),
            ('MAT','Matemáticas',now(),3285.50,'2025-05-25');


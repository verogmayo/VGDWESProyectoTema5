USE DBVGDWESProyectoTema5;

INSERT INTO T_01Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_ImagenUsuario)
                VALUES
            ('uservero','paso','Véro Grué',null),
            ('useraaa','paso','Mario Fernandez Lopez',null),
            ('userbbb','paso','María Gonzalez Martin',null);
            

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


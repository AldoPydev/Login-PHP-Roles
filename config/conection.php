<?php

// Clase de coneccion con base de datos

class Connection{
    private $host = 'localhost';
    private $dbname = 'loginroles';
    private $username = 'root';
    private $password = '';

    //funcion para la conexion 

    public function connect(){

        //Ferificar error de conexion
        try{

        /* PDO (PHP Data Objects) define una interfaz ligera y unificada para acceder a bases de datos. 
        para consultar y gestionar diferentes sistemas de gestión de bases de datos*/

            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                
            ];

            return new PDO($dsn, $this->username, $this->password, $options);

        } catch(\Throwable $th){
            echo "Error en la conexion" . $th->getMessage();
            exit;

        }

    }
}
<?php
    // Importar conexion a BD
    require_once '../config/conection.php';
    //Mantener inicion abierta
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'];
        // Encriptar password
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $rol_id = $_POST['rol_id'];

        try {
            //verificando conexion con BD
            $connection = new Connection();
            $pdo = $connection->connect();

            //Insertar datos en la BD 
            $sql = "INSERT INTO usuarios(username, password, rol_id) VALUES (:username, :password, :rol_id)";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([
                'username' => $username,
                'password' => $password,
                'rol_id' => $rol_id,
            ]);

            // Mensaje de creacion con exito

            echo "<script>
                alert('Usuario creado correctamente.');
                window.location.href = '../index.php';
                </script>";


        } catch (\Throwable $th) {
            //Error al crear usuario
            echo "<script>
            alert('Error al crear usuario: " . addslashes($th->getMessage()) . "');
            window.location.href = '../registro.php';
            </script>";
        }

    }
<?php
    // Importar conexion a BD
    require_once '../config/conection.php';
    //Mantener inicion abierta
    session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibir por medio de POST el usuario y password 
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //Verificar usuario existe en DB
    try {
        // Establecer conexion con BD
        $connection = new Connection();
        $pdo = $connection->connect();

        // Buscar y comparar usuario
        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $pdo->prepare( $sql );
        $stmt-> execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar los roles
        /* Si usuarioy verificacion de password son correctos
        de la tabla user tomamos id, username, rol_id */

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['rol_id'] = $user['rol_id'];

            /* Comparacion de rol 
                1 - Admin
                2 - moderador
                3 - usuario  */
            if($user['rol_id'] == 1){
                header('Location: ../Home/dashboard.php');
            }elseif ($user['rol_id'] == 3){
                header('Location: ../Home/dashboardUser.php');
            }else{
                echo 'Acceso Denegado';
            }
            exit();

        }else{
            $error_message = 'Credenciales Incorrectas';
        }

    } catch (\Throwable $th) {
        echo "Error en la conexion" . $th -> getMessage();
        exit; 
    }
}

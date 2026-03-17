<?php
    $user = $_POST["usuario"];
    $pass = $_POST["password"];

    $servurl = "http://localhost:3001/usuarios/$user/$pass";
    $curl = curl_init($servurl);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    if ($response === false) {
        header("Location: index.html?error=conexion");
        exit;
    }

    $resp = json_decode($response);

    // Si el microservicio devuelve al menos un usuario
    if (is_array($resp) && count($resp) != 0) {
        session_start();
        $_SESSION["usuario"] = $user;
        
        if ($user == "admin") { 
            header("Location: admin.php");
            exit;
        } 
        else { 
            header("Location: usuario.php");
            exit;
        } 
    }
    else {
        // Si el login falla (array vacío [])
        header("Location: index.html?error=datos_incorrectos"); 
        exit;
    }
?>
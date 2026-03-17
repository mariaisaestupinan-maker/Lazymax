<?php
$usuario = $_POST['usuario'];
$items = array();

foreach ($_POST['cantidad'] as $id => $cantidad) {
    if ($cantidad > 0) {
        $item['id'] = $id;
        $item["cantidad"] = $cantidad;
        array_push($items, $item);
    }
}

$orden['usuario'] = $usuario;
$orden['items'] = $items;
$json = json_encode($orden);

$url = 'http://localhost:3003/ordenes';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

// Redirección directa sin echos previos
header("Location: usuario.php");
exit;
?>
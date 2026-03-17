<?php
session_start();
if (!isset($_SESSION["usuario"])) { header("Location:index.html"); exit; }

$user = $_SESSION["usuario"];
// 1. Llamar al microservicio de PRODUCTOS (Puerto 3002)
$servurl = "http://localhost:3002/productos";
$curl = curl_init($servurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$productos = json_decode($response);
?>

<form action="procesar.php" method="POST">
    <input type="hidden" name="usuario" value="<?php echo $user; ?>">
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Inventario</th>
            <th>Cantidad</th>
        </tr>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?php echo $p->nombre; ?></td>
            <td>$<?php echo number_format($p->precio); ?></td>
            <td><?php echo $p->inventario; ?></td>
            <td>
                <input type="number" name="cantidad[<?php echo $p->id; ?>]" min="0" value="0">
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit">Agregar a la orden</button>
</form>
<?php
$servername = "localhost";
$username = "damian";
$password = "damian";
$dbname = "pokedex";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos
$sql = "SELECT id, nombre, tipo, altura, peso FROM pokemon";
$result = $conn->query($sql);

// Mostrar los datos en una tabla HTML
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Altura</th>
                <th>Peso</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                 <td>{$row['tipo']}</td>
                <td>{$row['altura']}</td>
                <td>{$row['peso']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay datos para mostrar.";
}

// Cerrar conexión
$conn->close();
?>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "damian";
$password = "damian";
$dbname = "pokedex";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar cURL para obtener la lista de los primeros 20 Pokémon
$ch = curl_init();
$url = 'https://pokeapi.co/api/v2/pokemon?limit=20';  // Obtener los primeros 20 Pokémon

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);

// Verificar si hubo un error en la solicitud
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "Error al conectarse a la API: $error_msg";
} else {
    curl_close($ch);

    // Decodificar la respuesta JSON
    $data = json_decode($response, true);

    // Verificar si la respuesta es válida
    if ($data) {
        // Recorrer la lista de los primeros 20 Pokémon
        foreach ($data['results'] as $pokemon) {
            // Obtener los detalles de cada Pokémon usando su URL
            $pokemon_url = $pokemon['url'];
            $pokemon_details = file_get_contents($pokemon_url);
            $pokemon_data = json_decode($pokemon_details, true);

            // Verificar si la respuesta de los detalles es válida
            if ($pokemon_data) {
                // Obtener los datos relevantes del Pokémon
                $pokemon_id = $pokemon_data['id']; // ID del Pokémon
                $pokemon_name = $pokemon_data['name'];
                $pokemon_type = $pokemon_data['types'][0]['type']['name'];
                $pokemon_height = $pokemon_data['height'];
                $pokemon_weight = $pokemon_data['weight'];

                // Consulta SQL para insertar los datos
                $sql = "INSERT INTO pokemon (id, nombre, tipo, altura, peso) VALUES ('$pokemon_id', '$pokemon_name', '$pokemon_type', '$pokemon_height', '$pokemon_weight')";

                // Ejecutar la consulta
                if ($conn->query($sql) === TRUE) {
                    echo "Datos del Pokémon $pokemon_name guardados correctamente.<br>";
                } else {
                    echo "Error al guardar los datos del Pokémon $pokemon_name: " . $conn->error . "<br>";
                }
            }
        }
    } else {
        echo "Error al obtener la lista de Pokémon.";
    }
}

// Cerrar la conexión
$conn->close();
?>

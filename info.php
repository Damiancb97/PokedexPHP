<?php 
    // Conexión a la BD
    $servername = "localhost";
    $username = "damian";
    $password = "damian";
    $dbname = "pokedex";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "BIENVENIDO A LA POKEDEX!!<br><br>";
    ?>

<?php
// URL base de la API
$base_url = 'https://pokeapi.co/api/v2/pokemon/';

for ($i = 1; $i < 152; $i++) {
    // Construir la URL de la API para cada Pokémon
    $url = $base_url . $i;

    // Inicializar cURL
    $ch = curl_init();

    // Configurar cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud cURL y almacenar la respuesta
    $response = curl_exec($ch);

    // Verificar si hubo un error en la solicitud cURL
    if(curl_errno($ch)) {
        echo 'Error en cURL: ' . curl_error($ch);
    } else {
        // Decodificar la respuesta JSON
        $pokemon_data = json_decode($response, true);

        // Comprobar si los datos fueron decodificados correctamente
        if ($pokemon_data) {
            echo "<img src='" . $pokemon_data['sprites']['front_default'] . "' alt='Imagen de " . $pokemon_data['name'] . "'><br>";
            echo "Número en pokedex: " . $pokemon_data['id'] . "<br>";
            echo "Nombre del Pokémon: " . $pokemon_data['name'] . "<br>";
            echo "Tipo de Pokémon: " . $pokemon_data['types'][0]['type']['name'] . "<br>";
            echo "Altura del Pokémon: " . $pokemon_data['height'] . " cm<br>";
            echo "Peso de Pokémon: " . $pokemon_data['weight'] . " kg<br><br>";
        } else {
            echo "Error al decodificar los datos de la API para el Pokémon ID: " . $i . "<br>";
        }
    }

    // Cerrar cURL
    curl_close($ch);
}
?>
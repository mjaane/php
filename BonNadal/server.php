<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bonnadal";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Recibir datos del formulario
    $name = htmlspecialchars($_POST["nom"]);
    $selectedLetters = isset($_POST['letters']) ? $_POST['letters'] : []; //Rebre leds

    // Preparar la consulta SQL con nombres de columnas en la consulta y los valores como parámetros
    $stmt = $conn->prepare("INSERT INTO leds (nom, letra) VALUES (?, ?)");
    
    // Preparar la declaración
    

    if($stmt) {
        foreach ($selectedLetters as $letter) {
            // Enlazar los parámetros de la consulta para evitar inyecciones SQL
            $stmt->bind_param("ss", $name, $letter);

            
            // Ejecutar la consulta y mostrar el resultado
            if (!$stmt->execute()) {
                $responseMessage = "Error al guardar los datos: " .$stmt->error;
            }
        }
        if (empty($responseMessage)){
           
        }
        // Cerrar la declaración
        $stmt->close();
    } else {
        $responseMessage = "Error en la preparacion de la consulta: " .$conn->error;
    }

    //Generar array
    $ledArrayBon = array_fill(0,64,0);
    $ledArrayNadal = array_fill(0, 64, 0);
    
    $letterMappingBon = [
        //Bon
        'B' => range(0, 11),
        'O' => range(12, 23),
        'N' => range(24, 35),
    ];

    $letterMappingNadal = [
        //Nadal
        'N' => range(0, 11),
        'A' => range(12, 24),
        'D' => range(25, 36),
        'A2' => range(36, 47),
        'L' => range(48, 63),
    ];

    foreach ($selectedLetters as $letter) {
       if (isset($letterMappingBon[$letter])) {
        foreach ($letterMappingBon[$letter] as $ledIndex) {
            $ledArrayBon[$ledIndex] = 1;
        }
       }
    }

    /*foreach ($selectedLetters as $letter) {
        if (isset($letterMappingNadal[$letter])) {
         foreach ($letterMappingNadal[$letter] as $ledIndex) {
             $ledArrayNadal[$ledIndex] = 1;
         }
        }
     }
    */
    $ledArrayBonString = implode(",", $ledArrayBon);
    //$ledArrayNadalString = implode(",", $ledArrayNadal);

    //Enviar array
    $esp32_bon_url = "http://192.168.193.102/?datos=$" . urldecode($ledArrayBonString);
    //$esp32_nadal_url = "http://192.168.193.10/?datos=$" . urldecode($ledArrayNadalString);

    $esp32ResponseBon = file_get_contents($esp32_bon_url);
    //$esp32ResponseNadal = file_get_contents($esp32_nadal_url);

    //Mensajes error
    if($esp32ResponseBon == FALSE) {
        $responseMessage = "Error al enviar datos al ESP32: " . curl_error($ch);
    } else {
    }
    /*
    if($esp32ResponseNadal == FALSE) {
        $responseMessage = "Error al enviar datos al ESP32: " . curl_error($ch);
    } else {
        $responseMessage = "Datos enviados correctamente al ESP32.";
    }
    */
    //Redirigir para evitar que se reenvie el formulario
    header("Location: index.php?msg=" . urlencode($responseMessage));
    exit(); //Se asegura que no se ejecuta todo el código
}

// Cerrar la conexión
$conn->close();
?>
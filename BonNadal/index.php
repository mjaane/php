<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Bon Nadal</title> 
</head>
<body>
    <div id="copos"></div>
    <form action="server.php" method="post">
        
        <h2>Bon nadal!</h2>

        <?php if (isset($_GET["msg"])) { ?>
            <p><?php echo htmlspecialchars($_GET["msg"]); ?></p>      
        <?php }?>


        <div class="input-wrapper">
            <input type="text"  name="nom" placeholder="Nom" required><br>
        </div>

        <div class="label-group letters-bon">
            <!-- Bon -->
            <label><input type="checkbox" name="letters[]" value="B"> B</label>
            <label><input type="checkbox" name="letters[]" value="O"> O</label>
            <label><input type="checkbox" name="letters[]" value="N"> N</label>
        </div>
        <div class="label-group letters-nadal">
             <!-- Nadal -->
             <label><input type="checkbox" name="letters[]" value="N"> N</label>
            <label><input type="checkbox" name="letters[]" value="A"> A</label>
            <label><input type="checkbox" name="letters[]" value="D"> D</label>
            <label><input type="checkbox" name="letters[]" value="A"> A</label>
            <label><input type="checkbox" name="letters[]" value="L"> L</label>
        </div>      

        
        <input class="btn" type="submit" name="submit" value="Enviar">
        
    </form>

    <!--Script copos de nieve -->
    <script>
        // Crear copos de nieve dinámicamente
        function createSnowflake() {
            const snowflake = document.createElement('div');
            snowflake.classList.add('copos');
            snowflake.textContent = '❄'; // Puedes usar diferentes símbolos: ❅ ❆ ❄
            
            // Posición horizontal aleatoria
            snowflake.style.left = Math.random() * 100 + 'vw';
            
            // Tamaño aleatorio
            snowflake.style.fontSize = Math.random() * 20 + 10 + 'px';
            
            // Duración de la caída
            const fallDuration = Math.random() * 5 + 5; // Entre 5 y 10 segundos
            snowflake.style.animationDuration = `${fallDuration}s`;

            // Añadir copo al contenedor
            document.getElementById('copos').appendChild(snowflake);

            // Eliminar el copo después de que desaparezca
            setTimeout(() => {
                snowflake.remove();
            }, fallDuration * 1000);
        }

        // Generar copos periódicamente
        setInterval(createSnowflake, 200); // Cada 200 ms
    </script>

</body>
</html>
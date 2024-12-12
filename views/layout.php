<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="La mejor cafetería de Madrid, con deliciosos cafés y tartas.">
    <title>CaféMadrid | <?php echo $titulo ?? ''; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Bona+Nova&family=Raleway:wght@700;900&family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>

    <?php echo $contenido; ?>
    
    <?php echo $script ?? ''; ?>
</body>
</html>
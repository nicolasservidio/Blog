<!--
 * ========================================================================
 * UNIVERSAL HEADER TEMPLATE — header.php
 * For PHP+MySQL MVC projects using Bootstrap
 * Author: Nicolás Servidio
 * ========================================================================
 * -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>
        <?php 
            echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'My Project'; 
        ?>
    </title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">  <!-- These paths will work correctly in both XAMPP and Railway, as long as the web server is configured to serve the "public/" folder as the document root -->

    <!-- Favicon -->
    <link rel="icon" href="assets/img/logo.png" type="image/png">
</head>

<body>

    <!-- HEADER -->
    <?php 
        include __DIR__ . '/header.php'; 
    ?>

    <!-- MAIN CONTAINER -->
    <main class="container py-4">
        <?php 
            if (isset($content)) echo $content; 
        ?>
    </main>

    <!-- FOOTER -->    
    <?php 
        include __DIR__ . '/footer.php'; 
    ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>

</body>
</html>

<!-- 
This file is a universal layout template for any free-framework PHP+MySQL project using MVC and OOP. You can copy it into:
- A blog
- A dashboard
- A portfolio
- An admin panel
- What you want
… and it will work without modification, as long as the documented folder structure is respected
-->

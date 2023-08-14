<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function randomString($n) {
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=identifiants_crud', 'root', '');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $numero = !empty($_POST['numero']) ? $_POST['numero'] : null;

    // Signal error
    if (!$prenom) {
        $errors[] = 'Your firstname is required';
    }
    if (!$nom) {
        $errors[] = 'Your name is required';
    }

    // Additional validations can be added here for prenom and nom fields
  
    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = null; // Initialize $imagePath

        if ($image/* && $image['error'] === UPLOAD_ERR_OK*/) {
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath), 0777, true); // Create directory recursively with proper permissions


            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $stmt = $pdo->prepare("INSERT INTO identifiants (prenom, image, nom, numero) 
            VALUES (:prenom, :image, :nom, :numero)");

        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Data inserted successfully
        } else {
            // Handle error if needed
        }
        header('Location: index.php');
        
    } 
}

?>

<!-- Rest of the HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Formulaire d'Identifiant</title>
</head>

<body>
    <h1>New Identified</h1>
    <?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) : ?>
        <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Your Image</label><br>
            <input type="file" name="image" accept="image/*">

        </div>
        <div class="mb-3">
            <label>Your Prenoun</label>
            <input type="text" class="form-control" name="prenom" placeholder="Votre prenom" required>
        </div>
        <div class="mb-3">
            <label>Your Noun</label>
            <input type="text" class="form-control" name="nom" placeholder="Votre nom" required>
        </div>
        <div class="mb-3">
            <label>Your Number</label>
            <input type="number" class="form-control" name="numero" placeholder="Votre numero" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Display the uploaded image -->
    <?php if (isset($imagePath)) : ?>
        <img src="http://localhost:8013/your_project_folder/<?php echo $imagePath; ?>" alt="Uploaded Image" width="200">
    <?php endif; ?>

</body>

</html>

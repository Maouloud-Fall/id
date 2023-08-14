<?php 
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=identifiants_crud', 'root', '');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $pdo->prepare('SELECT * FROM identifiants ORDER BY numero DESC');
    $statement->execute();
    $identifiants = $statement->fetchAll(PDO::FETCH_ASSOC);

    /*echo '<pre>';
    var_dump($identifians);
    echo '</pre>';*/

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Formulaire d'Idenfiant</title>
  </head>
  <body>
    <h1>Formulaire d'Idenfiant</h1>
    <p>
        <a href="create.php" class="btn btn-success">Identified</a>
    </p>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
                <th scope="col">Numero</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($identifiants as $i => $identifiant): ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td>
                        <img src="<?php echo $identifiants['image'] ?>" class="thumb-image">
                    </td>
                    <td><?php echo $identifiant['prenom'] ?></td>
                    <td><?php echo $identifiant['nom'] ?></td>
                    <td><?php echo $identifiant['numero'] ?></td>
                    <th>
                        <a href="update.php?id=<?php echo $paiement['id'] ?>" type="button" class="btn btn-sm btn-outline-primary">Edite</a>
                        <form method="post" action="delete.php" style="display: inline-block">
                            <input type="hidden" name="id" value="<?php echo $paiement['id'] ?>"/>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
  </body>
</html>
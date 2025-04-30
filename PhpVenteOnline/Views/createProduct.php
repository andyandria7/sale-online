<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation de Produit</title>
    <link rel="stylesheet" href="public/css/createProduct.css">
</head>

<body>

    <?php include "Layouts/header.php"; ?>


    <form action="index.php?action=createProduct" method="post" enctype="multipart/form-data">
        <?php
        if (isset($_GET['retour'])):
            switch ($_GET['retour']):
                case 'errorAll':
        ?>
                    <p class="erreur">Veuillez remplir tous les champs</p>
                <?php break;
                case 'errorImage':
                ?>
                    <p class="erreur">Veuillez choisir une image</p>

                <?php break;
                case 'errorUpload':
                ?>
                    <p class="erreur">Erreur lors de l'upload</p>

                <?php break;
                case 'success':
                ?>
                    <p class="success">Produit ajouté</p>

        <?php break;
                default:
                    echo '';
            endswitch;
        endif;
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);

        ?>
        <h1>Création de Produit</h1>
        <div class="corps">

            <label for="image">Image:</label>
            <input type="file" class="file" name="image">
            <label for="title">Titre:</label>
            <input type="text" placeholder="Entrer le titre" name="title" value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
            <label for="desc">Description:</label>
            <textarea name="description" id="desc"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
            <label for="price">Prix:</label>
            <input type="text" placeholder="Entrer le prix" name="price" value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">

            <button type="submit" name="valide">Valider</button>
        </div>
    </form>
    

    <?php include "Layouts/footer.php"; ?>



    <script src="public/js/modal.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des ventes</title>
    <link rel="stylesheet" href="public/css/product.css">
</head>

<body>
    <?php include "Layouts/header.php"; ?>

    <div class="container-card">
        <?php if (isset($products)): ?>

            <?php foreach ($products as $product):
               
            ?>
                    <form method="POST" action="index.php?action=product" class="card">
                        <img src="public/images/<?= isset($product->image) ? htmlspecialchars($product->image) : 'noImage.jpg' ?>"
                            alt="<?= htmlspecialchars($product->title); ?>"
                            class="card-img-top">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product->title); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product->description); ?></p>
                            <p class="card-text">Prix : <?= htmlspecialchars($product->price); ?> Ar</p>

                            <input type="hidden" name="product_id" value="<?= $product->idProd ?>">
                            <input type="number" class="item-quantity-input" name="quantite" value=<?=$_SESSION['panier'][ $product->idProd] ?? 0?> min="1" class="input-quantity">

                            <button type="submit" class="btn" name="ajouter_panier">Ajouter au panier</button>
                        </div>
                    </form>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit disponible.</p>
        <?php endif; ?>
    </div>

    <?php include "Layouts/footer.php"; ?>
    <script src="public/js/modal.js"></script>
</body>

</html>
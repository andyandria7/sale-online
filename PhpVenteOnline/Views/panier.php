<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="public/css/product.css">
</head>

<body>
    <?php include "Layouts/header.php"; ?>

    <section class="panier">
        <h2>Votre Panier</h2>
        <div id="cart-items">
            <?php if ($produits_panier) : ?>
                <form method="POST" action="index.php?action=payement">
                    <?php
                    $total = 0;
                    foreach ($produits_panier as $produit) :
                        $prix_total = $produit['price'] * $_SESSION['panier'][$produit['idProd']];
                        $total += $prix_total;
                    ?>
                        <div class="cart-item">
                            <div class="item-details">
                                <strong><?= htmlspecialchars($produit['title']); ?></strong>
                                <span class="item-price"><?= htmlspecialchars($produit['price']); ?> Ar</span>
                            </div>
                            <div class="item-actions">
                                <input type="number"
                                    class="item-quantity-input"
                                    data-id="<?= $produit['idProd']; ?>"
                                    data-price="<?= $produit['price']; ?>"
                                    value="<?= htmlspecialchars($_SESSION['panier'][$produit['idProd']]); ?>"
                                    min="1" hidden>
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?= $produit['idProd']; ?>">
                                    <input type="number" class="item-quantity" name="quantite" value="<?= $_SESSION['panier'][$produit['idProd']] ?? 1; ?>" min="1">
                                    <button type="submit">Modifier</button>
                                </form>
                                <span class="item-total"><?= number_format($prix_total, 0, ',', ' '); ?> Ar</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-summary">
                        <div class="total-section">
                            <strong>Total:</strong>
                            <span id="cart-total"><?= number_format($total, 0, ',', ' '); ?> Ar</span>
                        </div>
                        <div class="cart-actions">
                            <form action="" method="post">
                                <button type="submit" name="action" value="clear" class="cart-btn clear-btn">Tout Effacer</button>
                            </form>
                            <form method="POST" action="index.php?action=payement&connexion=1">

                                <button id="checkout-cart" name="commande" value="valid" class="cart-btn checkout-btn">Commander</button>
                            </form>
                        </div>
                    </div>
                </form>
            <?php else : ?>
                <p class="empty-cart">Votre panier est vide.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php include "Layouts/footer.php"; ?>
    <script src="public/js/modal.js"></script>
</body>

</html>
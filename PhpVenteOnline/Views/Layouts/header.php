<?php
require_once 'Controllers/PanierController.php';


$panier = new PanierController();
$total_items = $panier->getTotalItems();
$produits_panier = [];
$annonce = '';



if (!empty($_SESSION['panier'])) {
    $produits_panier = $panier->produitPanier();
}

if (isset($_POST['action']) && $_POST['action'] === 'clear') {
    $panier->clearProduct();
    $total_items = 0;
    $produits_panier = [];
}

if (isset($_POST['commande']) && $_POST['commande'] === 'valid') {
    if (!empty($_SESSION['panier'])) {
        header('Location: index.php?action=payement');
        exit();
    } else {
        $annonce = "Votre panier est vide !";
    }
}

if (isset($_POST['product_id'], $_POST['quantite'])) {
    $panier->addProduct($_POST['product_id'], $_POST['quantite']);
    $total_items = $panier->getTotalItems();
    $produits_panier = $panier->produitPanier();
}

if (isset($_SESSION['annonce'])) {
    $annonce = $_SESSION['annonce'];
    unset($_SESSION['annonce']);
}

?>
<header class="header">

    <div>
        <h1>VenteOnline</h1>
    </div>
    <?php
    if (isset($annonce)):
    ?>
        <p class="annonce"><?= $annonce ?></p>
    <?php
    endif;

    ?>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php?action=product">Produit</a></li>
            <!-- id="open-cart" -->
            <li><a href="index.php?action=panier">Panier <span id="cart-count"><?= isset($total_items) ? '(' . $total_items . ')' : ''; ?></span></a></li>
            <!-- Modale du panier -->
            <div id="cart-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Votre Panier</h2>
                    <div id="cart-items">
                        <?php if ($produits_panier) : ?>
                            <form method="POST" action="">
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
                </div>
            </div>
            <?php if (isset($_SESSION['username']) && $_SESSION['is_approved']) : ?>
                <li><a href="index.php?action=createProduct">Creation produit</a></li>
                <!-- <li><a href="#" id="open-cart"><?= htmlspecialchars($_SESSION['username']) ?> (<span id="cart-count"><?= $total_items; ?></span>)</a></li> -->


                <li><a href="index.php?action=logout">Deconnexion</a></li>
            <?php elseif (isset($_SESSION['username']) && !$_SESSION['is_approved']) : ?>
                <p>En attente de validation</p>
                <li><a href="index.php?action=logout">Deconnexion</a></li>

            <?php else : ?>
                <li><a href="index.php?action=login">Login</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payement</title>
    <link rel="stylesheet" href="public/css/payement.css">
</head>

<body>
    <?php include "Layouts/header.php"; ?>

    <main>
        <div class="payment-container">
            <div class="payment-header">
                <h2>Finaliser votre commande</h2>
            </div>

            <form method="POST" action="index.php?action=valider" class="payment-content">
                

                <div class="payment-form">
                    <h3>Informations de paiement</h3>

                    <div class="form-group">
                        <label for="name">Nom sur la carte</label>
                        <input class="inp" type="text" id="name" placeholder="Carte" required>
                    </div>

                    <div class="card-details">
                        <div class="card-icons">
                            <div class="card-icon">VISA</div>
                            <div class="card-icon">PayPal</div>
                        </div>

                        <div class="form-group">
                            <label for="card-number">Numéro de carte</label>
                            <input class="inp" type="text" id="card-number" placeholder="1234 5678 90" required>
                        </div>

                        <div class="input-group">
                            <div class="form-group">
                                <label for="expiry">Date d'expiration</label>
                                <input class="inp" type="text" id="expiry" placeholder="MM/AA" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input class="inp" type="text" id="cvv" placeholder="123" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email pour le reçu</label>
                        <input class="inp" type="email" id="email" placeholder="email@exemple.com" required>
                    </div>

                    <div class="order-summary">
                        <h3>Résumé de la commande</h3>
                        <?php if ($produits_panier) : ?>
                            <?php
                            $total = 0;
                            foreach ($produits_panier as $produit) :
                                $prix_total = $produit['price'] * $_SESSION['panier'][$produit['idProd']];
                                $total += $prix_total;
                            ?>
                                <div class="summary-item">
                                    <span><?= htmlspecialchars($produit['title']); ?></span>
                                    <span><?= htmlspecialchars($_SESSION['panier'][$produit['idProd']]);  ?></span>
                                    <span><?= number_format($prix_total, 0, ',', ' '); ?> Ar</span>
                                </div>

                            <?php endforeach; ?>
                            <div class="summary-item summary-total">
                                <span>Total:</span>
                                <span id="cart-total"><?= number_format($total, 0, ',', ' '); ?> Ar</span>
                            </div>
                        <?php endif; ?>
                        
                    </div>

                    <button type="submit" class="payment-button" name="payer">Payer maintenant</button>

                    <div class="security-text">
                        <span>🔒</span>
                        <span>Paiement sécurisé - Vos données sont protégées</span>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php include "Layouts/footer.php"; ?>

    <script src="public/js/modal.js"></script>

</body>

</html>
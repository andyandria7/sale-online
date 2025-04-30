<?php
require_once 'models/Database.php';

class PanierController
{
    public function produitPanier()
    {
        
        

        if (empty($_SESSION['panier'])) {
            return [];
        }



        $database = new Database();
        $bdd = $database->getBdd();

        $ids = array_keys($_SESSION['panier']);

        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $bdd->prepare("SELECT idProd, title, price FROM product WHERE idProd IN ($placeholders)");

        try {
            $stmt->execute($ids);
            $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($produits as &$produit) {
                $produit['quantity'] = $_SESSION['panier'][$produit['idProd']];
            }

            return $produits;
        } catch (PDOException $e) {
            error_log("Erreur de récupération des produits du panier: " . $e->getMessage());
            return [];
        }
    }

    public function clearProduct()
    {
        unset($_SESSION['panier']);
    }

    public function addProduct($product_id, $quantite)
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $quantite = (int)$quantite;

    
    if ($quantite > 0) {
        $_SESSION['panier'][$product_id] = $quantite; 
    } else {
        unset($_SESSION['panier'][$product_id]);
    }
}

    public function getTotalItems()
    {
        return isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0;
    }
    public function updateCart($quantites) {
        foreach ($quantites as $product_id => $quantite) {
            if ($quantite > 0) {
                $_SESSION['panier'][$product_id] = $quantite;
            } else {
                unset($_SESSION['panier'][$product_id]); 
            }
        }
    }

    public function payer() {
        $this->clearProduct();
        $_SESSION['annonce'] = "Merci pour votre commande !";
        header("Location: index.php");
        exit();
    }
    
}

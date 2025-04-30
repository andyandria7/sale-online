<?php
session_start();
require_once("Controllers/LoginController.php");
require_once("Controllers/ProductController.php");
require_once("Controllers/PanierController.php");

$panier = new PanierController();

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        include 'Views/login.php';
        if (isset($_POST['login'])) {
            $login = new LoginController();
            $login->login($_POST['username'], $_POST['pass']);
        }
    } elseif ($_GET['action'] == 'register') {
        include 'Views/register.php';
        if (isset($_POST['insert'])) {
            $user = new LoginController();
            $user->register($_POST['name'], $_POST['username'], $_POST['email'], $_POST['pass'], $_POST['passV']);
        }
    } else if ($_GET['action'] == 'product') {
        $product = new ProductController();
        $products = $product->index();
        include 'Views/product.php';
    } elseif ($_GET['action'] == 'createProduct') {
        include 'Views/createProduct.php';
        if (isset($_POST['valide'])) {
            $product = new ProductController();
            $product->create($_POST['title'], $_POST['description'], $_POST['price'], $_FILES);
        }
    } elseif ($_GET['action'] == 'logout') {
        session_destroy();
        header('Location: index.php');
        exit();
    } elseif ($_GET['action'] == 'payement') {
        if (!empty($_SESSION['username'])) {
            include 'Views/payement.php';
        } else {
            $redirection = isset($_GET['connexion']) ? 'payement' : 'acceuil';
            header("Location: index.php?action=login&redirect=$redirection");
        }
    } elseif ($_GET['action'] == 'acceuil') {
        include('Views/home.php');
    } elseif (isset($_POST['update_cart'])) {
        $panier->updateCart($_POST['quantite']);
        $total_items = $panier->getTotalItems();
        $produits_panier = $panier->produitPanier();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'valider') {
        $panier = new PanierController();
        $panier->payer();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'panier'){
        include ('Views/panier.php');
        
    }
} else {

    include('Views/home.php');
}

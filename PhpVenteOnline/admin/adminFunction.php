<?php
    function listeUser(){
        global $bdd;
        $user = $bdd->query('SELECT * FROM login WHERE is_approved = TRUE');
        $aff = $user->fetchAll();
        return $aff;
    }

    function listeProductApprove(){
        global $bdd;
        // $product = $bdd->query('SELECT * FROM product WHERE is_approved = TRUE');
        $product = $bdd->query('SELECT product.*, login.name, login.username FROM product INNER JOIN login ON product.idLogin = login.id WHERE product.is_approved = TRUE' );

        $aff = $product->fetchAll();
        return $aff;
    }

  

    function listeUserAll(){
        global $bdd;
        $user = $bdd->query('SELECT * FROM login ORDER BY id DESC');
        $aff = $user->fetchAll();
        return $aff;
    }

    function listeProduct(){
        global $bdd;
        // $product = $bdd->query('SELECT * FROM product ORDER BY idProd DESC');
        // $aff = $product->fetchAll();


        // return $aff;

        $product = $bdd->query('SELECT product.idProd, product.image, product.title, product.description, product.price, login.name, login.username FROM product INNER JOIN login ON product.idLogin = login.id');
        $aff = $product->fetchAll();
        return $aff;
    }

    function approveProduct($productId) {
        global $bdd;
        $stmt = $bdd->prepare('UPDATE product SET is_approved = TRUE WHERE idProd = :id');
        $stmt->execute(['id' => $productId]);
        header("Location: ./admin.php");
    }

    function desapproveProduct($productId){
        global $bdd;
        $stmt = $bdd->prepare('UPDATE product SET is_approved = FALSE WHERE idProd = :id');
        $stmt->execute(['id' => $productId]);
        header("Location: ./admin.php");
    }

    function approveUser($userId) {
        global $bdd;
        $stmt = $bdd->prepare('UPDATE login SET is_approved = TRUE WHERE id = :id');
        $stmt->execute(['id' => $userId]);

        if (isset($_SESSION['id']) && $_SESSION['id'] == $userId) {
            $_SESSION['is_approved'] = true;
        }

        header("Location: ./admin.php");
    }

    function desapproveUser($userId){
        global $bdd;
        $stmt = $bdd->prepare('UPDATE login SET is_approved = FALSE WHERE id = :id');
        $stmt->execute(['id' => $userId]);

        if (isset($_SESSION['id']) && $_SESSION['id'] == $userId) {
            $_SESSION['is_approved'] = false;
        }
        header("Location: ./admin.php");

    }

    function deleteUser($userId) {
        global $bdd;
        $stmt = $bdd->prepare('DELETE FROM login WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        header("Location: ./admin.php");
    }

    function deleteProduct($productId) {
        global $bdd;
        $stmt = $bdd->prepare('DELETE FROM product WHERE idProd = :id');
        $stmt->execute(['id' => $productId]);
        header("Location: ./admin.php");
    }


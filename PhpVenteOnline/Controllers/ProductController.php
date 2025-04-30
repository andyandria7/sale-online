<?php
require_once("models/ProductModel.php");
class ProductController
{
    // public function create($data, $files)
    public function create($title, $description, $price, $files)
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?action=login');
            exit();
        }
        // $title = htmlspecialchars(trim($data['title']));
        // $description = htmlspecialchars(trim($data['description']));
        // $price = intval($data['price']);
        
        $user_id = $_SESSION['id'];
        $validation = true;


        // if (!empty($title) || !empty($description) || $price >= 0) {
        //     if (!empty($files['image']['name']) || $files['image']['error'] === UPLOAD_ERR_OK) {
        //         $img = $this->uploadImage($files['image']);

        //         if (!$img) {
        //             header('Location: index.php?action=createProduct&retour=errorUpload');
        //             exit();
        //         } else {
        //             $validation = true;
        //         }
        //     } else {
        //         $validation = false;
        //         header('Location: index.php?action=createProduct&retour=errorImage');
        //     }
        // } else {
        //     $validation = false;
        //     header('Location: index.php?action=createProduct&retour=errorAll');
        // }

        // if($validation) {
        //     $product = new ProductModel($img, $title, $description, $price, $user_id);
        //     $product->createProduct($img, $title, $description, $price, $user_id);
        //     header('Location: index.php?action=createProduct&retour=success');
        //     exit();
        // }


        if (empty($title) || empty($description) || $price <= 0) {

            header('Location: index.php?action=createProduct&retour=errorAll');
            exit();
        }
        if (empty($files['image']['name']) || $files['image']['error'] !== UPLOAD_ERR_OK) {
            header('Location: index.php?action=createProduct&retour=errorImage');
            exit();
        }

        $img = $this->uploadImage($files['image']);

        if (!$img) {
            header('Location: index.php?action=createProduct&retour=errorUpload');
            exit();
        }

        $product = new ProductModel($img, $title, $description, $price, $user_id);
        $product->createProduct($img, $title, $description, $price, $user_id);

        header('Location: index.php?action=createProduct&retour=success');
        exit();
    }

    public function index()
    {
            
        // include 'views/product.php';
        $productModel = new ProductModel("", "", "", "", "");
        $products = $productModel->readAll();
        
        return $products;
    }

    private function uploadImage($file)
    {
        $types = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $types) || $file['size'] > $maxSize) {
            return false;
        }

        $upload = 'public/images/';
        $imageName = uniqid() . "_" . basename($file['name']);
        $imagePath = $upload . $imageName;

        if (move_uploaded_file($file['tmp_name'], $imagePath)) {
            return $imageName;
        }

        return false;
    }

   
}

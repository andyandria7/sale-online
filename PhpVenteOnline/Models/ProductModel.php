<?php
require_once 'Database.php';

class ProductModel{
    private $image;
    private $title;
    private $description;
    private $price;
    private $user_id;
    private $bdd;

    public function __construct($image, $title, $description, $price, $user_id){
        $database = new Database();
        $this->bdd = $database->getBdd();
        $this->setImage($image);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->user_id = intval($user_id);
    }

    public function setImage($image){
        $this->image = trim($image);
    }
    public function setTitle($title){
        $this->title = trim(ucwords($title));
    }
    public function setDescription($description){
        $this->description = trim(ucwords($description));
    }
    public function setPrice($price){
        $this->price = intval($price);
    }
    public function createProduct($image, $title, $description, $price, $user_id)
    {
        $req = $this->bdd->prepare('INSERT INTO product (image, title, description, price, idLogin) VALUES (?, ?, ?, ?, ?)');
        $req->execute([$image, $title, $description, $price, $user_id]);
    }
    public function readAll()
    {
        $req = $this->bdd->query('SELECT * FROM product WHERE is_approved = TRUE');
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function readOne($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM product WHERE idLogin = ?');
        $req->execute([$id]);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
}
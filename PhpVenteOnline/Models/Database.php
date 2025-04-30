<?php
    class Database{
        private $bdd;
        public function __construct(){
            try{
                $this->bdd = new PDO('mysql:host=localhost;dbname=vente','root','');
                $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e){  
                echo "Error: " . $e->getMessage();
            }
        }

        public function getBdd(){
            return $this->bdd;
        }
    }
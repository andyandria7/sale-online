<?php
require_once 'Database.php';
class LoginModel
{
    private $name;
    private $username;
    private $email;
    private $password;
    private $bdd;

    public function __construct($name, $username, $email, $password)
    {
        $database = new Database();
        $this->bdd = $database->getBdd();
        $this->setName($name);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPass($password);
    }

    public function setName($name)
    {
        $this->name = trim(strtoupper($name));
    }

    public function setUsername($username)
    {
        $username = strtolower($username);
        $this->username = trim(ucwords($username));
    }

    public function setEmail($email)
    {
        $this->email = trim($email);
    }

    public function setPass($password)
    {
        $this->password = password_hash(trim($password), PASSWORD_DEFAULT);
    }

    public function isEmailExists($email)
    {
        $req = $this->bdd->prepare('SELECT id FROM login WHERE email = ?');
        $req->execute([$email]);
        return $req->rowCount() > 0;
    }

    public function save($name, $username, $email, $password)
    {
        $req = $this->bdd->prepare('INSERT INTO login(name, username, email, password) VALUES(?, ?, ?, ?)');
        $req->execute(array($name, $username, $email, $password));
        $user = $req->fetch();
        return var_dump($user);
    }
    public function login($email, $password)
    {
        $req = $this->bdd->prepare('SELECT * FROM login WHERE email = ?');
        $req->execute([$email]);
        $user = $req->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function read($id){
        $req = $this->bdd->prepare('SELECT * FROM login WHERE id = ?');
        $req->execute(array($id));
        return $req->fetch(PDO::FETCH_OBJ);
    }

    // public function delete($id){
    //     $req = $this->bdd->prepare('DELETE FROM login WHERE id = ?');
    //     $req->execute(array($id));
    // }
    // public function selectAll(){
    //     $req = $this->bdd->prepare('SELECT * FROM login');
    //     return $req->fetchAll(PDO::FETCH_OBJ);
    // }
    // public function update($name, $username, $email, $password, $id){
    //     $req = $this->bdd->prepare('UPDATE login SET name = ?, username = ?, email = ?, password = ? WHERE id = ?');
    //     $req->execute([$name, $username, $email, $password, $id]);
    // }

}

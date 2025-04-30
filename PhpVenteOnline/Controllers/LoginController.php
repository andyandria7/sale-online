<?php
require_once("models/loginModel.php");

class LoginController
{
    public function register($name, $username, $email, $pass, $passV)
    {

        $name = htmlspecialchars(trim($name));
        $username = htmlspecialchars(trim($username));
        $email = htmlspecialchars(trim($email));
        $pass = $_POST['pass'];
        $passV = $_POST['passV'];
        $erreur = array();
        if (!empty($name) && !empty($username) && !empty($email) && !empty($pass) && !empty($passV)) {
            require_once("models/loginModel.php");
            $user = new LoginModel($name, $username, $email, $pass);
            if (!($user->isEmailExists($email))) {
                if ($pass == $passV) {
                    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
                    $user->save($name, $username, $email, $pass_hash);
                    // $_SESSION['flash_success'] = "Inscription réussie ! Veuillez vous connecter";
                    // header('Location: index.php?action=register&retour=validation');
                    $this->login($email, $pass);
                } else {
                    // $erreur[] = "Les mots de passe ne correspondent pas.";
                    
                    header('Location: index.php?action=register&retour=pass');
                }
            } else {
                // $erreur[] = "Email deja existant";
                header('Location: index.php?action=register&retour=mail');
            }
        } else {
            // $erreur[] = "Veuillez remplir tous les champs";
            header('Location: index.php?action=register&retour=erreur');
        }
        // $_SESSION['flash_errors'] = $erreur;
    }

    public function login($email, $pass)
    {
        $email = htmlspecialchars(trim($email));
        $pass = $_POST['pass'];
        $user = new LoginModel("", "", $email, $pass);
        $userData = $user->login($email, $pass);
        if ($userData) {
            if (isset($userData['is_approved'])) {
                $_SESSION['id'] = (int) $userData['id'];
                $_SESSION['username'] = $userData['username'];
                $_SESSION['email'] = $userData['email'];
                $_SESSION['is_approved'] = $userData['is_approved'];

                unset($_SESSION['pass']);

                $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'acceuil';
                header("Location: index.php?action=$redirect");
            }
        } else {
            if (isset($_GET['redirect'])){
                header('Location: index.php?action=login&retour=error&redirect=payement');

            } else{
                header('Location: index.php?action=login&retour=error');

            }
        }
    }
}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="public/css/register.css">
</head>

<body>
    <section>
        <form action="" method="post">
           <?php 
            if(isset($_GET['retour'])):
                switch($_GET['retour']) :
                    case 'erreur':
           ?>
                <p class="erreur">Veuillez remplir tous les champs</p>
            <?php break; 
                    case 'mail':
             ?>
                <p class="erreur">Email deja utilise</p>
            <?php break; 
                    case 'pass':
            ?>
                    <p class="erreur">Les mots de passe ne correspondent pas.</p>
            <?php break;
                    case 'validation':
            ?>
                        <p class="success">Inscription réussie ! Veuillez vous connecter</p>
            <?php break;
                    default:
                    echo '';
                endswitch;    
            endif;
            ?>
            <h1>Créer un compte</h1>

            <div class="input-group">
                <label for="name">Nom</label>
                <input type="text" class="form-input" id="name" name="name" placeholder="Entrez votre nom">
            </div>

            <div class="input-group">
                <label for="username">Prénom</label>
                <input type="text" class="form-input" id="username" name="username" placeholder="Entrez votre prénom">
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" class="form-input" id="email" name="email" placeholder="Entrez votre adresse email">
            </div>

            <div class="input-group">
                <label for="pwd">Mot de passe</label>
                <input type="password" class="form-input" id="pwd" name="pass" placeholder="Créez votre mot de passe">
            </div>

            <div class="compte">
                <input type="checkbox" id="eyePwd">
                <label for="eyePwd">Afficher le mot de passe</label>
            </div>

            <div class="input-group">
                <label for="passV">Confirmation du mot de passe</label>
                <input type="password" class="form-input" id="passV" name="passV" placeholder="Confirmez votre mot de passe">
            </div>

            <div class="compte">
                <input type="checkbox" id="eyePassV">
                <label for="eyePassV">Afficher le mot de passe</label>
            </div>

            <div>
                <p>Vous avez déjà un compte? <a href="index.php?action=login">Se connecter</a></p>
            </div>

            <div>
                <a href="index.php" class="reset">Annuler</a>
                <button type="submit" class="log-in" name="insert">S'inscrire</button>
            </div>
        </form>
    </section>

    <script src="public/js/register.js"></script>


</body>

</html>
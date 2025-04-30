<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="public/css/login.css">
</head>

<body>
    <section>
        <form action="" method="post">
            <?php
            if (isset($_GET['retour'])):
                if ($_GET['retour'] == 'error'):
            ?>
                    <p class="erreur">Erreur de connexion</p>
                <?php elseif ($_GET['retour'] == 'connexion'):
                ?>
                    <p class="success">Veuillez vous connecter</p>

            <?php
                endif;
            endif;
            ?>
            <h1>Connexion</h1>
            <section>
                <div class="input-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-input" id="username" name="username" placeholder="Entrez votre adresse email">
                </div>

                <div class="input-group">
                    <label for="pwd">Mot de passe</label>
                    <input type="password" class="form-input" id="pwd" name="pass" placeholder="Entrez votre mot de passe">
                </div>

                <div class="compte">
                    <input type="checkbox" id="eye">
                    <label for="eye">Afficher le mot de passe</label>
                </div>

                <div class="compte">
                    <?php if (isset($_GET['redirect'])): ?>
                        <p class="btn submits sign-up">Vous n'avez pas de compte? <a href="index.php?action=register&redirect=payement">S'inscrire</a></p>
                    <?php else : ?>
                        <p class="btn submits sign-up">Vous n'avez pas de compte? <a href="index.php?action=register">S'inscrire</a></p>
                    <?php endif; ?>
                </div>

                <div>
                    <a href="index.php" class="reset">Annuler</a>
                    <button type="submit" class="log-in" name="login">Se connecter</button>
                </div>
            </section>
        </form>
    </section>

    <script src="public/js/login.js"></script>
</body>

</html>
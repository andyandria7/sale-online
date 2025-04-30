<?php
session_start();
require '../Models/Database.php';
include 'adminFunction.php';
$database = new Database();
$bdd = $database->getBdd();
$listeUser = listeUser();
$listeProduct = listeProduct();
$allUser = listeUserAll();
$listeProductApprove = listeProductApprove();
if (isset($_GET['approve'])) {
    approveUser($_GET['approve']);
}
if (isset($_GET['desapprove'])) {
    desapproveUser($_GET['desapprove']);
}
if (isset($_GET['delete'])) {
    deleteUser($_GET['delete']);
}
if (isset($_GET['approveProduct'])) {
    approveProduct($_GET['approveProduct']);
}
if (isset($_GET['desapproveProduct'])) {
    desapproveProduct($_GET['desapproveProduct']);
}
if (isset($_GET['deleteProduct'])) {
    deleteProduct($_GET['deleteProduct']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="header">
        <div class="navigation">
            <header>
                <div>
                    <h1>Admin</h1>
                </div>
                <button id="user">
                    <h3>Liste des utilisateurs</h3>
                </button>
                <button id="product">
                    <h3>Liste des Produits</h3>
                </button>
                <button id="vUser">
                    <h3>Validation des utilisateurs</h3>
                </button>
                <button id="vProduct">
                    <h3>Validation des Produits</h3>
                </button>

            </header>
        </div>
        <section class="left">
            <div class="navigation2">
                <div class="deco">
                    <a href="../index.php">Deconnexion</a>
                </div>
            </div>
            <div class="content">
                <section class="lstUser">
                    <?php if (!isset($listeUser)) : ?>
                        <p>Pas d'utilisateur</p>
                    <?php else : ?>
                        <table>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($listeUser as $user) : ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <!-- <td>
                                        <a href="?desapprove=<?= $user['id'] ?>">Supprimer</a>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>

                </section>
                <section class="lstProduct">
                    <?php if (!isset($listeProductApprove)) : ?>
                        <p>Pas de produit</p>
                    <?php else : ?>
                        <table>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Créé par</th>

                            </tr>
                            <?php foreach ($listeProductApprove as $product) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['idProd']); ?></td>
                                    <td><img src="../public/images/<?php echo htmlspecialchars($product['image']); ?>" width="50"></td>
                                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td><?php echo htmlspecialchars($product['price']); ?> Ar</td>
                                    <td><?php echo htmlspecialchars($product['name']) . " " . htmlspecialchars($product['username']) . ""; ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    <?php endif; ?>

                </section>
                <section class="valUser">
                    <?php if (!isset($allUser)) : ?>
                        <p>Pas d'utilisateur</p>
                    <?php else : ?>
                        <table>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach ($allUser as $user) : ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <a href="?approve=<?= $user['id'] ?>">Approuver</a>
                                        <a href="?desapprove=<?= $user['id'] ?>">Desapprouver</a>
                                        <a href="?delete=<?= $user['id'] ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </section>
                <section class="valProduct">
                    <?php if (!isset($listeProduct)) : ?>
                        <p>Pas de produit a valider</p>

                    <?php else : ?>
                        <table>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Créé par</th>
                                <th>Actions</th>

                            </tr>
                            <?php foreach ($listeProduct as $product) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['idProd']); ?></td>
                                    <td><img src="../public/images/<?php echo htmlspecialchars($product['image']); ?>" width="50"></td>
                                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td><?php echo htmlspecialchars($product['price']); ?> Ar</td>
                                    <td><?php echo htmlspecialchars($product['name']) . " " . htmlspecialchars($product['username']) . ""; ?></td>
                                    <td>
                                        <a href="?approveProduct=<?= $product['idProd'] ?>">Approuver</a>
                                        <a href="?desapproveProduct=<?= $product['idProd'] ?>">Desapprouver</a>
                                        <a href="?deleteProduct=<?= $product['idProd'] ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    <?php endif; ?>
                </section>
            </div>
        </section>

    </div>

    <script src="admin.js"></script>
</body>

</html>
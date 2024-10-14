<?php require_once('header.php'); ?>

<form action="POST">
    <input type="text" name="mail" value="" placeholder="Email du compte">
    <input type="password" name="mdp" value="" placeholder="Mot de passe du compte">
    <input type="text" name="pseudo" value="" placeholder="Pseudo du compte">

    <button type="submit" name="btn-creer">Créer</button>
    <button type="submit" name="btn-modifier">Modifier</button>
    <button type="submit" name="btn-supprimer">Supprimer</button>
</form>
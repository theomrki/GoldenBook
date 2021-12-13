<?php

require_once 'src/Message.php';
require_once 'src/GuestBook.php';
$errors = null;
$success = false;
$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'message');

if (isset($_POST['username'], $_POST['message'])) {
    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isValid()) {
        $guestbook->addMessage($message);
        $success = true;
        $_POST = [];
    } else {
        $errors = $message->getErrors();
    }
}
$messages = $guestbook->getMessages();
$title = "Livre d'or";
require 'elements/header.php';
?>

<div class="container">
    <h1>Livre d'or</h1>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            Formulaire invalide
        </div>
    <?php endif ?>

    <?php if ($success) : ?>
        <div class="alert alert-success">
            Merci pour votre message !
        </div>
    <?php endif ?>


    <form action="" method="post">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '') ?>" type="text" name="username" placeholder="Votre pseudo" class="form-control" <?= isset($errors['username']) ? 'is-invalid' : '' ?>>
            <?php if (isset($errors['username'])) : ?>
                <div class="invalid-feedback">
                    <?= $errors['username'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <input value="<?= htmlentities($_POST['message'] ?? '') ?>" type="text" name="message" placeholder="Votre message" class="form-control" <?= isset($errors['message']) ? 'is-invalid' : '' ?>>
            <?php if (isset($errors['message'])) : ?>
                <div class="invalid-feedback">
                    <?= $errors['message'] ?>
                </div>
            <?php endif ?>
        </div>
        <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if (!empty($messages)) : ?>
        <h1 class="mt-4">Vos messages</h1>
        <?php foreach ($messages as $message) : ?>
            <?= $message->toHTML() ?>
        <?php endforeach ?>
    <?php endif ?>

</div>

<?php
require 'elements/footer.php';
?>
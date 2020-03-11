<?php require_once 'header.php' ?>
<div class="container login">
    <form class="login login_page" action="<?= $this->path ?>login/entry" method="post">
        <h3 class="login_h3 login_page">Логин</h3>
        <input class="login_input form-control" type="login" name="login" size="30" placeholder="Логин" required>
        <input class="login_input form-control" type="password" name="password" size="30" placeholder="Пароль" required>
        <input class="submit btn btn-info" type="submit" value="Войти">
        <p class="login_error"><?= $this->getError() ?></p>
        <p class="login_p">Ещё нет аккаунта? <a class="login_a"
                                                href="<?= $this->path ?>registration">Зарегистрируйтесь!</a></p>
    </form>
</div>
<?php require_once 'footer.php' ?>
</body>
</html>
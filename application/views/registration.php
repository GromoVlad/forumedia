<?php require_once 'header.php' ?>
<div class="container registration">
    <form action="<?= $this->path ?>registration/create" class="reg" enctype="multipart/form-data"  method="post">
        <h3 class="reg_h3">Регистрация</h3>
        <input class="reg_input form-control" type="text" name="login" size="30" minlength="5" placeholder="Логин (обязательно)"
               required value="<?= $this->getValueInput('login') ?>">
        <input class="reg_input form-control" type="password" name="password" size="30" minlength="6"
               placeholder="Пароль (обязательно)" required>
        <input class="reg_input form-control" type="password" name="passwordReplay" size="30" minlength="6"
               placeholder="Повторите пароль (обязательно)" required>
        <input class="reg_input form-control" type="email" name="email" size="30" placeholder="E-mail (обязательно)"
               required value="<?= $this->getValueInput('email') ?>">
        <input class="reg_input form-control" type="text" name="name" size="30" minlength="3" placeholder="Ваше Имя"
               value="<?= $this->getValueInput('name') ?>">
        <input class="reg_input form-control" type="text" name="surname" size="30" minlength="3" placeholder="Ваша Фамилия">
        <input class="reg_input form-control" type="tel" name="phone" placeholder="Мобильный Телефон (обязательно)" id="phone"
               required>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="photo" accept="image/png, image/jpeg, image/gif" id="customFile">
            <label class="custom-file-label" for="customFile">Ваше Фото</label>
        </div>
        <input class="reg_input form-control" type="text" name="address" size="30" placeholder="Ваш Адрес"
               value="<?= $this->getValueInput('address') ?>">
        <input class="submit btn btn-info" type="submit" value="Регистрация">
        <p class="reg_error"><?= $this->getAllErrors() ?></p>
        <p class="reg_p">Уже зарегистрированы? <a class="reg_a" data-toggle="modal"
                                                  data-target="#exampleModal">Войдите!</a></p>
    </form>
</div>
<?php require_once 'footer.php' ?>
<script src="<?= $this->path ?>data/js/jquery.maskedinput.js"></script>
<script src="<?= $this->path ?>data/js/registration.js"></script>
</body>
</html>
<?php require_once 'header.php' ?>
<div class="container flex-container">
    <div class="flex-rows low_range">
        <h3 class="list_users">Список пользователей</h3>
        <div class="surname_filter">
            Отфильтровать от первой букве фамилии:
            <?php foreach ($this->getFirstLettersSurnames() as $symbol): ?>
                <a class="symbol" href="<?= $this->path ?>admin/index/symbol/<?= $symbol ?>"><?= $symbol ?></a>
            <?php endforeach; ?>
            <a class="symbol" href="<?= $this->path ?>admin/index/">Весь список</a>
        </div>
        <div class="status_filter">
            Отфильтровать по статусу активности:
            <a class="status" href="<?= $this->path ?>admin/index/status/1">Активен</a>
            <a class="status" href="<?= $this->path ?>admin/index/status/0">Неактивен</a>
            <a class="status" href="<?= $this->path ?>admin/index/">Весь список</a>
        </div>
        <div class="head_table">
            <h5>№</h5>
            <h5>Логин</h5>
            <h5>Пользователь</h5>
            <h5>E-mail</h5>
            <h5>Регистрация</h5>
            <h5>Активность</h5>
            <h5>Клуб</h5>
            <h5>Действия</h5>
        </div>
        <ul class="ul_sortable">
            <?php foreach ($this->getUsers() as $user): ?>
                <li>
                    <ul class="users_ul">
                        <li><?= $user['id'] ?></li>
                        <li><?= $user['login'] ?></li>
                        <li><?= $user['name'] . " " . $user['surname'] ?></li>
                        <li><?= $user['email'] ?></li>
                        <li><?= $user['date_create'] ?></li>
                        <li><?= $this->userIsActive($user['active']) ?></li>
                        <li><?= $this->userStatusClub($user['club_type']) ?></li>
                        <li>
                            <a href="<?= $this->path ?>admin/show/id/<?= $user['id'] ?>">
                                <button type="button" class="btn btn-success">Открыть</button>
                            </a>
                            <a href="<?= $this->path ?>admin/edit/id/<?= $user['id'] ?>">
                                <button type="button" class="btn btn-warning">Редактировать</button>
                            </a>
                            <a href="<?= $this->path ?>admin/destroy/id/<?= $user['id'] ?>">
                                <button type="button" class="btn btn-danger">Удалить</button>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagination">
            <?= $this->pagination() ?>
        </div>
        <p class="reg_error"><?= $this->getAllErrors() ?></p>
        <p>
            <button class="btn btn-outline-success" type="button" data-toggle="collapse" data-target="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">
                Добавить нового пользователя
            </button>
        </p>
        <div class="collapse col-md-6" id="collapseExample">
            <form action="<?= $this->path ?>admin/create" class="reg" enctype="multipart/form-data"
                  method="post">
                <h3 class="reg_h3">Регистрация</h3>
                <input class="reg_input form-control" type="text" name="login" size="30" minlength="5"
                       placeholder="Логин (обязательно)"
                       required value="<?= $this->getValueInput('login') ?>">
                <input class="reg_input form-control" type="password" name="password" size="30" minlength="6"
                       placeholder="Пароль (обязательно)" required>
                <input class="reg_input form-control" type="password" name="passwordReplay" size="30" minlength="6"
                       placeholder="Повторите пароль (обязательно)" required>
                <input class="reg_input form-control" type="email" name="email" size="30"
                       placeholder="E-mail (обязательно)"
                       required value="<?= $this->getValueInput('email') ?>">
                <input class="reg_input form-control" type="text" name="name" size="30" minlength="3"
                       placeholder="Ваше Имя"
                       value="<?= $this->getValueInput('name') ?>">
                <input class="reg_input form-control" type="text" name="surname" size="30" minlength="3"
                       placeholder="Ваша Фамилия">
                <input class="reg_input form-control" type="tel" name="phone"
                       placeholder="Мобильный Телефон (обязательно)" id="phone"
                       required>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="photo" accept="image/png, image/jpeg, image/gif"
                           id="customFile">
                    <label class="custom-file-label" for="customFile">Ваше Фото</label>
                </div>
                <input class="reg_input form-control" type="text" name="address" size="30" placeholder="Ваш Адрес"
                       value="<?= $this->getValueInput('address') ?>">
                <div class="active">Активность:
                    <label class="input_radio">
                        <input name="active" type="radio" value="0" checked>Не активен
                    </label>
                    <label class="input_radio">
                        <input name="active" type="radio" value="1">Активен
                    </label>
                </div>
                <div class="club">Клуб:
                    <label class="input_radio">
                        <input name="club_type" type="radio" value="no" checked >Не в клубе
                    </label>
                    <label class="input_radio">
                        <input name="club_type" type="radio" value="standart">Стандарт
                    </label>
                    <label class="input_radio">
                        <input name="club_type" type="radio" value="max">Максимум
                    </label>
                </div>
                <input class="submit btn btn-info" type="submit" value="Регистрация">
            </form>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script src="<?= $this->path ?>data/js/jquery.maskedinput.js"></script>
<script src="<?= $this->path ?>data/js/registration.js"></script>
</body>
</html>
<?php require_once 'header.php' ?>
<div class="container flex-container">
    <div class="flex-rows low_range">
        <?php foreach ($this->getUser() as $user): ?>
            <form action="<?= $this->path ?>admin/update/id/<?= $user['id'] ?>" class="reg"
                  enctype="multipart/form-data"
                  method="post">
                <div class="col-md-12">
                    <br>
                    <h3 class="edit_user">Редактировать данные: пользователь <?= $user['login'] ?></h3>
                    <p class="reg_error"><?= $this->getAllErrors() ?></p>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Поле</th>
                            <th>Значение</th>
                        </tr>
                        <tr>
                            <td>ID</td>
                            <td><?= $user['id'] ?></td>
                        </tr>
                        <tr>
                            <td>Логин</td>
                            <td><input class="reg_input form-control" type="text" name="login" size="30" minlength="5"
                                       placeholder="Логин (обязательно)" required value="<?= $user['login'] ?>"></td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td><input class="reg_input form-control" type="email" name="email" size="30"
                                       placeholder="E-mail (обязательно)" required value="<?= $user['email'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Имя</td>
                            <td><input class="reg_input form-control" type="text" name="name" size="30" minlength="3"
                                       placeholder="Ваше Имя" value="<?= $user['name'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Фамилия</td>
                            <td><input class="reg_input form-control" type="text" name="surname" size="30" minlength="3"
                                       placeholder="Ваша Фамилия" value="<?= $user['surname'] ?>"></td>

                        </tr>
                        <tr>
                            <td>Телефон</td>
                            <td>
                                <input class="reg_input form-control" type="tel" name="phone"
                                       placeholder="Мобильный Телефон (обязательно)" id="phone"
                                       value="<?= $user['phone'] ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Картинка</td>
                            <td>
                                <div>Текущая картинка: <img
                                            src="<?= $this->path ?>data/images/avatar/<?= $user['image'] ?>">
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo"
                                           accept="image/png, image/jpeg, image/gif" id="customFile">
                                    <label class="custom-file-label" for="customFile">Ваше Фото</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Адрес</td>
                            <td>
                                <input class="reg_input form-control" type="text" name="address" size="30"
                                       placeholder="Ваш Адрес" value="<?= $user['address'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Дата создания</td>
                            <td><?= $user['date_create'] ?></td>
                        <tr>
                            <td>Дата последнего изменения</td>
                            <td><?= $user['date_update'] ?></td>
                        </tr>
                        <tr>
                            <td>Активность</td>
                            <td>
                                <label class="input_radio">
                                    <input name="active" type="radio" value="1"
                                        <?= $user['active'] == 1 ? 'checked' : '' ?>
                                    >Активен
                                </label>
                                <label class="input_radio">
                                    <input name="active" type="radio" value="0"
                                        <?= $user['active'] == 0 ? 'checked' : '' ?>
                                    >Не активен
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>Клуб</td>
                            <td>
                                <label class="input_radio">
                                    <input name="club_type" type="radio" value="no"
                                        <?= $user['club_type'] === 'no' ? 'checked' : '' ?>
                                    >Не в клубе
                                </label>
                                <label class="input_radio">
                                    <input name="club_type" type="radio" value="standart"
                                        <?= $user['club_type'] === 'standart' ? 'checked' : '' ?>
                                    >Клуб: стандарт
                                </label>
                                <label class="input_radio">
                                    <input name="club_type" type="radio" value="max"
                                        <?= $user['club_type'] === 'max' ? 'checked' : '' ?>
                                    >Клуб: максимум
                                </label>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <input class="submit btn btn-info" type="submit" value="Сохранить">
            </form>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script src="<?= $this->path ?>data/js/jquery.maskedinput.js"></script>
<script src="<?= $this->path ?>data/js/registration.js"></script>
</body>
</html>
<?php require_once 'header.php' ?>
<div class="container flex-container">
    <div class="flex-rows low_range">
        <?php foreach ($this->getDataUser() as $user): ?>
            <div class="col-md-12">
                <br>
                <h2>Пользователь: <?= $user['login'] ?></h2>
                <br>
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
                        <td><?= $user['login'] ?></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><?= $user['email'] ?></td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td><?= $this->isEmpty($user['name']) ?></td>
                    </tr>
                    <tr>
                        <td>Фамилия</td>
                        <td><?= $this->isEmpty($user['surname']) ?></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><?= $user['phone'] ?></td>
                    </tr>
                    <tr>
                        <td>Аватар</td>
                        <td><img src="<?= $this->path ?>data/images/avatar/<?= $user['image'] ?>"></td>
                    </tr>
                    <tr>
                        <td>Адрес</td>
                        <td><?= $this->isEmpty($user['address']) ?></td>
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
                        <td><?= $this->userIsActive($user['active']) ?></td>
                    </tr>
                    <tr>
                        <td>Клуб</td>
                        <td><?= $this->userStatusClub($user['club_type']) ?></td>
                    </tr>
                    <tr>
                        <td>Картинка</td>
                        <td><img class="image" src="<?= $this->path ?>data/images/<?= $user['image'] ?>"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?= $this->path ?>index/edit">
                <button type="button" class="btn btn-success">Редактировать</button>
            </a>
            <a href="<?= $this->path ?>index/destroy">
                <button type="button" class="btn btn-danger">Удалить профиль</button>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'footer.php' ?>
<script src="<?= $this->path ?>data/js/jqueryUI/jquery-ui.min.js"></script>
<script src="<?= $this->path ?>data/js/index.js"></script>
</body>
</html>
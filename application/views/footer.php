<footer class="footer">
    <h4><a href="https://github.com/GromoVlad">GromoVladislav &copy; 2020</a></h4>
</footer>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="login_h3">Логин</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container login">
                    <form class="login" action="<?= $this->path ?>login/entry" method="post">
                        <input class="login_input form-control" type="login" name="login" size="30" placeholder="Логин"
                               required>
                        <input class="login_input form-control" type="password" name="password" size="30"
                               placeholder="Пароль" required>
                        <input class="submit btn btn-info" type="submit" value="Войти">
                        <p class="login_p">Ещё нет аккаунта? <a class="login_a" href="<?= $this->path ?>registration">Зарегистрируйтесь!</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

class Mailer
{
    public $text;
    public $recipient;
    public $login;
    public $password;
    public $title;
    private $emailAdmin;
    private $emailAdminLogin;
    private $emailAdminPassword;

    public function __construct($request)
    {
        require_once 'PHPMailer.php';
        require_once 'SMTP.php';
        require_once 'Exception.php';
        $config = new Config();
        $this->emailAdmin = $config::EMAIL_ADMIN;
        $this->emailAdminLogin = $config::EMAIL_ADMIN_LOGIN;
        $this->emailAdminPassword = $config::EMAIL_ADMIN_PASSWORD;
        $this->request = $request;
    }

    public function postMail()
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = true;

            // Настройки вашей почты
            $mail->Host = 'smtp.gmail.com'; // SMTP сервера GMAIL
            $mail->Username = $this->emailAdminLogin; // Логин на почте
            $mail->Password = $this->emailAdminPassword; // Пароль на почте
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom($this->emailAdmin, 'Администратор'); // Адрес самой почты и имя отправителя

            // Получатель письма
            $mail->addAddress($this->recipient);

            // Письмо
            $mail->isHTML(true);
            $mail->Subject = $this->title;
            $mail->Body = "<b>Сообщение:</b><br>$this->text";
            $mail->send();

        } catch (Exception $e) {
            echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
        }
    }

    public function sendMailUser() // отправляем письмо о успешной регистрации пользователю
    {
        $this->text = 'Поздравляем! Вы зарегистрировались на нашем сайте!<br/> Ваш логин: ' . $this->request['login'] . 
                          '<br/> Ваш пароль: ' . $this->request['password'] . '<br/>';
        $this->recipient = $this->request['email'];
        $this->title = 'Спасибо за регистрацию';
        $this->postMail();
    }

    public function sendMailAdmin() // отправляем письмо о успешной регистрации администратору
    {
        $this->text = 'На нашем сайте зарегистрировался новый пользователь!<br/> Логин пользователя: ' .
                        $this->request['login'] . '<br/> E-mail пользователя: ' . $this->request['email'] . '<br/>';
        $this->recipient = $this->emailAdmin;
        $this->title = 'Зарегистрирован новый пользователь';
        $this->postMail();
    }

    public function sendMailChangeActive($active, $email) 
    {
        $status = $active == 0 ? 'неактивный' : 'активный';
        $this->text = 'Администратор изменил Ваш статус на ' . $status;
        $this->recipient = $email;
        $this->title = 'Администратор изменил Ваш статус';
        $this->postMail();
    }

}
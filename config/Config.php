<?php

namespace Config;

class Config
{
    const HOST_DB = 'localhost';
    const LOGIN_DB = 'root';
    const PASS_DB = 'root';
    const NAME_DB = 'forumedia';
    const APP_URL = 'http://forumedia/';
    const DEBUG_MODE = false;
    const RECORDS_IN_PAGE = 10;
    const EMAIL_ADMIN = 'uniquesitemailtest@gmail.com';
    const EMAIL_ADMIN_LOGIN = 'uniquesitemailtest'; // логин на почте
    const EMAIL_ADMIN_PASSWORD = 'wc3tft77'; // пароль на почте
    const DEFAULT_VALUE_ACTIVATION = 1; // (0 - неактивен, 1 - активен)
    const DEFAULT_VALUE_CLUB = 'max'; // ('no' - "не в клубе", 'standart' - "клуб: стандарт", 'max' - "клуб: максимум")
}

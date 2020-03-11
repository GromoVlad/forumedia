<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= self::TITLE ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="<?= $this->path ?>data/css/header.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?= $this->path ?>data/css/login.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?= $this->path ?>data/css/footer.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?= $this->path ?>data/css/<?= self::CSS ?>.css"/>
    <link href="https://fonts.googleapis.com/css?family=Pacifico|Merriweather&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
</head>
<body>
<nav class="container">
    <?php $this->header->getMenu(); ?>
</nav>
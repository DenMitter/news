<?php
    include_once  $_SERVER['DOCUMENT_ROOT'] . '/includes/News.php';

    $news = new News();

    if (isset($_GET['id'])) {
        $result = $news->getNewsById($_GET['id']);
        }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News</title>

    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="container">
        <a href="/" class="content-header">
            <svg width="16" height="14" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 20 20"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg>
            Повернутись назад
        </a>

        <?php
            if (empty($result)) {
                ?>
                    <h5 class="mini-title">
                        На жаль, але ми не змогли знайти новину
                        <img src="images/sad-emoji.png" alt="Sad emoji">
                    </h5>
                <?php

                return 1;
            }
        ?>

        <div class="news__item">
            <div class="news__block">
                <div class="news__header">
                    <h4 class="news__header-title"><?= $result['title'] ?></h4>
                    <span class="news__header-date">
                        <?php
                        $timestamp = strtotime($result['created_at']);
                        echo date('d.m.Y \o H:i', $timestamp);
                        ?>
                    </span>
                </div>

                <p class="news__content"><?= $result['content'] ?></p>
            </div>
        </div>
    </div>
</body>
</html>
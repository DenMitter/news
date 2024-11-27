<?php
    include_once  $_SERVER['DOCUMENT_ROOT'] . '/includes/News.php';

    $news = new News();
    $newsList = $news->getAllNews(10, 0);
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
        <ul class="news">
            <?php
                if (empty($newsList)) {
                    ?>
                        <h5 class="mini-title">
                            На жаль, але новин поки немає
                            <img src="images/sad-emoji.png" alt="Sad emoji">
                        </h5>
                    <?php
                }
            ?>

            <?php foreach ($newsList as $newsItem): ?>
                <li class="news__item">
                    <a href="details.php?id=<?= $newsItem['id'] ?>">
                        <div class="news__block">
                            <div class="news__header">
                                <h4 class="news__header-title"><?= $newsItem['title'] ?></h4>
                                <span class="news__header-date">
                                    <?php
                                        $timestamp = strtotime($newsItem['created_at']);
                                        echo date('d.m.Y \o H:i', $timestamp);
                                    ?>
                                </span>
                            </div>

                            <p class="news__content"><?= $newsItem['short_description'] ?></p>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
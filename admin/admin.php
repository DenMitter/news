<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/News.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

    $news = new News();

    // Функція для перевірки коректності полів
    function validateNewsData($title, $short_description, $content) {
        $errors = [];

        // Перевірка на наявність заголовку
        if (empty($title)) {
            $errors[] = 'Заголовок не може бути порожнім.';
        } elseif (strlen($title) < 5 || strlen($title) > 255) {
            $errors[] = 'Заголовок повинен бути від 5 до 255 символів.';
        }

        // Перевірка на наявність короткого опису
        if (empty($short_description)) {
            $errors[] = 'Короткий опис не може бути порожнім.';
        } elseif (strlen($short_description) < 10) {
            $errors[] = 'Короткий опис повинен бути мінімум 10 символів.';
        }

        // Перевірка на наявність тексту новини
        if (empty($content)) {
            $errors[] = 'Текст новини не може бути порожнім.';
        }

        return $errors;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['short_description'], $_POST['content'])) {
        $title = trim($_POST['title']);
        $short_description = trim($_POST['short_description']);
        $content = trim($_POST['content']);

        // Перевірка даних перед додаванням
        $errors = validateNewsData($title, $short_description, $content);

        if (empty($errors)) {
            // Якщо перевірки пройдені, додаємо новину
            $news->addNews($title, $short_description, $content);

            $_SESSION['status'] = 1;
            $_SESSION['message'] = 'Новина успішно додана!';

            header("Location: admin.php");
            exit;
        } else {
            // Якщо є помилки, виводимо їх
            $_SESSION['status'] = 0;
            $_SESSION['message'] = implode('<br>', $errors);
        }
    }

    $newsList = $news->getAllNews();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адміністративна панель</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="container">
        <a href="/" class="content-header">
            <svg width="16" height="14" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 20 20"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg>
            На головну
        </a>

        <?php displayStatusMessage(); ?>

        <form class="form" method="POST">
            <div>
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" value="<?= isset($title) ? htmlspecialchars($title) : '' ?>" required><br>
            </div>
            <div>
                <label for="short_description">Короткий опис:</label>
                <textarea id="short_description" name="short_description" required><?= isset($short_description) ? htmlspecialchars($short_description) : '' ?></textarea><br>
            </div>
            <div>
                <label for="content">Текст новини:</label>
                <textarea id="content" name="content" required><?= isset($content) ? htmlspecialchars($content) : '' ?></textarea><br>
            </div>
            <button type="submit" class="button">Додати новину</button>
        </form>

        <h2>Список новин</h2>

        <table class="customers">
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Редагувати</th>
                <th>Видалити</th>
            </tr>
            <?php foreach ($newsList as $newsItem): ?>
                <tr>
                    <td><?= $newsItem['id'] ?></td>
                    <td><?= $newsItem['title'] ?></td>
                    <td><a href="update.php?id=<?= $newsItem['id'] ?>" class="button btn-icon"><img src="../images/pencil.svg" width="16px" alt="Pencil icon"></a></td>
                    <td>
                        <form action="delete.php" method="get">
                            <input type="hidden" name="id" value="<?= $newsItem['id'] ?>">
                            <button type="submit" onclick="return confirm('Ви впевнені, що хочете видалити цю новину?');" class="button btn-icon">
                                <img src="../images/trash.svg" width="16px" alt="Trash icon">
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <span style="margin-top: 100px;color: transparent">.</span>
</body>
</html>
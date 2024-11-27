<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/News.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

    $news = new News();

    if (isset($_GET['id'])) {
        $newsId = $_GET['id'];
        $newsItem = $news->getNewsById($newsId);

        if (!$newsItem) {
            $_SESSION['status'] = 0;
            $_SESSION['message'] = 'Новину не знайдено.';
            header('Location: admin.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 0;
        $_SESSION['message'] = 'Некоректний запит.';
        header('Location: admin.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['short_description'], $_POST['content'])) {
        $title = trim($_POST['title']);
        $short_description = trim($_POST['short_description']);
        $content = trim($_POST['content']);

        if (empty($title) || empty($short_description) || empty($content)) {
            $_SESSION['status'] = 0;
            $_SESSION['message'] = 'Будь ласка, заповніть всі поля.';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }

        if (strlen($title) < 1 || strlen($title) > 255) {
            $_SESSION['status'] = 0;
            $_SESSION['message'] = 'Заголовок має бути від 1 до 255 символів.';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }

        if (strlen($short_description) < 1) {
            $_SESSION['status'] = 0;
            $_SESSION['message'] = 'Короткий опис не може бути порожнім.';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }

        if (strlen($content) < 1) {
            $_SESSION['status'] = 0;
            $_SESSION['message'] = 'Текст новини не може бути порожнім.';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }

        if ($news->updateNews($newsId, $title, $short_description, $content)) {
            $_SESSION['status'] = 1;
            $_SESSION['message'] = 'Новина успішно оновлена!';
        } else {
            $_SESSION['status'] = 0;
            $_SESSION['message'] = 'Не вдалося оновити новину.';
        }

        header('Location: admin.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати новину</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="container">
        <h2>Редагування новини</h2>

        <?php displayStatusMessage(); ?>

        <form class="form" method="POST">
            <div>
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($newsItem['title']) ?>" required><br>
            </div>
            <div>
                <label for="short_description">Короткий опис:</label>
                <textarea id="short_description" name="short_description" required><?= htmlspecialchars($newsItem['short_description']) ?></textarea><br>
            </div>
            <div>
                <label for="content">Текст новини:</label>
                <textarea id="content" name="content" required><?= htmlspecialchars($newsItem['content']) ?></textarea><br>
            </div>
            <button type="submit" class="button">Зберегти зміни</button>
        </form>
    </div>
</body>
</html>
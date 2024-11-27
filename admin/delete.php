<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/News.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $newsId = $_GET['id'];

    $news = new News();

    if ($news->deleteNews($newsId)) {
        $_SESSION['status'] = 1;
        $_SESSION['message'] = 'Новина успішно видалена!';
    }
    else {
        $_SESSION['status'] = 0;
        $_SESSION['message'] = 'Виникла помилка при видаленні новини.';
    }
} else {
    $_SESSION['status'] = 0;
    $_SESSION['message'] = 'Некоректний запит.';
}
header('Location: admin.php');
exit();
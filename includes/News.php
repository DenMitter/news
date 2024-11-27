<?php
include_once 'Database.php';

class News {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllNews($limit = 10, $offset = 0) {
        $stmt = $this->conn->prepare("SELECT * FROM news ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewsById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM news WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addNews($title, $short_description, $content) {
        $stmt = $this->conn->prepare("INSERT INTO news (title, short_description, content) VALUES (:title, :short_description, :content)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':short_description', $short_description);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        return 1;
    }

    public function updateNews($id, $title, $short_description, $content) {
        $stmt = $this->conn->prepare("UPDATE news SET title = :title, short_description = :short_description, content = :content WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':short_description', $short_description);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        return 1;
    }

    public function deleteNews($id) {
        $stmt = $this->conn->prepare("DELETE FROM news WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return 1;
    }
}
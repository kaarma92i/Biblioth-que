class Book {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addBook($userId, $bookId, $title, $image) {
        $stmt = $this->pdo->prepare("INSERT INTO user_books (user_id, book_id, title, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $bookId, $title, $image]);
    }

    public function getBooks($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM user_books WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteBook($userId, $bookId) {
        $stmt = $this->pdo->prepare("DELETE FROM user_books WHERE user_id = ? AND book_id = ?");
        return $stmt->execute([$userId, $bookId]);
    }
}
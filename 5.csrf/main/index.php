<?php
@session_start();

function getPosts($pdo) {
    try {
        $sql = "SELECT * FROM posts INNER JOIN users ON users.id = posts.user_id";
        return $pdo->query($sql)->fetchAll();
    } catch (PDOException $e) {
        var_export($e->getMessage()); die();
        return false;
    }
}

function addPost($pdo, $user_id, $message) {
    if (!$user_id || !$message) {
        return false;
    }
    try {
        $sql = "INSERT INTO posts (user_id, message) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $message, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        var_export($e->getMessage()); die();
        return false;
    }
}

$pdo = new PDO(
    'mysql:dbname=database;port=3306;host=localhost',
    'username',
    'password',
);

if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {
    header('location: /login.php');
    die();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    addPost($pdo, $user_id, $message);
}

$posts = getPosts($pdo);

?>
<html>
    <body>
        <p>ログイン中: <?= $username ?></p>
        <span style="display: none" id="username"><?= $username ?></span>
        <form action="" method="POST" >
            投稿内容 <input name="message" type="text"><br>
            <button type="submit">投稿</button>
        </form>
        <p>投稿一覧</p>
        <?php foreach ($posts as $post): ?>
            <hr>
            <div>
            <p><?= $post['message'] ?> - by `<?= $post['username'] ?>`</p>
            </div>
        <?php endforeach; ?>
    </body>
</html>


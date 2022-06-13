<?php
@session_start();
$dsn = 'mysql:dbname=database;host=db';

$user_id = $_SESSION['user_id'];
if (!$user_id) {
    header("Location: /login.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_content = $_POST['content'];

    try {
        $pdo = new PDO($dsn, 'username', 'password');
        $stmt = $pdo->prepare('INSERT INTO posts (user_id, content) VALUES (?, ?)');
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $input_content, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: /inner.php");
    } catch (PDOException $e) {
        echo('Error:'.$e->getMessage());
        die();
    }

} else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo 'Unknown Request method';
    die();
}

try {
    $pdo = new PDO($dsn, 'username', 'password');
    $stmt = $pdo->prepare('
        SELECT users.id, users.username, users.email, posts.content, posts.created_at
        FROM posts
        INNER JOIN users ON users.id = posts.user_id
    ');
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    echo('Error:'.$e->getMessage()); die();
}

?>

<html>
    <body>
        <div>
            <h2>新規投稿 as user_id: <?= $user_id ?></h2>
            <form action="" method="POST">
                <label>内容</label>
                <input type="text" name="content">
                <br />
                <button type="submit" name="submit">投稿</button>
            </form>
        </div>
        <div>
            <h2>投稿一覧</h2>
            <?php foreach ($posts as $i => $post): ?>
                <?php if ($i > 0): ?>
                    <hr />
                <?php endif; ?>
                <p>
                    <span><?= $post['username'] ?> @ <?= $post['created_at'] ?></span>
                    <br />
                    <span><?= $post['content'] ?></span>
                </p>
            <?php endforeach; ?>
            <p></p>
        </div>
    </body>
</html>


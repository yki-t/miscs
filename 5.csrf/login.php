<?php
@session_start();

function getUser($pdo) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!$username || !$password) {
        return false;
    }
    try {
        $sql = "SELECT id, username FROM users WHERE username = ? AND password = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $password, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = getUser($pdo);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('location: /index.php');
    die();
} else {
    if (!$_SESSION['user_id']) {
        unset($_SESSION['user']);
        @session_destroy();
    }
}

?>
<html>
    <body>
        <form action="" method="POST" >
            ユーザー名 <input name="username" type="text"><br>
            パスワード <input name="password" type="text"><br>
            <button type="submit">ログイン</button>
        </form>
    </body>
</html>


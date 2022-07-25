<?php
function getUser() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$username || !$password) {
        return false;
    }

    try {
        $pdo = new PDO(
            'mysql:dbname=database;port=3306;host=localhost',
            'username',
            'password',
        );

        $sql = "SELECT username FROM users WHERE username = '$username' AND password = '$password'";
        return $pdo->query($sql)->fetch();
    } catch (PDOException $e) {
        var_export($e->getMessage()); die();
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = getUser();
}

?>
<html>
    <body>
        <?php if (isset($user) && $user): ?>
            <p>ログイン成功</p>
            <p>username: <?= $user['username'] ?></p>
        <?php else: ?>
            <form action="" method="POST" >
                ユーザー名 <input name="username" type="text"><br>
                パスワード <input name="password" type="text"><br>
                <button type="submit">ログイン</button>
            </form>
        <?php endif; ?>
    </body>
</html>


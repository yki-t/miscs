<?php
@session_start();
$dsn = 'mysql:dbname=database;host=db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    try {
        $pdo = new PDO($dsn, 'username', 'password');
        $sql = "SELECT id, password FROM users WHERE username = '$input_username'";
        echo "実行SQL: `$sql` <br>";
        $user = $pdo->query($sql)->fetch();
        if (password_verify($input_password, $user['password'])) {
            echo '結果: OK';
            $_SESSION['user_id'] = $user['id'];
            echo '<script>setTimeout(function() { location.href = "/inner.php" }, 1000);</script>';
        } else {
            echo '結果: NG';
        }
        die();
    } catch (PDOException $e) {
        echo('Error:'.$e->getMessage()); die();
    }

} else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo 'Unknown Request method';
    die();
}
?>

<html>
    <body>
        <div>
            <p>ユーザーはuser1, user2 でパスワードはどちらもqweqweです</p>
        </div>
        <form action="" method="POST">
            <label>username</label>
            <input type="text" name="username">
            <br />
            <label>password</label>
            <input type="text" name="password">
            <br />
            <button type="submit" name="submit">ログイン</button>
        </form>
    </body>
</html>

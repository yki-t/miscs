<?php
$dsn = 'mysql:dbname=database;host=db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    try {
        $pdo = new PDO($dsn, 'username', 'password');
        $sql = "SELECT id, password FROM users WHERE username = '$input_username' AND password = '$input_password'";
        $user = $pdo->query($sql)->fetch();
        echo "実行SQL: `$sql` <br>";
        if (password_hash($input_password, $user['password'])) {
            echo '結果: OK';
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

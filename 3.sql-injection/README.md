# SQL Injection

# Environment

Debian 11

# Get Started

```bash
bash init.sh
php -S localhost:3000
```


# Exploit

ブラウザでlocalhost:3000/login.phpにアクセスす

ユーザー名: `x` (メタ文字を含まない任意のもの)
パスワード: `' OR username = 'user02`
でuser02としてログインできる

# Fix

SQL 内でのユーザー入力をエスケープまたはPrepared Statementを使用してパラメータをBindする

修正前)

```php
<?php
$sql = "SELECT username FROM users WHERE username = '$username' AND password = '$password'";
```

修正後)

```php
<?php
$sql = "SELECT id, username FROM users WHERE username = ? AND password = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $username, PDO::PARAM_STR);
$stmt->bindParam(2, $password, PDO::PARAM_STR);
$stmt->execute();
```


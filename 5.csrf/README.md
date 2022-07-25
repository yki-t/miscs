# CSRF

# Environment

Debian 11

# Get Started

1つのターミナル上で対象サーバーを建てる

```bash
bash init.sh
php -S localhost:3000 -t main
```

別のターミナル上で攻撃用サーバーを建てる

```bash
php -S localhost:3001 -t attack
```


# Exploit

1. user01でログイン

ブラウザでlocalhost:3000/login.phpにアクセスする

user01としてログインする (`user01` / `user01`)

2. 悪意あるサイトに訪問する

セッション情報はサイト間で共有されるのでリクエストが通ってしまう

3. サイト側にuser01としての投稿が行われているのを確認する

# Fix

フォームにはトークンを発行して付与し、リクエスト処理時にサーバー側でのトークンと照合を行えば良い

修正後)

```php
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_SESSION['token'] !== $_POST['token']) { // リクエスト検証
    header('HTTP', true, 400);
    die();
  }
}

$token = bin2hex(openssl_random_pseudo_bytes(16));
$_SESSION['token'] = $token;
?>
  <form action="" method="POST" >
      投稿内容 <input name="message" type="text"><br>
      <input type="hidden" value="<?= htmlspecialchars($token)?>">
      <button type="submit">投稿</button>
  </form>
```


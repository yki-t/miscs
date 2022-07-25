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


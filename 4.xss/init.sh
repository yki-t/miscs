#!/bin/bash

sudo apt update && sudo apt upgrade -yqq
sudo apt install php mariadb-server php-mysql

MYSQL="sudo mysql"

sql='CREATE DATABASE IF NOT EXISTS `database`;'
sql+="CREATE USER IF NOT EXISTS username IDENTIFIED BY 'password';"
sql+='GRANT ALL ON `database`.* TO username;'

sql+="$(cat <<EOM
USE database;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
  id BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT
  , username VARCHAR(255) NOT NULL
  , password VARCHAR(255) NOT NULL

);

CREATE TABLE IF NOT EXISTS posts (
  id BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT
  , user_id BIGINT(20) UNSIGNED NOT NULL
  , message VARCHAR(255) NOT NULL
  , FOREIGN KEY posts_user_id_to_users_id (user_id)
    REFERENCES users (id)

);
EOM
)"

sql+="$(cat <<EOM
INSERT INTO database.users VALUES
  (1, 'user01', 'user01')
  , (2, 'user02', 'user02')
;
EOM
)"

$MYSQL -e"$sql"


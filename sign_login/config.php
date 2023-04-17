<?php

class DatabaseConnection {
  public static function getConnection() {
      $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
      $user = 'root';
      $dbPass = 'root';
      $options = array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_EMULATE_PREPARES => false,
      );
      $pdo = new PDO($dsn, $user, $dbPass, $options);
      return $pdo;
  }
}

//サーバーの接続情報
// mysql212.phy.lolipop.lan
// LAA1515199-shop
// LAA1515199
// jastaway4218
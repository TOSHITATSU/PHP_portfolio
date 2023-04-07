<?php
session_start();
session_regenerate_id(true);
// SSLでセッションIDを暗号化する
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    ini_set('session.cookie_secure', 1);
}
// クリックジャッキング対策を実装する
header('X-Frame-Options: SAMEORIGIN');

// セッションにログイン情報がない場合はログインフォームにリダイレクト
if (!isset($_SESSION['login_id'])) {
  echo '<ul>';
  echo '<li>ログイン状態ではありません</li>';
  echo '<li><a href="login.php">ログインフォームに戻る</a></li>';
  echo '</ul>';
  exit();
}

$login_id=$_SESSION['login_id'];

$config = require_once 'config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
$options = array(
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
);

try {
  $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
  $stmt = $pdo->prepare("SELECT `name`,`email`,`tel` FROM `members` WHERE `id`=:id");
  $stmt->bindParam(':id', $login_id);
  $stmt->execute();
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $member_name=$rec['name'];
  $member_email=$rec['email'];
  $member_tel=$rec['tel'];
  $stmt = null;
  $pdo = null;
  
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
  echo '<br>データベース接続できませんでした<br>';
  echo '<a href="./member.php">会員専用画面へ戻る</a>';
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アカウント情報参照画面</title>
  <style>
    .container {
      background-color: #f8f8f8;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);
      margin-top: 50px;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
      text-align: center;
    }
    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
    }
    p {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }
    input[type=button] {
      font-size: 1rem;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 20px;
    }
    input[type=button]:hover {
      background-color: #3e8e41;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>会員様情報参照</h1>
    <p>氏名：「<?php echo $member_name;?>」</p>
    <p>メールアドレス：「<?php echo $member_email;?>」</p>
    <p>電話番号：「<?php echo $member_tel;?>」</p>
    <form>
    <input type="button" onclick="history.back()" value="戻る">
    </form>
  </div>
</body>
</html>
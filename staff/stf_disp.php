<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>スタッフ情報参照画面</title>
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

<?php
$staff_code=$_GET['staffcode'];

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
  $stmt = $pdo->prepare("SELECT `name` FROM `staff` WHERE `code`=:code");
  $stmt->bindParam(':code', $staff_code);
  $stmt->execute();
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $staff_name=$rec['name'];
  $stmt = null;
  $pdo = null;
  
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
  echo '<br>データベース接続できませんでした<br>';
  echo '<a href="../stf_login/stf_login.html">ログイン画面へ戻る</a>';
  exit();
}
?>

<div class="container">
  <h1>スタッフ情報参照</h1>
  <p>スタッフコード：<?php echo $staff_code;?></p>
  <p>スタッフ名：「<?php echo $staff_name;?>」</p>
  <form>
  <input type="button" onclick="history.back()" value="戻る">
  </form>
</div>

</body>
</html>

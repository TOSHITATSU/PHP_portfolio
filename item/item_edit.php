<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品データ変更</title>
  <style>
      .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f7f7f7;
      border-radius: 5px;
      }

      h1 {
      font-size: 36px;
      text-align: center;
      margin-bottom: 30px;
      }

      p {
        text-align: center;
      }

      form {
      display: flex;
      flex-direction: column;
      align-items: center;
      }

      form p {
      font-size: 18px;
      margin-bottom: 10px;
      }

      form input[type="text"],
      form input[type="password"] {
      width: 100%;
      max-width: 400px;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      margin-bottom: 20px;
      }

      form input[type="submit"],
      form input[type="button"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
      margin-bottom: 10px;
      }

      form input[type="submit"]:hover,
      form input[type="button"]:hover {
      background-color: #3e8e41;
      }
    </style>
</head>
<body>
<?php
try{
  $item_code = $_GET['itemcode'];

  $config = require_once 'config.php';
  $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
  $options = array(
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
      PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
  );
  
  $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
  $stmt = $pdo->prepare("SELECT `name`,`price`,`img` FROM `item` WHERE `code`=:code");
  $stmt->bindParam(':code', $item_code, PDO::PARAM_INT);
  $stmt->execute();
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $item_name = $rec['name'];
  $item_price = $rec['price'];
  $img_path = $rec['img'];
  $pdo = null;
}
catch(Exception $e){
  echo'ただいま障害により大変ご迷惑をおかけしております。';
  echo'<a href="item_list.php">商品管理画面に戻る</a>';
  exit();
}
?>

<div class="container">
    <h1>商品データ情報変更</h1>
    <p>商品コード：「<?php echo $item_code;?>」</p>
    <form method="post" action="item_edit_check.php" enctype="multipart/form-data">
        <p>新しい商品名</p>
        <input type="text" name="new_name" style="width:200px" value="<?php echo $item_name;?>">
        <p>新しい価格</p>
        <input type="text" name="new_price" style="width:300px" value="<?php echo $item_price;?>">
        <p>新しい商品画像</p>
        <input type="file" name="new_img"><br>
        <input type="hidden" name="token">
        <input type="hidden" name="itemcode" value="<?php echo $item_code;?>">
        <input type="hidden" name="img" value="<?php echo $img_path;?>">
        <input type="submit" value="OK">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</div>

<?php
session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['token'] = $token;
?>

</body>
</html>
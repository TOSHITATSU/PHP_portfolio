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

require_once 'config.php';

try {
  $pdo = DatabaseConnection::getConnection();
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <div class="container text-center">
      <h1 class="mb-4">会員様情報参照</h1>
      <p>氏名：「<?php echo $member_name;?>」</p>
      <p>メールアドレス：「<?php echo $member_email;?>」</p>
      <p>電話番号：「<?php echo $member_tel;?>」</p>
      <button class="btn btn-primary" onclick="history.back()">戻る</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
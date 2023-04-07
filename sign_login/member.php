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

// セッションからログイン情報を取得
$id = $_SESSION['login_id'];
$name = $_SESSION['name'];
$_SESSION['login_id'] = $id;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員様専用ページ</title>
  <style>
      .container {
        background-color: #333;
        color: #fff;
        font-family: Arial, sans-serif;
        text-align: center;
        padding: 50px;
        margin: 0 auto;
        max-width: 800px;
      }
      h1 {
        font-size: 3rem;
        margin-bottom: 30px;
      }
      p {
        font-size: 1.5rem;
        margin-bottom: 20px;
      }
      a {
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
      }
      a:hover {
        color: #f1c40f;
      }
  </style>
</head>

<body>

  <div class="container">
    <h1>ようこそ、<?php echo $name; ?>さん</h1>
    <p>会員専用ページです。</p>
    <p><a href="member_disp.php">アカウント情報参照</a></p>
    <p><a href="logout.php">ログアウト</a></p>
  </div>

</body>
</html>

<?php
session_start();
session_regenerate_id(true);
// セッション変数を全て解除する
$_SESSION = [];
// セッションを切断するために、セッションクッキーも削除する
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
// 最終的に、セッションを破棄する
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログアウト画面</title>
  <style>
    .container {
      background-color: #f1c40f;
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
      color: #333;
      background-color: #fff;
    }
  </style>
</head>
<body>
  <div class="container">
    <p>ログアウトしました</p>
    <p><a href="sign_login.html">トップ画面に戻る</a></p>
  </div>
</body>
</html>
<?php exit(); ?>

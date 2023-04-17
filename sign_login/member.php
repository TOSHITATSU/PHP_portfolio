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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>会員様専用ページ</title>
</head>

<body>

  <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
      <div class="container text-center">
          <h1>ようこそ、<?php echo $name; ?>さん</h1>
          <p>会員専用ページです。</p>
          <p><a href="member_disp.php" class="btn btn-primary">アカウント情報参照</a></p>
          <p><a href="logout.php" class="btn btn-danger">ログアウト</a></p>
      </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

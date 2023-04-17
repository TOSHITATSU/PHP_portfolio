<?php
// セッションの有効期限を30分に設定
session_set_cookie_params(1800);
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token']) && !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="sign.php">会員登録フォームに戻る</a>';
    exit;
}

//入力判定と正規表現
$errors=array();
if($_SERVER['REQUEST_METHOD']!=='POST' && !isset($_POST['token'])):
    exit("直接アクセス禁止");
endif;  
if(isset($_POST['name']) && strlen($_POST['name'])):
    $name=htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
else:
    $name = "";
    $errors[]="氏名を入力して下さい";
endif;
if(isset($_POST['email']) && strlen($_POST['email'])):
  $email=htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
else:
  $email = "";
  $errors[]="メールアドレスを入力して下さい";
endif;
if(isset($_POST['tel']) && strlen($_POST['tel'])):
  $tel=htmlspecialchars($_POST['tel'],ENT_QUOTES,'UTF-8');
else:
  $tel = "";
  $errors[]="電話番号を入力して下さい";
endif;
if(isset($_POST['pass']) && strlen($_POST['pass'])):
    $pass=htmlspecialchars($_POST['pass'],ENT_QUOTES,'UTF-8');
else:
    $pass = "";
    $errors[]="パスワードを入力して下さい";
endif;
if(isset($_POST['pass2']) && strlen($_POST['pass2'])):
    $pass2=htmlspecialchars($_POST['pass2'],ENT_QUOTES,'UTF-8');
else:
    $pass2 = "";
    $errors[]="確認のためのパスワードを入力してください";
endif;
if(!preg_match("/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]+$/u",$name)){
    $errors[]="氏名を正しく入力して下さい";
}
if(!preg_match("/^\d{2,5}-?\d{1,4}-?\d{4}$/", $tel)){
    $errors[] = "電話番号を正しく入力して下さい";
}
if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
    $errors[] = "メールアドレスを正しく入力して下さい";
}
if(!preg_match("/^[a-zA-Z0-9]{6,16}$/",$pass) || !preg_match("/^[a-zA-Z0-9]{6,16}$/",$pass2)){
    $errors[]="パスワードを正しく入力して下さい";
}
if($_POST['pass'] !== $_POST['pass2']) {
    $errors[]="パスワードが一致しません";
}
//エラーの数だけ表示する
if (count($errors)) {
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '<a href="sign.php">会員登録フォームに戻る</a>';
    exit();
}?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>会員登録確認</title>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4 text-center">会員登録確認</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">登録内容の確認</h5>
                    <p class="card-text">氏名：「<?php echo $name;?>」さん</p>
                    <p class="card-text">メールアドレス：「<?php echo $email;?>」</p>
                    <p class="card-text">電話番号：「<?php echo $tel;?>」</p>
                    <p class="card-text">この内容で登録してもよろしいですか？</p>
                    <form action="sign_done.php" method="post">
                        <input type="hidden" name="name" value="<?php echo $name; ?>">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                        <input type="hidden" name="tel" value="<?php echo $tel; ?>">
                        <input type="hidden" name="pass" value="<?php echo $pass; ?>">
                        <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
                        <input type="submit" value="登録" class="btn btn-primary">
                        <a href="sign.php" class="btn btn-secondary">戻る</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
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

require_once(__DIR__ . '/class/validate.php');

// POSTデータからインスタンスを作成しバリデーション関数を実行
$validator = new FormValidator($_POST);
$errors = $validator->validate_sign();

//エラーの数だけ表示する
if (count($errors)) {
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '<a href="sign.php">会員登録フォームに戻る</a>';
    exit();
}

//getterメソッドでクラス外からプロパティを使えるように
$name = $validator->get_name();
$email = $validator->get_email();
$tel = $validator->get_tel();
?>

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
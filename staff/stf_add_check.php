<?php
// セッションの有効期限を30分に設定
session_set_cookie_params(1800);
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token']) && !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="stf_list.php">スタッフ一覧に戻る</a>';
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
    $errors[]="スタッフ名を入力して下さい";
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
    $errors[]="スタッフ名を正しく入力して下さい";
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
    echo '<a href="stf_list.php">スタッフ一覧に戻る</a>';
    exit();
}?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフ登録確認</title>
    <style>
        .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        text-align: center;
        }
        h1 {
        font-size: 36px;
        margin-bottom: 20px;
        }
        p {
        font-size: 24px;
        margin-bottom: 10px;
        }
        form {
        display: inline-block;
        margin-top: 20px;
        }
        input[type="button"], input[type="submit"] {
        font-size: 20px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        }
        input[type="button"]:hover, input[type="submit"]:hover {
        background-color: #2E8B57;
        }
</style>
</head>
<body>
    <div class="container">
        <h1>スタッフ登録確認</h1>
        <p>スタッフ名：「<?php echo $name;?>」さん</p>
        <p>この内容で登録してもよろしいですか？</p>
        <form action="stf_add_done.php" method="post">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="pass" value="<?php echo $pass; ?>">
            <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="登録">
        </form>
    </div>
</body>
</html>
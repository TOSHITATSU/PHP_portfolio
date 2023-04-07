<?php
// セッションの有効期限を30分に設定
session_set_cookie_params(1800);
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token']) && !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="stf_list.php">スタッフ一覧に戻る</a>';
    exit();
}

//入力判定と正規表現
$errors=array();
if($_SERVER['REQUEST_METHOD']!=='POST' && !isset($_POST['token']) && !isset($_POST['staffcode'])):
    exit("直接アクセス禁止");
endif;  
if(isset($_POST['new_name']) && strlen($_POST['new_name'])):
    $new_name=htmlspecialchars($_POST['new_name'],ENT_QUOTES,'UTF-8');
else:
    $new_name='';
    $errors[]="スタッフ名を入力して下さい";
endif;
if(isset($_POST['new_pass']) && strlen($_POST['new_pass'])):
    $new_pass=htmlspecialchars($_POST['new_pass'],ENT_QUOTES,'UTF-8');
else:
    $new_pass='';
    $errors[]="パスワードを入力して下さい";
endif;
if(isset($_POST['new_pass2']) && strlen($_POST['new_pass2'])):
    $new_pass2=htmlspecialchars($_POST['new_pass2'],ENT_QUOTES,'UTF-8');
else:
    $new_pass2='';
    $errors[]="確認のためのパスワードを入力してください";
endif;
if(!preg_match("/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]+$/u",$new_name)){
    $errors[]="スタッフ名を正しく入力して下さい";
}
if(!preg_match("/^[a-zA-Z0-9]{6,16}$/",$new_pass) || !preg_match("/^[a-zA-Z0-9]{6,16}$/",$new_pass2)){
    $errors[]="パスワードを正しく入力して下さい";
}
if($_POST['new_pass'] !== $_POST['new_pass2']) {
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
    <title>スタッフ修正情報確認</title>
    <style>
        .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: sans-serif;
        }

        h1 {
        font-size: 32px;
        font-weight: bold;
        margin-top: 0;
        }

        p {
        font-size: 20px;
        margin-bottom: 20px;
        }

        button {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.2s;
        }

        button:hover {
        background-color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>スタッフ修正情報確認</h1>
        <p>スタッフ名：「<?php echo $new_name;?>」さん</p>
        <p>この内容で登録してもよろしいですか？</p>
        <form action="stf_edit_done.php" method="post">
            <input type="hidden" name="new_name" value="<?php echo $new_name; ?>">
            <input type="hidden" name="new_pass" value="<?php echo $new_pass; ?>">
            <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
            <input type="hidden" name="staffcode" value=<?php echo $_POST['staffcode']; ?>>
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="登録">
        </form>
    </div>
    
</body>
</html>
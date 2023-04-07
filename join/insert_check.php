<?php
// セッションの有効期限を30分に設定
session_set_cookie_params(1800);
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token']) && !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="insert.php">トップメニューに戻る</a>';
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
if(isset($_POST['price']) && strlen($_POST['price'])):
    $price=htmlspecialchars($_POST['price'],ENT_QUOTES,'UTF-8');
else:
    $price = "";
    $errors[]="価格を入力して下さい";
endif;
if(isset($_POST['stock']) && strlen($_POST['stock'])):
  $stock=htmlspecialchars($_POST['stock'],ENT_QUOTES,'UTF-8');
else:
    $stock = "";
    $errors[]="在庫数を入力して下さい";
endif;
if(!preg_match("/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]+$/u",$name)){
    $errors[]="商品名を正しく入力して下さい";
}
if(!preg_match("/^[0-9]+$/", $price)) {
    $errors[]="価格を半角数字で入力してください";
}
if(!preg_match("/^[0-9]+$/", $stock)) {
  $errors[]="在庫数を半角数字で入力してください";
}

//エラーの数だけ表示する
if (count($errors)) {
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '<a href="insert.php">トップに戻る</a>';
    exit();
}?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>別テーブルにデータ追加確認</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .container {
            margin: 50px auto;
            padding: 20px;
            max-width: 600px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #ddd;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        form {
            display: flex;
            justify-content: space-evenly;
        }
        input[type="submit"], input[type="button"] {
            background-color: #1e90ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #0066ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>商品データ登録確認</h1>
        <p>商品名：「<?php echo $name;?>」</p>
        <p>価格：「<?php echo number_format($price);?>円」</p>
        <p>在庫数：「<?php echo $stock;?>点」</p>
        <p>この内容で登録してもよろしいですか？</p>
        <form action="insert_done.php" method="post">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="stock" value="<?php echo $stock; ?>">
            <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
            <input type="submit" value="登録">
            <input type="button" onclick="history.back()" value="戻る">
        </form>
    </div>
</body>
</html>
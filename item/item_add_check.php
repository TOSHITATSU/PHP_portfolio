<?php
// セッションの有効期限を30分に設定
session_set_cookie_params(1800);
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token']) && !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="item_list.php">商品管理画面に戻る</a>';
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
    $errors[]="商品名を入力して下さい";
endif;
if(isset($_POST['price']) && strlen($_POST['price'])):
    $price=htmlspecialchars($_POST['price'],ENT_QUOTES,'UTF-8');
else:
    $price = "";
    $errors[]="価格を入力して下さい";
endif;
if(!preg_match("/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]+$/u",$name)){
    $errors[]="商品名を正しく入力して下さい";
}
if(!preg_match("/^[0-9]+$/", $price)) {
    $errors[]="価格を半角数字で入力してください";
}

//画像データの入力判定
if(isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK){
    $img_name = basename($_FILES['img']['name']); // ファイル名に含まれるディレクトリトラバーサル攻撃を防ぐために、basename関数でファイル名のみを取得する
    $img_size = $_FILES['img']['size'];
    $img_tmp = $_FILES['img']['tmp_name'];
    $img_type = $_FILES['img']['type'];
    $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    if(!in_array($img_ext, $allowed_ext)){
        $errors[] = "許可されたファイル形式ではありません";
    }
    if($img_size > 2097152){
        $errors[] = "ファイルサイズは2MB以下にしてください";
    }
    // エラーがない場合、画像を保存する
    if(empty($errors)){
        // 画像を保存するディレクトリを指定する
        $upload_dir = './gazou/';
        // ファイル名をユニークなものにするため、現在のタイムスタンプを使用する
        $timestamp = time();
        $new_imgname = "{$timestamp}.{$img_ext}";
        // 保存先のディレクトリに同じファイル名が存在するかどうかを確認する
        $upload_dir = './gazou/';
        while(file_exists("{$upload_dir}{$new_imgname}")){
            $timestamp = time();
            $new_imgname = "{$timestamp}.{$img_ext}";
        }
        // 画像を保存する
        if(move_uploaded_file($img_tmp, "{$upload_dir}{$new_imgname}")){
            $img_path = "{$upload_dir}{$new_imgname}";
        } else {
            $errors[] = "画像のアップロードに失敗しました";
        }
    }
}

//エラーの数だけ表示する
if (count($errors)) {
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '<a href="item_list.php">商品管理画面に戻る</a>';
    exit();
}?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品データ登録確認</title>
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
        <p>商品名：「<?php echo $name;?>」さん</p>
        <p>価格：「<?php echo number_format($price);?>円」</p>
        <p>商品画像：<img src="<?php echo $img_path; ?>"></p>
        <p>この内容で登録してもよろしいですか？</p>
        <form action="item_add_done.php" method="post">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="img_path" value="<?php echo $img_path; ?>">
            <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
            <input type="submit" value="登録">
            <input type="button" onclick="history.back()" value="戻る">
        </form>
    </div>
</body>
</html>
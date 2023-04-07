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
if($_SERVER['REQUEST_METHOD']!=='POST' && !isset($_POST['token']) && !isset($_POST['itemcode'])):
    exit("直接アクセス禁止");
endif;  
if(isset($_POST['new_name']) && strlen($_POST['new_name'])):
    $new_name=htmlspecialchars($_POST['new_name'],ENT_QUOTES,'UTF-8');
else:
    $new_name='';
    $errors[]="商品名を入力して下さい";
endif;
if(isset($_POST['new_price']) && strlen($_POST['new_price'])):
    $new_price=htmlspecialchars($_POST['new_price'],ENT_QUOTES,'UTF-8');
else:
    $new_price='';
    $errors[]="価格を入力して下さい";
endif;
if(!preg_match("/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]+$/u",$new_name)){
    $errors[]="商品名を正しく入力して下さい";
}
if(!preg_match("/^[0-9]+$/", $new_price)) {
    $errors[]="価格を半角数字で入力してください";
}

//画像データの入力判定
if(isset($_FILES['new_img']) && $_FILES['new_img']['error'] === UPLOAD_ERR_OK){
    $img_name = basename($_FILES['new_img']['name']); // ファイル名に含まれるディレクトリトラバーサル攻撃を防ぐために、basename関数でファイル名のみを取得する
    $img_size = $_FILES['new_img']['size'];
    $img_tmp = $_FILES['new_img']['tmp_name'];
    $img_type = $_FILES['new_img']['type'];
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
        // 保存先のディレクトリに同じファイル名が存在するかどうかを確認する
        $upload_dir = './gazou/';
        $timestamp = time();
        $new_imgname = "{$timestamp}.{$img_ext}";
        $i = 1;
        while(file_exists("{$upload_dir}{$new_imgname}")){
            $new_imgname = "{$timestamp}_{$i}.{$img_ext}";
            $i++;
        }
        // 画像を保存する
        if(move_uploaded_file($img_tmp, "{$upload_dir}{$new_imgname}")){
            // 元の画像ファイルを削除する
            $img_path = $_POST['img'];
            if(!empty($img_path) && file_exists($img_path)){
                unlink($img_path);
            }
            $new_img_path = "{$upload_dir}{$new_imgname}";
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
    <title>商品データ変更確認</title>
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
        <h1>商品データ変更確認</h1>
        <p>新しい商品名：「<?php echo $new_name;?>」</p>
        <p>新しい価格：「<?php echo number_format($new_price);?>円」</p>
        <p>新しい商品画像：<img src="<?php echo $new_img_path; ?>"></p>
        <p>この内容で登録してもよろしいですか？</p>
        <form action="item_edit_done.php" method="post">
            <input type="hidden" name="new_name" value="<?php echo $new_name; ?>">
            <input type="hidden" name="new_price" value="<?php echo $new_price; ?>">
            <input type="hidden" name="new_img_path" value="<?php echo $new_img_path; ?>">
            <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
            <input type="hidden" name="itemcode" value=<?php echo $_POST['itemcode']; ?>>
            <input type="submit" value="登録">
            <input type="button" onclick="history.back()" value="戻る">
        </form>
    </div>
</body>
</html>

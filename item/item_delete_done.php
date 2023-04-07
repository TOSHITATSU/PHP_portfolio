<?php
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="item_list.php">商品管理画面に戻る</a>';
    exit;
}
session_destroy();

$item_code = $_POST['itemcode'];

try {
    $config = require_once 'config.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);

    $stmt = $pdo->prepare('SELECT `img` FROM `item` WHERE `code`=:code');
    $stmt->bindParam(':code', $item_code, PDO::PARAM_INT);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $img_path = $rec['img'];
    // 画像ファイルを削除する
    if (file_exists($img_path)) {
        unlink($img_path);
    } else {
        echo '画像がディレクトリから削除できませんでした';
        echo '<a href="item_list.php">商品管理画面に戻る</a>';
        exit();
    }
    $stmt = null;

    $stmt = $pdo->prepare('DELETE FROM `item` WHERE `code` = :code');
    $stmt->bindParam(':code', $item_code, PDO::PARAM_INT);
    $stmt->execute();
    $pdo = null;

} catch (PDOException $e) {
    // エラーハンドリング
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    echo '<a href="item_list.php">商品管理画面に戻る</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品データ削除完了画面</title>
    <style>
        .result {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        }

        h1 {
        font-size: 24px;
        margin-bottom: 10px;
        }

        p {
        font-size: 18px;
        margin-bottom: 10px;
        }

        a {
        color: #007bff;
        text-decoration: none;
        font-size: 18px;
        }

        a:hover {
        text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="result">
        <h1>商品データ削除完了しました</h1>
        <p>商品コード「<?php echo $item_code; ?>」の情報を削除しました。</p>
        <a href="item_list.php">商品管理画面に戻る</a>
    </div>
</body>
</html>
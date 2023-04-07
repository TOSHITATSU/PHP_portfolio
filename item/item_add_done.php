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

$name = $_POST['name'];
$price = $_POST['price'];
$img_path = $_POST['img_path'];

try {
    $config = require_once 'config.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);

    $stmt = $pdo->prepare('INSERT INTO `item` (`name`, `price`, `img`) VALUES (:name,:price,:img)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':img', $img_path, PDO::PARAM_STR);
    $stmt->execute();
    $pdo= null;

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
    <title>商品登録完了画面</title>
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
        <h1>商品登録完了</h1>
        <p>商品名：「<?php echo $name; ?>」を登録しました。</p>
        <p>価格：「<?php echo number_format($price); ?>円」で登録しました。</p>
        <p>商品画像</p>
        <p><img src="<?php echo $img_path; ?>"></p>
        <p>以上の情報で登録しました</p>
        <a href="item_list.php">商品管理画面に戻る</a>
    </div>
</body>
</html>
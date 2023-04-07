<?php
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="insert.php">トップメニューに戻る</a>';
    exit;
}
session_destroy();

$name = $_POST['name'];
$price = $_POST['price'];
$stock = $_POST['stock'];

$config = require_once 'config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
);
try {
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
} catch (PDOException $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    echo '<a href="insert.php">トップメニューに戻る</a>';
    exit();
}

  // トランザクション開始
$pdo->beginTransaction();

try {
    // テーブル`product`にINSERTする
    $stmt = $pdo->prepare('INSERT INTO `product` (`name`) VALUES (:name)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $s_id = $pdo->lastInsertId();
    $stmt = null;

    // テーブル`kanri`にINSERTする
    $stmt = $pdo->prepare('INSERT INTO `kanri` (`id`, `price`, `stock`) VALUES (:id, :price, :stock)');
    $stmt->bindParam(':id', $s_id, PDO::PARAM_INT);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->execute();
    // トランザクションのコミットとステートメントとSQLの切断
    $pdo->commit();
    $stmt = null;
    $pdo = null;

} catch (PDOException $e) {
    // トランザクションのロールバック
    $pdo->rollBack();
    $stmt = null;
    $pdo = null;
    // エラーハンドリング
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    echo '<a href="insert.php">トップメニューに戻る</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品追加完了画面</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        .container p {
            font-size: 18px;
            margin: 10px 0;
        }
        .container a {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            padding: 10px;
            text-decoration: none;
            width: 200px;
            margin: 0 auto;
            transition: background-color 0.3s ease;
        }
        .container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
    <p>商品名：「<?php echo $name; ?>」</p>
    <p>単価：<?php echo $price; ?>円</p>
    <p>在庫数：<?php echo $stock; ?>点</p>
    <p>で登録しました</p>
    <a href="insert.php">トップメニューへ</a>
    </div> 
</body>
</html>
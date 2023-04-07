<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理画面</title>
    <style>
        .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
        margin-top: 0;
        font-size: 2em;
        text-align: center;
        color: #333;
        }

        .container form {
        margin-top: 20px;
        text-align: center;
        }

        .container input[type="radio"] {
        margin-right: 10px;
        }

        .container input[type="submit"] {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 1.2em;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }

        .container input[type="submit"]:hover {
        background-color: #444;
        }

        .container input[type="submit"]:focus {
        outline: none;
        }
    </style>
</head>

<body>
<!-- <a href="../staff_login/stf_top.php">トップメニューへ</a><br /> -->

<?php
$config = require_once 'config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
$options = array(
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
);

try {
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
    $stmt = $pdo->prepare("SELECT `code`,`name` FROM `item` ");
    $stmt->execute(); ?>
    <div class="container">
        <h1>商品管理画面</h1>
        <form method="post" action="item_branch.php">
            <?php while(true){
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if($rec==false){
                    break;
                }
                echo'<input type="radio" name="itemcode" value="'.$rec['code'].'">';
                echo $rec['name'];
                echo'<br />';
            }?>
            <input type="submit" name="disp" value="参照">
            <input type="submit" name="add" value="登録">
            <input type="submit" name="edit" value="修正">
            <input type="submit" name="delete" value="削除">
        </form>
        <a href="../index.html">ポートフォリオ選択画面へ</a>
    </div>
    <?php $stmt = null;
    $pdo = null;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    echo '<br>データベース接続できませんでした<br>';
    echo '<a href="../stf_login/stf_login.html">ログイン画面へ戻る</a>';
    exit();
}
?>

</body>
</html>
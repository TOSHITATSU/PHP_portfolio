<?php
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="stf_list.php">スタッフ一覧に戻る</a>';
    exit;
}
session_destroy();

$new_name = $_POST['new_name'];
$new_pass = $_POST['new_pass'];
$staff_code = $_POST['staffcode'];

try {
    $config = require_once 'config.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
    $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('UPDATE `staff` SET `name`=:name, `pass`=:pass WHERE `code`=:code');
    $stmt->bindParam(':name', $new_name, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $hashed_pass, PDO::PARAM_STR);
    $stmt->bindParam(':code', $staff_code, PDO::PARAM_INT);
    $stmt->execute();
    $pdo= null;

} catch (PDOException $e) {
    // エラーハンドリング
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    echo '<a href="stf_list.php">スタッフ一覧に戻る</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修正完了画面</title>
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
        <h1>変更完了</h1>
        <p>「<?php echo $new_name; ?>」さんで修正登録しました。</p>
        <p>新しいパスワードの保管を御願いします</p>
        <a href="stf_list.php">スタッフ一覧に戻る</a>
    </div>
</body>
</html>
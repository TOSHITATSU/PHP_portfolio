<?php
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="sign.php">会員登録フォームに戻る</a>';
    exit;
}
session_destroy();

$name = $_POST['name'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$pass = $_POST['pass'];

try {
    $config = require_once 'config.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
    // メールアドレスがすでに登録済みかどうかを確認する
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM `members` WHERE `email` = :email');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        // 登録済みの場合はエラーを返す
        echo '入力されたメールアドレスはすでに登録されています。';
        echo '<a href="sign.php">会員登録フォームに戻る</a>';
        exit();
    }

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO `members` (`name`,`email`,`tel`,`pass`) VALUES (:name,:email,:tel,:pass)');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $hashed_pass, PDO::PARAM_STR);
    $stmt->execute();
    $pdo= null;

} catch (PDOException $e) {
    // エラーハンドリング
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    echo '<a href="sign.php">会員登録フォームに戻る</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録完了画面</title>
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
        <h1>会員登録完了</h1>
        <p>「<?php echo $name; ?>」</p>
        <p>「<?php echo $email; ?>」</p>
        <p>「<?php echo $tel; ?>」</p>
        <p>以上で登録完了しました</p>
        <a href="sign_login.html">トップページに戻る</a>
    </div>
</body>
</html>
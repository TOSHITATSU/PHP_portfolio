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
require_once(__DIR__ . '/class/connect.php');

try {
    // DatabaseConnectionクラスのインスタンスを作成
    $db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $db->connect();

    // クエリを実行する
    $query = "SELECT COUNT(*) FROM `members` WHERE `email` = :email";
    $params = [':email' => $email];
    $result = $db->executeSelectQuery($query, $params);
    $count = $result[0]['COUNT(*)'];

    if ($count > 0) {
        // 登録済みの場合はエラーを返す
        echo '入力されたメールアドレスはすでに登録されています。';
        echo '<a href="sign.php">会員登録フォームに戻る</a>';
        exit();
    }

    // テーブルにデータを挿入する
    $table = 'members';
    $db->insertData($table, $name, $email, $tel, $pass);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>会員登録完了画面</title>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="card mt-5">
            <div class="card-header">
                <h1 class="text-center">会員登録完了</h1>
            </div>
            <div class="card-body">
                <p class="card-text">「<?php echo $name; ?>」</p>
                <p class="card-text">「<?php echo $email; ?>」</p>
                <p class="card-text">「<?php echo $tel; ?>」</p>
                <p class="card-text">以上で登録完了しました</p>
                <a href="sign_login.html" class="btn btn-primary">トップページに戻る</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
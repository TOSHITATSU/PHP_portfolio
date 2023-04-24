<?php
session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
if (!isset($_POST['token']) && !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "不正なアクセスです。";
    echo '<a href="login.php">ログインフォームに戻る</a>';
    exit;
}

require_once(__DIR__ . '/class/validate.php');

$validator = new FormValidator($_POST);
$errors = $validator->validate_login();

//エラーの数だけ表示する
if (count($errors)) {
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '<a href="login.php">ログインフォームに戻る</a>';
    exit();
}

$email = $_POST['email'];
$pass = $_POST['pass'];
require_once(__DIR__ . '/class/connect.php');

try {
    // DatabaseConnectionクラスのインスタンスを作成
    $db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $db->connect();

    // クエリを実行する
    $query = "SELECT * FROM `members` WHERE `email` = :email";
    $params = [':email' => $email];
    $members = $db->executeSelectQuery($query, $params);

    if (count($members) === 0) {
        // メールアドレスが存在しない場合の処理
        echo '<ul>';
        echo '<li>登録されたメールアドレスが存在しませんでした</li>';
        echo '<li><a href="login.php">ログインフォームに戻る</a></li>';
        echo '</ul>';
        exit();
    } else {
        $member = $members[0];
        // パスワードの照合とログイン処理の実行
        if (password_verify($pass, $member['pass'])) {
            // セッションにログイン情報を格納
            $_SESSION['login_id'] = $member['id'];
            $_SESSION['name'] = $member['name'];
            header('Location: member.php');
            exit();
            
        } else {
            // パスワードが一致しない場合はログインフォームに戻る
            echo '<ul>';
            echo '<li>登録されたメールアドレスとパスワードが一致しませんでした</li>';
            echo '<li><a href="login.php">ログインフォームに戻る</a></li>';
            echo '</ul>';
            exit();
        }
    }
  
  } catch (PDOException $e) {
    // エラーハンドリング
    echo 'ログインに失敗しました。';
    echo '<a href="login.php">ログインフォームに戻る</a>';
    exit();
}


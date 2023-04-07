<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品データ登録</title>
    <style>
        .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 5px;
        }

        h1 {
        font-size: 36px;
        text-align: center;
        margin-bottom: 30px;
        }

        form {
        display: flex;
        flex-direction: column;
        align-items: center;
        }

        form p {
        font-size: 18px;
        margin-bottom: 10px;
        }

        form input[type="text"],
        form input[type="password"] {
        width: 100%;
        max-width: 400px;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        margin-bottom: 20px;
        }

        form input[type="submit"],
        form input[type="button"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        margin-bottom: 10px;
        }

        form input[type="submit"]:hover,
        form input[type="button"]:hover {
        background-color: #3e8e41;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>商品データ登録</h1>
    <form method="post" action="item_add_check.php" enctype="multipart/form-data">
        <p>商品名</p>
        <input type="text" name="name" style="width:300px" placeholder="商品名を入力してください">
        <p>価格：半角数字で入力</p>
        <input type="text" name="price" style="width:300px" placeholder="価格を入力してください">
        <p>登録する商品の画像を選択してください</p>
        <input type="file" name="img"><br>
        <input type="hidden" name="token">
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
</div>

<?php
session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['token'] = $token;
?>

</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>結合と検索画面</title>
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
      font-size: 14px;
      line-height: 1.5;
      margin: 0;
      padding: 0;
      text-align: center;
    }
    p {
      font-size: 16px;
      font-weight: bold;
    }
    form {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      margin: 20px auto;
      max-width: 500px;
      padding: 20px;
      text-align: center;
    }
    input[type="text"],input[type="password"] {
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
      font-family: inherit;
      font-size: 14px;
      padding: 10px;
      width: 100%;
    }
    input[type="submit"],input[type="button"] {
      background-color: #4CAF50;
      border: none;
      border-radius: 3px;
      color: #fff;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      padding: 10px;
      width: auto;
    }
    input[type="submit"]:hover,input[type="button"]:hover {
      background-color: #3e8e41;
    }
  </style>
</head>

<body>
  <h1>商品追加と検索</h1>
  <br>
  <form action="insert_check.php" method="post">
    <p>商品名を入力してください</p>
    <input type="text" name="name" style="width:300px" placeholder="スペース無しで入力">
    <p>単価を入力してください</p>
    <input type="text" name="price" style="width:200px" placeholder="半角数字で入力">
    <p>在庫を入力してください</p>
    <input type="text" name="stock" style="width:200px" placeholder="半角数字で入力">
    <br>
    <input type="hidden" name="token">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="送信">
  </form>

  <form action="search.php" method="post">
    <p>検索</p>
    <input type="text" name="keyword" style="width:200px" placeholder="検索ワードを入力">
    <input type="submit" value="検索">
  </form>
  
  <a href="inner.php">商品かつ単価情報一覧画面へ</a><br>
  <a href="left.php">商品情報優先一覧画面へ</a><br>
  <a href="right.php">単価情報優先一覧画面へ</a>

  <a href="../index.html">ポートフォリオ選択画面へ</a>
  <?php
  session_start();
  $token = bin2hex(random_bytes(32));
  $_SESSION['token'] = $token;
  ?>
  
</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員登録</title>
  <style>
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f5f5f5;
      border-radius: 10px;
      text-align: center;
    }
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #333;
    }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      font-size: 16px;
    }

    input[type="submit"],
    input[type="button"] {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-bottom: 10px;
    }
    input[type="submit"]:hover,
    input[type="button"]:hover {
      background-color: #555;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>会員登録フォーム</h1>
    <form method="post" action="sign_check.php">
      <label for="name">名前：</label>
      <input type="text" name="name" style="width:300px" placeholder="例）田中太郎">
      <label for="email">メールアドレス：</label>
      <input type="email" name="email" style="width:300px" placeholder="例）abcdefg-123456@example.com">
      <label for="tel">電話番号：</label>
      <input type="tel" name="tel" style="width:300px" placeholder="例）09011110000">
      <label for="pass">パスワード：</label>
      <input type="password" id="pass" name="pass" style="width:300px" placeholder="半角英数字を含めた6文字以上16文字以内">
      <input type="checkbox" onclick="showPassword()">
      <p>パスワードを表示する</p>
      <label for="pass">パスワード確認：</label>
      <input type="password" id="pass2" name="pass2" style="width:300px" placeholder="確認のためにもう一度入力してください">
      <input type="checkbox" onclick="showPassword2()">
      <p>確認パスワードを表示する</p>

      <?php
        // CSRFトークンの生成
        $token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $token;
      ?>
      <input type="hidden" name="token" value="<?php echo $token; ?>">
      <input type="submit" value="OK">
      <p><a href="sign_login.html">戻る</a></p>
    </form>

  </div>

  <script>
    function showPassword() {
      let pass = document.getElementById("pass");
      if (pass.type === "password") {
        pass.type = "text";
      } else {
        pass.type = "password";
      }
    }

    function showPassword2() {
      let pass2 = document.getElementById("pass2");
      if (pass2.type === "password") {
        pass2.type = "text";
      } else {
        pass2.type = "password";
      }
    }

    document.getElementById("show-password").addEventListener("change", function() {
      let pass = document.getElementById("pass");
      let pass2 = document.getElementById("pass2");
      if (this.checked) {
        pass.type = "text";
        pass2.type = "text";
      } else {
        pass.type = "password";
        pass2.type = "password";
      }
    });
  </script>
</body>
</html>
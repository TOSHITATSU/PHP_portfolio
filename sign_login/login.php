<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログインフォーム</title>
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
    <h1>ログインフォーム</h1>
    <form method="post" action="login_done.php">
      <label for="email">メールアドレス：</label>
      <input type="email" name="email" style="width:300px" placeholder="メールアドレス入力欄">
      <label for="pass">パスワード：</label>
      <input type="password" id="pass" name="pass" style="width:300px" placeholder="パスワード入力欄">
      <input type="checkbox" onclick="showPassword()">
      <p>パスワードを表示する</p>

      <?php
        // CSRFトークンの生成
        $token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $token;
      ?>
      <input type="hidden" name="token" value="<?php echo $token; ?>">
      <input type="submit" value="ログイン">
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

    document.getElementById("show-password").addEventListener("change", function() {
      let pass = document.getElementById("pass");
      if (this.checked) {
        pass.type = "text";
      } else {
        pass.type = "password";
      }
    });
  </script>

  
</body>
</html>
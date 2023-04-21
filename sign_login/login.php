<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>ログインフォーム</title>
</head>

<body>
  <div class="container">
      <h1 class="my-5 text-center">ログインフォーム</h1>
      <form method="post" action="login_done.php">
        <div class="mb-3">
          <label for="email" class="form-label">メールアドレス：</label>
          <input type="email" name="email" class="form-control" placeholder="メールアドレス入力欄">
        </div>
        <div class="mb-3">
          <label for="show-password" class="form-label">パスワード：</label>
          <div class="input-group">
            <input type="password" id="show-password" name="pass" class="form-control" placeholder="パスワード入力欄">
            <button class="btn btn-outline-secondary" type="button" data-toggle-pass="show-password">表示</button>
          </div>
        </div>
        <?php
          // CSRFトークンの生成
          $token = bin2hex(random_bytes(32));
          $_SESSION['token'] = $token;
        ?>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-primary">ログイン</button>
        <a href="sign_login.html" class="btn btn-secondary">戻る</a>
      </form>
    </div>

  <!-- クラスをインスタンス化しPasswordLoginTogglerクラスを呼び出し -->
  <script src="class/show_pass.js"></script>
  <script>
    const passwordToggler2 = new PasswordLoginToggler("show-password");
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
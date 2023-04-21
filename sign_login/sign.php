<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>会員登録</title>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-5">
      <h1 class="mb-5 text-center">会員登録フォーム</h1>
      <form method="post" action="sign_check.php">
        <div class="mb-3">
          <label for="name" class="form-label">名前：</label>
          <input type="text" name="name" class="form-control" placeholder="例）田中太郎">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">メールアドレス：</label>
          <input type="email" name="email" class="form-control" placeholder="例）abcdefg-123456@example.com">
        </div>
        <div class="mb-3">
          <label for="tel" class="form-label">電話番号：</label>
          <input type="tel" name="tel" class="form-control" placeholder="例）09011110000">
        </div>
        <div class="mb-3">
          <label for="show-password" class="form-label">パスワード：（半角英数字を含めた6文字以上16文字以内）</label>
          <div class="input-group">
            <input type="password" id="show-password" name="pass" class="form-control" placeholder="パスワード入力">
            <button class="btn btn-outline-secondary" type="button" data-toggle-pass="show-password">表示</button>
          </div>
        </div>
        <div class="mb-3">
          <label for="show-password2" class="form-label">パスワード確認：</label>
          <div class="input-group">
            <input type="password" id="show-password2" name="pass2" class="form-control" placeholder="パスワード確認">
            <button class="btn btn-outline-secondary" type="button" data-toggle-pass="show-password2">表示</button>
          </div>
        </div>
        <?php
          // CSRFトークンの生成
          $token = bin2hex(random_bytes(32));
          $_SESSION['token'] = $token;
        ?>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-primary">OK</button>
        <a href="sign_login.html" class="mt-3">戻る</a>
      </form>
    </div>
  </div>

  <script src="./class/show_pass.js"></script>
  <script>
    const passwordToggler = new PasswordSignToggler("show-password", "show-password2");
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>検索結果表示</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 1rem;
    }
    th,td {
      text-align: left;
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }
    th {
      color: #fff;
      background-color: #343a40;
      border-color: #454d55;
    }
  </style>
</head>
<body>
  <?php
  //検索フォームから入力された値の取得
  if(isset($_POST['keyword'])) {
    $keyword = '%'.$_POST['keyword'].'%';
  } else {
    $keyword = '';
  }
  
  $config = require_once 'config.php';
  $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
  $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
  );
  try {
    $pdo = new PDO($dsn, $config['user'], $config['dbpass'], $options);
  } catch (PDOException $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    echo '<a href="insert.php">トップメニューに戻る</a>';
    exit();
  }

  $sql = "SELECT `product`.`name`, `kanri`.`price`, `kanri`.`stock` 
          FROM `product` INNER JOIN `kanri` 
          ON `product`.`id` = `kanri`.`id` 
          WHERE `product`.`name` LIKE :keyword";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':keyword',$keyword);
  $stmt->execute();
  // 結果を取得し、表示する
  $results = $stmt->fetchAll();
  ?>

  <table>
    <thead>
      <caption>検索結果（<?php echo $stmt -> rowCount(); ?>件）</caption>
      <tr>
        <th>商品名</th>
        <th>単価</th>
        <th>在庫数</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars(number_format($row['price']) ?? '', ENT_QUOTES, 'UTF-8') ?>円</td>
          <td><?= htmlspecialchars($row['stock'] ?? '', ENT_QUOTES, 'UTF-8') ?>点</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
</table>

<?php
$stmt = null;
$pdo = null;
?>
</body>
</html>
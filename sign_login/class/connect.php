<?php
require_once 'db_config.php';

class DatabaseConnection {
  private $pdo;
  private $host;
  private $dbname;
  private $user;
  private $pass;

  public function __construct($host, $dbname, $user, $pass) {
    $this->host = DB_HOST;
    $this->dbname = DB_NAME;
    $this->user = DB_USER;
    $this->pass = DB_PASS;
  }

  public function connect() {
    $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
  }

  public function executeSelectQuery($query, $params = []) {
    // プリペアドステートメントの作成と実行
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);
    // 結果の取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  

  public function insertData($table, $name, $email, $tel, $pass) {
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    // INSERT文の作成と実行
    $query = "INSERT INTO $table (`name`, `email`, `tel`, `pass`) VALUES (:name, :email, :tel, :pass)";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':pass', $hashed_pass);
    $stmt->execute();
    // 結果の取得
    $result = $stmt->rowCount();
    return $result;
  }


  public function __destruct() {
    // PDOの切断
    $this->pdo = null;
  }
}


<?php

class FormValidator {
  private $name;
  private $email;
  private $tel;
  private $pass;
  private $pass2;
  private $errors;

  public function __construct($post_data) {
    $this->name = $post_data['name'] ?? '';
    $this->email = $post_data['email'] ?? '';
    $this->tel = $post_data['tel'] ?? '';
    $this->pass = $post_data['pass'] ?? '';
    $this->pass2 = $post_data['pass2'] ?? '';
    $this->errors = array();
  }

  public function validate_name() {
    if (!isset($this->name) || strlen($this->name) == 0) {
      $this->errors[] = '氏名を入力して下さい';
    } else {
      $this->name = htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
    }
  }

  public function validate_email() {
    if (!isset($this->email) || strlen($this->email) == 0) {
      $this->errors[] = 'メールアドレスを入力して下さい';
    } else {
      $this->email = htmlspecialchars($this->email, ENT_QUOTES, 'UTF-8');
    }
  }

  public function validate_tel() {
    if (!isset($this->tel) || strlen($this->tel) == 0) {
      $this->errors[] = '電話番号を入力して下さい';
    } else {
      $this->tel = htmlspecialchars($this->tel, ENT_QUOTES, 'UTF-8');
    }
  }

  public function validate_pass() {
    if (!isset($this->pass) || strlen($this->pass) == 0) {
      $this->errors[] = 'パスワードを入力して下さい';
    } else {
      $this->pass = htmlspecialchars($this->pass, ENT_QUOTES, 'UTF-8');
    }
  }

  public function validate_pass2() {
    if (!isset($this->pass2) || strlen($this->pass2) == 0) {
      $this->errors[] = '確認のためのパスワードを入力してください';
    } else {
      $this->pass2 = htmlspecialchars($this->pass2, ENT_QUOTES, 'UTF-8');
    }
  }

  public function validate_pass_match() {
    if ($this->pass !== $this->pass2) {
      $this->errors[] = 'パスワードが一致していません';
    }
  }

  public function preg_match_name() {
    if (!preg_match("/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]+$/u",$name)) {
      $this->errors[] = '名前を正しく入力してください';
    }
  }

  public function preg_match_email() {
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
      $this->errors[] = 'メールアドレスを正しく入力して下さい';
    }
  }

  public function preg_match_tel() {
    if (!preg_match("/^\d{2,5}-?\d{1,4}-?\d{4}$/", $tel)) {
      $this->errors[] = '電話番号を正しく入力して下さい';
    }
  }

  public function preg_match_pass1() {
    if (!preg_match("/^[a-zA-Z0-9]{6,16}$/",$pass)) {
      $this->errors[] = 'パスワードを正しく入力してください';
    }
  }

  public function preg_match_pass2() {
    if (!preg_match("/^[a-zA-Z0-9]{6,16}$/",$pass2)) {
      $this->errors[] = '確認パスワードを正しく入力してください';
    }
  }

  // usage
  if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_POST['token'])) {
    exit('直接アクセス禁止');
  }

  public function validate_sign() {
    $this->validate_name();
    $this->validate_email();
    $this->validate_tel();
    $this->validate_pass();
    $this->validate_pass2();
    $this->validate_pass_match();
    $this->preg_match_name();
    $this->preg_match_email();
    $this->preg_match_tel();
    $this->preg_match_pass();
    $this->preg_match_pass2();
    return $this->errors;
  }

  public function validate_login() {
    $this->validate_email();
    $this->validate_pass();
    $this->preg_match_email();
    $this->preg_match_pass();
  }

}


// $validator = new FormValidator($_POST);
// $errors = $validator->validate_all();
// $name = $validator->name;
// $email = $validator->email;
// $tel = $validator->tel;
// $pass = $validator->pass;
// $pass2 = $validator->pass2;
?>

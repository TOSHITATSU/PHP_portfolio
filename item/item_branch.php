<?php
// session_start();
// session_regenerate_id(true);
// if(isset($_SESSION['login'])==false)
// {
//     echo'ログインされていません。<br />';
//     echo'<a href="../staff_login/stf_login.html">ログイン画面へ</a>';
//     exit();
// }

if(isset($_POST['disp'])==true)
{
  if(isset($_POST['itemcode'])==false)
  {
    header('Location: item_ng.php');
    exit();
  }

  $item_code=$_POST['itemcode'];
  header('Location:item_disp.php?itemcode='.$item_code);
  exit();
}

if(isset($_POST['add'])==true)
{
    header('Location: item_add.php');
    exit();
}

if(isset($_POST['edit'])==true)
{
  //スタッフコードに何も入っていない場合、NG画面に飛ばす
    if(isset($_POST['itemcode'])==false)
    {
          header('Location: item_ng.php');
          exit();
    }

    $item_code=$_POST['itemcode'];
    header('Location:item_edit.php?itemcode='.$item_code);
    exit();
}

if(isset($_POST['delete'])==true)
{
  //スタッフコードに何も入っていない場合、NG画面に飛ばす
    if(isset($_POST['itemcode'])==false)
    {
      header('Location: item_ng.php');
      exit();
    }

    $item_code=$_POST['itemcode'];
    header('Location:item_delete.php?itemcode='.$item_code);
    exit();
}

?>

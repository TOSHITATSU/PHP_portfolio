<?php

if(isset($_POST['disp'])==true)
{
  if(isset($_POST['staffcode'])==false)
  {
    header('Location: stf_ng.php');
    exit();
  }

  $staff_code=$_POST['staffcode'];
  header('Location:stf_disp.php?staffcode='.$staff_code);
  exit();
}

if(isset($_POST['add'])==true)
{
    header('Location: stf_add.php');
    exit();
}

if(isset($_POST['edit'])==true)
{
  //スタッフコードに何も入っていない場合、NG画面に飛ばす
    if(isset($_POST['staffcode'])==false)
    {
          header('Location: stf_ng.php');
          exit();
    }

    $staff_code=$_POST['staffcode'];
    header('Location:stf_edit.php?staffcode='.$staff_code);
    exit();
}

if(isset($_POST['delete'])==true)
{
  //スタッフコードに何も入っていない場合、NG画面に飛ばす
    if(isset($_POST['staffcode'])==false)
    {
      header('Location: stf_ng.php');
      exit();
    }

    $staff_code=$_POST['staffcode'];
    header('Location:stf_delete.php?staffcode='.$staff_code);
    exit();
}

?>

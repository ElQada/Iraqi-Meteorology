<?php
require_once "../configuration/Connection.php";
$Time = intval(date('Hi'));
if (($Time > 800 && $Time < 1100))
{
    header('Location: ../courier.php');
}
/* الحضور */
// 08:00 => 09:30 AM
/* الإنصراف صباحى */
// 02:00 => 03:30 PM
/* الإنصراف مسائى */
// 08:00 => 09:30 PM

$message = "";
if (isset($_POST['AccountCode']))
{
    $RecordID = SetRecord(null, 'ABSENT', 'accounts','0',json_encode(['NameOrCode'=>$_POST['AccountCode']]),null,$_POST['AccountCode'].'@ABSENT@'.date('Y-m-d'));
    header('Location: ../courier.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>تـسـجـيـل الغـيـاب</title>
    <link rel="stylesheet" href="../css/icon.css">
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/elqada.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<style>
    #video, #canvas
    {
        border: 1px solid black;
        margin: 5px;
    }
</style>
<body>

<div class="login">
    <br>
    <div style="text-align: center;">
        <img src="../logo.png" title="logo" alt="logo" style="width: 120px; height: 120px;">
    </div>

    <br>

    <center><h3>نظام الرصد الجوي السطحي لمحطات العراق</h3></center>
    <center> <h2> تـسـجـيـل الغـيـاب </h2> </center>
    <center> <h5 style="color:red;"><?php echo $message; ?></h5> </center>

    <form method="post" autocomplete="off">

        <div class="Flex-2">
            <label for="AccountCode">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="AccountCode" placeholder="الأســم او الـكـود" id="AccountCode" required>

        </div>

        <input type="submit" value="تـسـجـيـل الغـيـاب">
    </form>
    <hr>
    <center>
        <a class="ui button green large" onclick="{location.href = CurrentLink;}"> رجـــوع </a>
    </center>
</div>
<script src="../js/sweetalert.min.js"></script>
<script src="../js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="../js/semantic.min.js"></script>
<script src="../js/elqada.js"></script>
<script src="../js/index.js"></script>
</body>

<script>
    var PHP = {};
    PHP.CurrentFile = "index";
</script>
</html>
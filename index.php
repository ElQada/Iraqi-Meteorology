<?php
require_once "configuration/Connection.php";

if (isset($_SESSION['Account']))
{
    header('Location: courier.php');
}


/*$Stations = MySqlX('SELECT * FROM `stations`',[],11,0);
//print_r(password_hash('1541950',PASSWORD_DEFAULT));
MySqlX("INSERT INTO `accounts` (`user`,`code`,`per`,`Station`,`_Key_`) VALUES (?,?,?,?,?)", ['IRAQ', '2025', 'admin', '1',password_hash('2025',PASSWORD_DEFAULT)], 'K');

foreach ($Stations as $Station) {
    $AccountID = MySqlX("INSERT INTO `accounts` (`user`,`code`,`per`,`Station`,`_Key_`) VALUES (?,?,?,?,?)", ['ADMIN-'.$Station['StationName'], 'admin'.$Station['StationCode'], 'manager', $Station['id'],password_hash('admin'.$Station['StationCode'],PASSWORD_DEFAULT)], 'K');
    $AccountID = MySqlX("INSERT INTO `accounts` (`user`,`code`,`per`,`Station`,`_Key_`) VALUES (?,?,?,?,?)", [$Station['StationName'], ''.$Station['StationCode'], 'user', $Station['id'],password_hash(''.$Station['StationCode'],PASSWORD_DEFAULT)], 'K');
}*/

$message = "";

if (isset($_POST['AccountCode'], $_POST['AccountKey']))
{
    if ($Get = MySqlX('SELECT * FROM `accounts` WHERE `code` = ? OR `user` = ?', [$_POST['AccountCode'],$_POST['AccountCode']], 0, 0))
    {
        if (password_verify(_REQUEST_('AccountKey'),$Get['_Key_']))
        {
            $_SESSION['per'] = $Get['per'];
            $_SESSION['Station'] = $Get['Station'];
            $_SESSION['Save-Station'] = $Get['Station'];
            $_SESSION['code'] = $Get['code'];
            $_SESSION['Monitor'] = $Get['user'];
            $_SESSION['Account'] = $Get['id'];
            $_SESSION['name'] = $_POST['AccountCode'];
            $_SESSION['Date'] = date('Y-m-d');
            if (isset($_POST['Remember']) && $_POST['Remember'])
            {
                setcookie('AccountCode', $_POST['AccountCode'], time() + 3600 * 24);
                setcookie('AccountKey', $_POST['AccountKey'], time() + 3600 * 24);
            }
            header('Location: courier.php');
            exit();
        }
        else
        {
            $message = "خطأ في كلمة المرور";
        }
    }
    else
    {
        $message = "خـطـأ فــي الأســــم او الــكـود";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>تـسـجـيـل الـدخـول للـنـظـام</title>
    <link rel="stylesheet" href="css/icon.css">
    <link rel="stylesheet" href="css/semantic.min.css">
    <link rel="stylesheet" href="css/elqada.css">
    <link rel="stylesheet" href="css/index.css">
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
        <img src="logo.png" title="logo" alt="logo" style="width: 150px; height: 150px;">
    </div>
    <br>

    <center><h3>نظام الرصد الجوي السطحي لمحطات العراق</h3></center>
    <center> <h2>  تـسـجـيـل الـدخـول للـنـظـام </h2> </center>
    <center> <h5 style="color:red;"><?php echo $message; ?></h5> </center>

    <form method="post" autocomplete="off">

        <div class="Flex-2">
            <label for="AccountCode">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="AccountCode" placeholder="الأســم او الـكـود" id="AccountCode" oninput="this.value = this.value.toUpperCase();" value="<?= _COOKIE_('AccountCode'); ?>" autocomplete="off" data-content="0123456789-QWERTYUIOPASDFGHJKLZXCVBNM_qwertyuiopasdfghjklzxcvbnm" required>

        </div>

        <div class="Flex-2" style="margin-top: 10px;">
            <label for="AccountKey">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="AccountKey" placeholder="كلمة المرور" id="AccountKey" value="<?= _COOKIE_('AccountKey'); ?>" autocomplete='off' required>
        </div>

        <br>
        <div id="All-Remember">
            <label for="Remember"> تــذكـــرني </label>
            <input value="1" type="checkbox" name="Remember" id="Remember"/>
        </div>

        <input type="submit" value="تـسـجـيـل الـدخـول للـنـظـام">
    </form>
</div>
<script src="js/sweetalert.min.js"></script>
<script src="js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="js/semantic.min.js"></script>
<script src="js/elqada.js"></script>
<script src="js/index.js"></script>
</body>

<script>
    var PHP = {}, TimeOut = null;
    PHP.CurrentFile = "index";

    document.getElementById('AccountKey').addEventListener('keyup',(Event)=>{
        if (TimeOut)
        {
            clearTimeout(TimeOut);
        }

        TimeOut = setTimeout(()=>{
            if (Event.target.value.length > 2)
            {
                Request('Request/GetAccountName.php?Code='+Event.target.value,(Response)=>{
                    if (Response.Name.length)
                    {
                        SetElementValue('AccountCode',Response.Name);
                    }
                });
            }
        },631);
    });
</script>
</html>
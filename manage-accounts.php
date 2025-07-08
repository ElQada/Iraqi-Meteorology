<?php
$Title = "إدارة الـمـوظـفـيـن";
$CurrentFile = "manage-accounts";
require_once "configuration/Header.php";
$Station = $_SESSION['Station'];
$Limit = 200;
$Type = _TYPE_;
$Role = _ROLE_;
$Roles = ['Else','Forecasting','Awos','admin','manager','station','user'];
$Code = $_SESSION['code'];

$Message = [
    'TopTitle' => "إدارة الـمـوظـفـيـن",
    'BottomTitle' => "بـيــانــات الـمـوظـفـيـن",
];

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_REQUEST)) {
    require_once("configuration/Connection.php");

    $AccountName = _REQUEST_('AccountName');
    $AccountType = _REQUEST_('AccountType');
    $AccountCode = _REQUEST_('AccountCode');
    $_Key_       = password_hash(_REQUEST_('AccountKey'),PASSWORD_DEFAULT);
    if ($Role == 'admin'||($Role == 'manager' && $AccountType == 'user')||$AccountCode == $Code)
    {
        if (isset($_REQUEST['AddAccounts'])) {
            if ($AccountID = MySqlX('SELECT `id` FROM `accounts` WHERE `code` = ? AND `Station` = ?',[$AccountCode,$Station],0))
            {
                if (MySqlX("UPDATE `accounts` SET `user` = ?, `_Key_` = ? WHERE `code` = ?", [strtoupper($AccountName),$_Key_,$AccountCode], 'R')) {
                    Message(' تم بنجاح تعديل المستخدم ');
                    SetRecord($Station, 'UPDATE', 'accounts',$AccountID['id'],'');
                }
            }
            elseif ($AccountID = MySqlX("INSERT INTO `accounts` (`user`, `code`,`per`,`Station`,`_Key_`) VALUES (?,?,?,?,?)", [strtoupper($AccountName),$AccountCode, $AccountType, $_SESSION['Station'],$_Key_], 'K')) {
                Message(' تم بنجاح اضافة المستخدم ');
                SetRecord($Station, 'INSERT', 'accounts',$AccountID,'');
            }
        }
        if (isset($_REQUEST['DeleteAccounts'])) {
            $OldAccount = MySqlX("SELECT * FROM `accounts` WHERE `code` = ?", [$AccountCode], 0);
            if ($AccountCode != $Code && MySqlX("DELETE FROM `accounts` WHERE `code` = ? AND `id` != '1'", [$AccountCode], 'R')) {
                Message(' تم بنجاح حذف المستخدم ');
                SetRecord($Station, 'DELETE', 'accounts',$OldAccount['id'],json_encode($OldAccount,256));
            } else {
                Message(' لا يمكن هذا المستخدم ');
            }
        }
    }
}

if ($Role == 'admin') {
    $Users = MySqlX('SELECT `id`,`Station`,`code`,`per`,`user` FROM `accounts` ORDER BY `id` DESC',[],11);
}
elseif ($Role == 'manager') {
    $Users = MySqlX('SELECT `id`,`Station`,`code`,`per`,`user` FROM `accounts` WHERE (`per` = ? OR `id` = ?) AND `station` = ? ORDER BY `id` DESC',['user',$_SESSION['Account'],$_SESSION['Save-Station']],11);
}
else
{
    $Users = MySqlX('SELECT `id`,`Station`,`code`,`per`,`user` FROM `accounts` WHERE `id` = ? ORDER BY `id` DESC',[$_SESSION['Account']],11);
    $Message = [
        'TopTitle' => "إدارة الـحـسـاب",
        'BottomTitle' => "بـيــانــات الـحـســاب",
    ];
}

?>

    <div class="ui segment">
        <div class="ui segment">
            <div class="Title"><?=$Message['BottomTitle']?></div>
            <div class="ui Over">
                <div id="Data-Table-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Data-Table" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
    </div>

    <form class="ui form" action="" autocomplete="off" id="Form">
        <div class="ui container center aligned">
            <div class="ui segment center">
                <div class="Title"><?=$Message['TopTitle']?></div>

                <div class="Flex-2">
                    <div class="Information_Item">
                        <label for="User"> قــائـمــة الــمــوظــفـيـن </label>
                        <select name="User" id="User" class="Select _TOP_" style="min-width: 190px; cursor: pointer;" onchange="SelectUser()">
                            <option value="*" selected>الــمــوظــف</option>
                            <?php
                                foreach ($Users as $User)
                                {
                                    echo "<option value='{$User['id']}'>{$User['user']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="Information_Item">
                        <label for="AccountType"> صــلاحــيــات الـمــوظــف </label>
                        <select name="AccountType" id="AccountType" class="Select _TOP_" style="min-width: 190px; cursor: pointer;">
                            <option value="user" selected> User - مـوظـف محطة </option>
                            <?php if ($Role === 'admin'){?>
                                <option value="manager"> Manager - مدير محطة</option>
                                <option value="Forecasting">Forecasting</option>
                                <option value="Awos">Awos</option>
                                <option value="admin">Admin - مدير عام</option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="Information_Item">
                        <label for="Station"> الـمـحـطـة </label>
                        <div class="ui input">
                            <select id="Station" class="Select" name="Station" onchange="{ STtName('manage-stations'); }" style="min-width: 190px;">
                                <option disabled>  الـمـحـطـة</option>
                                <?php Stations('manage-stations'); ?>
                            </select>
                        </div>
                    </div>

                    <div class="Information_Item">
                        <label for="AccountCode"> كـــود الــمــوظــف </label>
                        <input type="text" name="AccountCode" id="AccountCode" placeholder="كـــود الــمــوظــف" value="" class="Select _TOP_" autocomplete="off">
                    </div>
                    <div class="Information_Item">
                        <label for="AccountName"> أســم الــمــوظــف </label>
                        <input type="text" name="AccountName" oninput="this.value = this.value.toUpperCase();" id="AccountName" placeholder="اسم الــمــوظــف" value="" class="Select _TOP_" style="min-width: 195px; cursor: pointer;" autocomplete="off">
                    </div>
                    <div class="Information_Item">
                        <label for="AccountKey" style="background-color: #db2828"> مفتاح المرور </label>
                        <input type="password" name="AccountKey" id="AccountKey" placeholder="مفتاح المرور"  value="" class="Select _TOP_" style="min-width: 185px; cursor: pointer;" autocomplete="off">
                    </div>
                </div>

                <br>

                <input type="submit" class="ui red button large" id="DeleteAccounts" name="DeleteAccounts" value="مسح">
                <input class="ui orange button large" type="submit" id="AddAccounts" name="AddAccounts" value="أضافة / تعديل المستخدم">
            </div>
        </div>
    </form>

    <script>
        var $Users = <?=json_encode($Users)?>;
        var $CurrentStation    = <?=json_encode(GetCurrentStation())?>;
        var $GetCurrentAccount = <?=json_encode(GetCurrentAccount())?>;
    </script>

<?php
require_once "configuration/Footer.php";
?>
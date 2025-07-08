<?php
require_once "Components/BackupDB.php";
$Type = _TYPE_;
$Role = _ROLE_;
GetDateFromTo($From, $To);
if ($Role == 'admin')
{
    $Stations = MySqlX('SELECT * FROM `stations` WHERE `id` NOT IN (42,43) ORDER BY `StationCode`',[],11);
}
else
{
    $Stations = MySqlX('SELECT * FROM `stations` WHERE `id` NOT IN (42,43) AND `id` = ?',[_SESSION_('Station',1)],11);
}
if ((isset($_POST['Event_Export']) || isset($_POST['Event_Export_Download'])) && isset($_POST['Tables']) && count($_POST['Tables']) > 0 && isset($_POST['Stations']) && count($_POST['Stations']) > 0)
{
    try
    {
        Success(BackupDB::Export("From_$From@To_$To@".join('@', $_POST['Tables'])."@Stations_".count($_POST['Stations']), $_POST['Tables'],isset($_POST['Event_Export_Download']),[
            //"_var_"=> "المتغيرات",
            //"accounts"=> "بيانات الدخول",
            "courier"=> "Station IN(".join(',',$_POST['Stations']).") AND `date` BETWEEN '$From' AND '$To'",
            "daily"=> "Station IN(".join(',',$_POST['Stations']).") AND `date` BETWEEN '$From' AND '$To'",
            //"employee"=> "الترفيعات",
            //"forecast"=> "السورى",
            //"forecast2"=> "السورى",
            //"history"=> "الترفيعات",
            //"job_grades"=> "الترفيعات",
            //"jobs"=> "الترفيعات",
            //"locations"=> "الترفيعات",
            //"metar"=> "Station IN(".join(',',$_POST['Stations']).")",
            //"monitors"=> "الرصاد",
            //"penalties"=> "الترفيعات",
            //"qualifications"=> "الترفيعات",
            //"stations"=> "محطات الرصد",
            //"synop"=> "Station IN(".join(',',$_POST['Stations']).") AND `date` BETWEEN '$From' AND '$To'",
            //"test_clouds"=> "أطلس الغيوم",
            //"test_weather"=> "الظواهر الجوية",
            //"user"=> "الترفيعات",
            //"users"=> "المستخدمين",
            //"weather_printer_state"=> "السورى",
        ]));
    }
    catch (Exception $e)
    {
        Error($e->getMessage());
    }
}
elseif(isset($_POST['File']))
{
    try
    {
        if (isset($_POST['Event_Import']) && ($Type != 'Online' || true))
        {
            $Tables = explode('@',$_POST['File']);
            BackupDB::Import($_POST['File'],array_splice($Tables,3,-1));
            Success($_POST['File']);
        }
        elseif (isset($_POST['Event_Download']))
        {
            BackupDB::Download('Out/'.$_POST['File']);
            Success($_POST['File']);
        }
        elseif (isset($_POST['Event_Delete']))
        {
           Success(unlink('Out/'.$_POST['File'])?'تم حذف الملف':'الملف غير موجود' );
        }
    }
    catch (Exception $e)
    {
        Error($e->getMessage());
    }
}
elseif (isset($_FILES['Event_File']) && ($Type != 'Online' || true))
{
    $Extension  = explode('.',$_FILES['Event_File']['name']);
    $Extension = strtolower(end($Extension));
    if (!$_FILES['Event_File']['error'] && $Extension == 'sql' && $_FILES['Event_File']['size'] > 0 && $_FILES['Event_File']['size'] < 134217728 && $_FILES['Event_File']['type'] == 'application/octet-stream' && mime_content_type($_FILES['Event_File']['tmp_name']) == 'text/plain')
    {
        $File = $_FILES['Event_File']['name'];
        $Upload = move_uploaded_file($_FILES['Event_File']['tmp_name'], 'Out/'.$File);
        $Tables = explode('@',$File);
        Success($Upload?'تم رفع الملف بنجاح':'الملف موجود مسبقا بنفس الأسم يمكنك حذف الملف القديم اولا');
        if ($Upload)
        {
            try {
                BackupDB::Import($File, array_splice($Tables, 3, -1));
            } catch (Exception $e) {
                Error($e->getMessage());
            }
        }
    }
    else
    {
        Error('أختر ملف صحيح');
    }
}
/* ------------------------------------------------------------------------------------------------------------------ */
$Title = "البيانات";
$CurrentFile = "backup";
require_once "configuration/Header.php";
?>

<form class="ui form" autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="ui container center aligned segment">
        <div class="Title Flex-1">
            <div> لأحــــة الأســتــراد </div>
            <?php if (($Type != 'Online' || true)){?>
                <input type="submit" id="Event_Submit" name="Event_Submit" value="block" style="display: none;">
                <input type="button" id="Event_Upload" name="Event_Upload" onclick="{document.getElementById('Event_File').click()}" value="  رفــع + مــع + أسـتـيـراد " class="ui violet button large">
                <input type="file" name="Event_File" id="Event_File" accept=".sql" style="display: none;" onchange="{document.getElementById('Event_Submit').click()}">
                <input type="submit" id="Event_Import" name="Event_Import" value="  أستيراد " class="ui green button large">
            <?php } ?>
            <input type="submit" id="Event_Download" name="Event_Download" value="  تحميل " class="ui violet button large">
            <input type="submit" id="Event_Delete" name="Event_Delete" value="  حذف " class="ui red button large">
        </div>
        <div id="Files">
            <?php
            foreach (array_reverse(BackupDB::Scan()) as $File)
            {
                $Values = explode('@',$File);
                foreach ($Values as $Key => $Value) {
                    if (isset(BackupDB::$Tables[$Value]))
                    {
                        $Values[$Key] = BackupDB::$Tables[$Value];
                    }
                    elseif ($Value == '.sql')
                    {
                        unset($Values[$Key]);
                    }
                    elseif (strpos($Value,'From_') === 0)
                    {
                        $Values[$Key]  = str_replace('From_',' من فترة : ',$Value);
                    }
                    elseif (strpos($Value,'To_') === 0)
                    {
                        $Values[$Key]  = str_replace('To_',' إلى فترة : ',$Value);
                    }
                    elseif (strpos($Value,'Stations_') === 0)
                    {
                        $Values[$Key]  = str_replace('Stations_',' عدد المحطات : ',$Value);
                    }
                    elseif (strlen($Value) == 10)
                    {
                        $Values[$Key] .= ' : التاريخ ';
                    }
                    else
                    {
                        $Values[$Key] .= ' : التوقيت ';
                    }
                }
                echo '<div class="List" style="width: 100%;"><div class="ui slider checkbox" style="width: 100%;"><input type="radio" name="File" value="'.$File.'" id="'.$File.'"><label for="'.$File.'" style="cursor: pointer;"><div class="Flex-1">';
                foreach ($Values as $Key => $Value) {
                    echo '<div class="List">'.$Value.'</div>';
                }
                echo '</div></label></div></div>';
            }
            ?>
        </div>
    </div>
</form>
<br>
<form class="ui form" autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="ui container center aligned segment">
        <div class="Title Flex-1">
            <div> لائـحـة الـتـصـديـر </div>
            <?php require_once "Top/".$CurrentFile.".php"; ?>
            <input type="submit" id="Event_Export_Download" name="Event_Export_Download" value="  تـصـديـر  + مــع +  تـحـمـيـل " class="ui default button large">
            <input type="submit" id="Event_Export" name="Event_Export" value="  تـصـديـر " class="ui default button large">
        </div>
        <div class="Title" style="width: max-content"> <label class="List" onclick="SelectAll('Stations',true)"> تحديد الكل <i class="fas fa-check-double"></i> </label> - Select Stations - <label class="List" onclick="SelectAll('Stations',false)"> ألغاء تحديد الكل <i class="fas fa-times-circle"></i> </label> </div>
        <div id="Stations">
            <?php
            foreach ($Stations as $Value) {
                echo '<div class="List"><div class="ui checked checkbox"><input type="checkbox" name="Stations[]" value="'.$Value['id'].'" id="'.$Value['id'].'"><label for="'.$Value['id'].'" style="cursor: pointer;">'.$Value['StationName'].' - '.$Value['StationCode'].' </label></div></div>';
            }
            ?>
        </div>
        <hr><div class="Title" style="width: max-content">  <label class="List" onclick="SelectAll('Tables',true)">  تحديد الكل <i class="fas fa-check-double"></i> </label> - Select Tables - <label class="List" onclick="SelectAll('Tables',false)"> ألغاء تحديد الكل  <i class="fas fa-times-circle"></i> </label> </div>
        <div id="Tables">
            <?php
            foreach (BackupDB::$Tables as $Key => $Value) {
                echo '<div class="List"><div class="ui toggle checkbox"><input type="checkbox" name="Tables[]" value="'.$Key.'" id="'.$Key.'"><label for="'.$Key.'" style="cursor: pointer;">'.' معلومات : '.$Value.' </label></div></div>';
            }
            ?>
        </div>
    </div>
</form>

<?php
require_once "configuration/Footer.php";
?>


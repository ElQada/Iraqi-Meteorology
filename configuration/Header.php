<?php
if (!isset($CurrentFile))  { $CurrentFile = 'index'; }
if (!isset($Title)) { $Title = ''; }
require_once("configuration/Connection.php");
$Type = _TYPE_;
$Role = _ROLE_;
if (!isset($_SESSION['name'])) { header("Location: index.php"); }

$LoadDataTable = in_array($CurrentFile,
    [
        'Test-Clouds','table-synop',"show-daily",'repeat-clouds',"show-courier","monthly-weather",
        'month-daily','daily-rh',"month-courier","show-temperature","monthly-cloud","monthly-tntntn",'phenomena-weather',
        'reports','history','manage-stations','manage-accounts'
    ]);

if (in_array($Type,['Local','Online']))
{
    if ($Role == 'Forecasting')
    {
        $Pages = [
            "synop"=> "Synop",
            "show-synop"=> "مركز تجميع المعلومات",
            "show-temperature"=> "درجات الحرارة اليومية",
            "show-awos"=> "مطارات العراق",
            "table-synop"=> "متابعة المحطات",
            "phenomena-weather"=> "الظواهر الجوية",
            "Test-Clouds"=> "أطلس الغيوم",
            "history"=> "السجل",
        ];
        $Redirect = 'synop';
    }
    elseif ($Role == 'Awos')
    {
        $Pages = [
            "show-awos"=> "مطارات العراق",
            //"Show-Mater" => "عرض الميتار",
            //"Mater-Reports" => "Mater-Reports",
        ];
        $Redirect = 'show-awos';
    }
    elseif ($Role == 'admin')
    {
        $Pages =
            [
                'backup' => "<i class='fa fa-database'></i>",
                "courier"=> "الرصد الساعي",
                "show-courier"=> "العرض الساعي",
                "month-courier"=> "المعدلات اليومية والشهرية للرصد الساعي",
                "daily-monitoring"=> "الرصد اليومي",
                "show-daily"=> "العرض اليومي",
                "month-daily"=> "المعدلات الشهرية للرصد اليومى",
                "monthly-tntntn"=> "موجات البرد وموجات الحر",
                "monthly-cloud"=> "المعدلات اليومية والشهرية للغيوم",
                "daily-rh"=> "أعلى و أقل رطوبة نسبية",
                "repeat-clouds"=> "تكرارات أرتفاع الغيوم",
                "monthly-weather"=> "تكرارات الظواهر الجوية",
                "manage-stations"=> "إدارة الـمـحـطـات",
                "manage-accounts"=> "إدارة الـمـوظـفـيـن",
                "reports"=> "التقارير",
                "history"=> "السجل",
            ];
        $Redirect = 'reports';
    }
    elseif ($Role == 'manager')
    {
        $Pages =
            [
                'backup' => "<i class='fa fa-database'></i>",
                "courier"=> "الرصد الساعي",
                "show-courier"=> "العرض الساعي",
                "month-courier"=> "المعدلات اليومية والشهرية للرصد الساعي",
                "daily-monitoring"=> "الرصد اليومي",
                "show-daily"=> "العرض اليومي",
                "month-daily"=> "المعدلات الشهرية للرصد اليومى",
                "monthly-tntntn"=> "موجات البرد وموجات الحر",
                "monthly-cloud"=> "المعدلات اليومية والشهرية للغيوم",
                "daily-rh"=> "أعلى و أقل رطوبة نسبية",
                "repeat-clouds"=> "تكرارات أرتفاع الغيوم",
                "monthly-weather"=> "تكرارات الظواهر الجوية",
                "manage-stations"=> "إدارة الـمـحـطـات",
                "manage-accounts"=> "إدارة الـمـوظـفـيـن",
                "reports"=> "التقارير",
                "history"=> "السجل",
            ];
        $Redirect = 'reports';
    }
    elseif ($Role == 'user')
    {
        $Pages = [
            //"synop"=> "Synop",
            "courier"=> "الرصد الساعي",
            "show-courier"=> "العرض الساعي",
            "daily-monitoring"=> "الرصد اليومي",
            "show-daily"=> "العرض اليومي",
            //"show-awos"=> "مطارات العراق",
            //"table-synop"=> "متابعة المحطات",
            "show-temperature"=> "درجات الحرارة اليومية",
            //"phenomena-weather"=> "الظواهر الجوية",
            //"Test-Clouds"=> "أطلس الغيوم",
            //"reports"=> "التقارير",
            "manage-accounts"=> "إدارة حــســابــى",
            "history"=> "سـجـل عـمـلـى",
        ];
        $Redirect = 'courier';
    }
    else
    {
        $Pages = [
            //"synop"=> "Synop",
            "courier"=> "الرصد الساعي",
            "show-courier"=> "العرض الساعي",
            "daily-monitoring"=> "الرصد اليومي",
            "show-daily"=> "العرض اليومي",
            //"show-awos"=> "مطارات العراق",
            //"table-synop"=> "متابعة المحطات",
            "show-temperature"=> "درجات الحرارة اليومية",
            //"phenomena-weather"=> "الظواهر الجوية",
            //"Test-Clouds"=> "أطلس الغيوم",
            //"reports"=> "التقارير",
            "history"=> "السجل",
        ];
        $Redirect = 'courier';
    }
}
elseif (in_array($Type,['Offline','']))
{
    if ($Role == 'Forecasting')
    {
        $Pages = [
            "synop"=> "Synop",
            "show-synop"=> "مركز تجميع المعلومات",
            "show-temperature"=> "درجات الحرارة اليومية",
            "show-awos"=> "مطارات العراق",
            "table-synop"=> "متابعة المحطات",
            "phenomena-weather"=> "الظواهر الجوية",
            "Test-Clouds"=> "أطلس الغيوم",
            "history"=> "السجل",
        ];
        $Redirect = 'synop';
    }
    elseif ($Role == 'Awos')
    {
        $Pages = [
            "show-awos"=> "مطارات العراق",
            //"Show-Mater" => "عرض الميتار",
            //"Mater-Reports" => "Mater-Reports",
        ];
        $Redirect = 'show-awos';
    }
    elseif ($Role == 'admin')
    {
        $Pages =
            [
                'backup' => "<i class='fa fa-database'></i>",
                "courier"=> "الرصد الساعي",
                "show-courier"=> "العرض الساعي",
                "month-courier"=> "المعدلات اليومية والشهرية للرصد الساعي",
                "daily-monitoring"=> "الرصد اليومي",
                "show-daily"=> "العرض اليومي",
                "month-daily"=> "المعدلات الشهرية للرصد اليومى",
                "monthly-tntntn"=> "موجات البرد وموجات الحر",
                "monthly-cloud"=> "المعدلات اليومية والشهرية للغيوم",
                "daily-rh"=> "أعلى و أقل رطوبة نسبية",
                "repeat-clouds"=> "تكرارات أرتفاع الغيوم",
                "monthly-weather"=> "تكرارات الظواهر الجوية",
                "manage-stations"=> "إدارة الـمـحـطـات",
                "manage-accounts"=> "إدارة الـمـوظـفـيـن",
                "reports"=> "التقارير",
                "history"=> "السجل",
            ];
        $Redirect = 'reports';
    }
    elseif ($Role == 'manager')
    {
        $Pages =
            [
                'backup' => "<i class='fa fa-database'></i>",
                "courier"=> "الرصد الساعي",
                "show-courier"=> "العرض الساعي",
                "month-courier"=> "المعدلات اليومية والشهرية للرصد الساعي",
                "daily-monitoring"=> "الرصد اليومي",
                "show-daily"=> "العرض اليومي",
                "month-daily"=> "المعدلات الشهرية للرصد اليومى",
                "monthly-tntntn"=> "موجات البرد وموجات الحر",
                "monthly-cloud"=> "المعدلات اليومية والشهرية للغيوم",
                "daily-rh"=> "أعلى و أقل رطوبة نسبية",
                "repeat-clouds"=> "تكرارات أرتفاع الغيوم",
                "monthly-weather"=> "تكرارات الظواهر الجوية",
                "manage-stations"=> "إدارة الـمـحـطـات",
                "manage-accounts"=> "إدارة الـمـوظـفـيـن",
                "reports"=> "التقارير",
                "history"=> "السجل",
            ];
        $Redirect = 'reports';
    }
    elseif ($Role == 'user')
    {
        $Pages = [
            //"synop"=> "Synop",
            "courier"=> "الرصد الساعي",
            "show-courier"=> "العرض الساعي",
            "daily-monitoring"=> "الرصد اليومي",
            "show-daily"=> "العرض اليومي",
            //"show-awos"=> "مطارات العراق",
            //"table-synop"=> "متابعة المحطات",
            "show-temperature"=> "درجات الحرارة اليومية",
            //"phenomena-weather"=> "الظواهر الجوية",
            //"Test-Clouds"=> "أطلس الغيوم",
            //"reports"=> "التقارير",
            "manage-accounts"=> "إدارة حــســابــى",
            "history"=> "سـجـل عـمـلـى",
        ];
        $Redirect = 'courier';
    }
    else
    {
        $Pages = [
            //"synop"=> "Synop",
            "courier"=> "الرصد الساعي",
            "show-courier"=> "العرض الساعي",
            "daily-monitoring"=> "الرصد اليومي",
            "show-daily"=> "العرض اليومي",
            //"show-awos"=> "مطارات العراق",
            //"table-synop"=> "متابعة المحطات",
            "show-temperature"=> "درجات الحرارة اليومية",
            //"phenomena-weather"=> "الظواهر الجوية",
            //"Test-Clouds"=> "أطلس الغيوم",
            //"reports"=> "التقارير",
            "history"=> "السجل",
        ];
        $Redirect = 'courier';
    }
}

if (!in_array($CurrentFile, array_keys($Pages))) { header("Location: $Redirect.php"); }
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="stylesheet" href="css/semantic.min.css">
    <link rel="stylesheet" href="css/elqada.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <?php if ($LoadDataTable) { ?>
        <link rel="stylesheet" href="css/datatables.min.css">
        <link rel="stylesheet" href="css/elqada_datatable.css">
    <?php } ?>

    <?php if (file_exists("css/$CurrentFile.css")): ?>
        <link rel="stylesheet" href="css/<?php echo $CurrentFile; ?>.css">
    <?php endif; ?>

    <title><?php echo $Pages[$CurrentFile]; ?></title>

    <script src="js/jquery-3.7.1.min.js"></script>
    <?php if ($LoadDataTable) { ?>
        <script src="js/datatables.min.js"></script>
        <script src="js/elqada_datatable.js"></script>
    <?php } ?>
    <script src="js/jquery-ui.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/semantic.min.js"></script>
    <script src="js/jquery.tablesort.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/elqada.js"></script>

    <?php if (in_array($CurrentFile,['show-awos'])) { ?>
        <script src="js/charts.js"></script>
    <?php } ?>
</head>
<script>
    var PHP = {};
</script>
<body class="center _Center_" style="align-content: baseline;">
<div id="Nav">
    <?php foreach ($Pages as $Href => $Text){?>
        <a class="large ui blue button" id="Nav_<?=$Href?>" href="<?=$Href?>.php"><?=$Text?></a>
    <?php } ?>
    <a class="large ui red button" id="Exit" href="Request/logout.php"><i class="fas fa-times-circle"></i></a>
</div>

<div class="ui center aligned">
    <div id="Header"> نظام الرصد الجوي السطحي لمحطات العراق
        <p id="timestamp"><?= date( 'H:i:s' )?></p>
    </div>
</div>
<br>
<div id="Messages">
    <div id="Message-TestCloud"></div>
    <div id="Message-TestWeather"></div>
    <div id="Message-TestMonth"></div>
    <div id="Message-BackUp"></div>
</div>
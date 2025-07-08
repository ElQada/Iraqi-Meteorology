<?php
/*
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Request;
*/
use Symfony\Component\HttpFoundation\BinaryFileResponse;


use Symfony\Component\Finder\Finder;

use Ifsnop\Mysqldump\Mysqldump;

require 'vendor/autoload.php';
require_once "configuration/Connection.php";

class BackupDB
{
    static $Tables = [
        "courier"=> "الرصد الساعي",
        "daily"=> "الرصد اليومي",
/*
        "accounts"=> "بيانات الدخول",
        "stations"=> "محطات الرصد",
        "users"=> "المستخدمين",
        "_var_"=> "المتغيرات",
        "employee"=> "الترفيعات",
        "forecast"=> "السورى",
        "forecast2"=> "السورى",
        "history"=> "الترفيعات",
        "job_grades"=> "الترفيعات",
        "jobs"=> "الترفيعات",
        "locations"=> "الترفيعات",
        "metar"=> "الميتار",
        "monitors"=> "الرصاد",
        "penalties"=> "الترفيعات",
        "qualifications"=> "الترفيعات",
        "synop"=> "السينوب",
        "test_clouds"=> "أطلس الغيوم",
        "test_weather"=> "الظواهر الجوية",
        "user"=> "الترفيعات",
        "weather_printer_state"=> "السورى",
*/
    ];

    static function Initialize()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
    }

    /**
     * @throws Exception
     */
    static function Export($Name, $Tables = null,$Download = false,$Wheres = [])
    {
        self::Initialize();
        if (is_null($Tables)) {
            $Tables = array_keys(self::$Tables);
        }
        $BackUp = new Mysqldump('mysql:host=' . DataBase['Host'] . ';dbname=' . DataBase['Name'], DataBase['User'], DataBase['Pass'],[
            'include-tables' => $Tables,
            'no-create-info' => true,
            'add-locks' => false,
            'lock-tables' => false,
            'complete-insert' => false,
            'extended-insert' => false,

            'insert-ignore' => true,

            'single-transaction' => false,
            'skip-triggers' => true,
            'skip-tz-utc' => true,
            'skip-comments' => true,
            'skip-dump-date' => true,
            'skip-definer' => true,
            //'default-character-set' => Mysqldump::UTF8MB4,
            //'if-not-exists' => true,
            //'add-drop-table' => true,
            //'no-create-info	' => true,
            //'complete-insert' => true,
            //'extended-insert' => true,
            //'skip-tz-utc' => true,
        ]);
        $BackUp->setTableWheres($Wheres);
        $BackUp->setTransformTableRowHook(function($tableName, $row) {
            if (isset($row['id'])) {
                $row['id'] = null;
            }
            return $row;
        });
        $File = 'Out/'."$Name@".date('Y-m-d@H-i-s').'@.sql';
        if (is_file($File)) {
            unlink($File);
        }
        $BackUp->start($File);
        if ($Download) {
            self::Download($File);
        }
        return $File;
    }

    static function Download($File)
    {
        $response = new BinaryFileResponse($File);
        $response->setContentDisposition(\Symfony\Component\HttpFoundation\ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        $response->send();
    }
    /**
     * @throws Exception
     */
    static function Import($File,$Tables = null)
    {
        self::Initialize();

        if (!is_file('Out/'.$File))
        {
            return null;
        }

        if (is_null($Tables))
        {
            $Tables = array_keys(self::$Tables);
        }
        //self::DropTables(array_map(function ($Table){ return $Table.'_old';},$Tables));
        //self::RenameTables(array_map(function ($Table){ return "$Table TO $Table".'_old';},$Tables));
        //self::CopyTables($Tables);
        $BackUp = new Mysqldump('mysql:host=' . DataBase['Host'] . ';dbname=' . DataBase['Name'], DataBase['User'], DataBase['Pass'],[
            'include-tables' => $Tables,
            'no-create-info' => true,
            'add-locks' => false,
            'lock-tables' => false,
            'complete-insert' => false,
            'extended-insert' => false,

            'insert-ignore' => true,

            'single-transaction' => false,
            'skip-triggers' => true,
            'skip-tz-utc' => true,
            'skip-comments' => true,
            'skip-dump-date' => true,
            'skip-definer' => true,

            // 'default-character-set' => Mysqldump::UTF8MB4,
            // 'if-not-exists' => true,
            // 'add-drop-table' => true,
            // 'no-create-info	' => true,
            // 'complete-insert' => true,
            // 'extended-insert' => true,
            // 'skip-tz-utc' => true,

        ]);
        $BackUp->restore('Out/'.$File);

        return $File;
    }

    static function Scan($Name = null)
    {
        $Finder = new Finder();
        $Files = [];
        if (!is_null($Name)) {
            foreach ($Finder->files()->in('Out')->name('*.sql')->name("*$Name*")->sortByChangedTime() as $File)
            {
                $Files[] = $File->getRelativePathname();
            }
        }
        else
        {
            foreach ($Finder->files()->in('Out')->name('*.sql')->sortByChangedTime() as $File)
            {
                $Files[] = $File->getRelativePathname();
            }
        }

        return $Files;
    }
    static function GetTables()
    {
        return MySqlX('SHOW TABLES',[],7);
    }

    static function RenameTables($Rename)
    {
        if (is_array($Rename))
        {
            $Rename = join(' , ',$Rename);
        }
        return MySqlX('RENAME TABLE '.$Rename,[],7);
    }
    static function DropTables($Drop)
    {
        if (is_array($Drop))
        {
            $Drop = join(' , ',$Drop);
        }
        return MySqlX('DROP TABLE IF EXISTS '.$Drop,[],7);
    }

    static function CopyTables($Copy)
    {
        self::DropTables(array_map(function($Table){ return $Table.'_backup'; },$Copy));
        foreach ($Copy as $Table)
        {
            MySqlX("CREATE TABLE ".$Table."_backup LIKE $Table; INSERT INTO ".$Table."_backup SELECT * FROM $Table;",[],'R');
        }
        return $Copy;
    }
}
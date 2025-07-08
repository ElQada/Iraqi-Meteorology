<?php
$Title = "Mater-Reports";
$CurrentFile = "Mater-Reports";
require_once("configuration/Connection.php");
require_once "Components/SimpleXLSXGen.php";
use Shuchkin\SimpleXLSXGen;

if (isset($_REQUEST["Mater"])) {
    if(date('d') === '02')
    {
        MySqlX('DELETE FROM `metar` WHERE `Update` LIKE ?',[date('Y-m', strtotime('-1 month'))."%"],'R');
    }

    $DateFromTo = '';

    GetDateFromTo($From,$To);

    if ($_REQUEST["Mater"] === 'ALL')
    {
        $DateFromTo = "WHERE DATE_FORMAT(`Update`, '%Y-%m-%d') BETWEEN '$From' AND '$To'";
        $Database = MySqlX("SELECT `Code` AS `Airport`,`Key` AS `Date`,`Value` AS `Metar` FROM `metar` $DateFromTo ORDER BY `Code`, `Key` ASC",[],11,null);
        $Name = "Airport-Mater-All-".substr($From,0,10).'-'.substr($To,0,10);
    }
    else
    {
        $DateFromTo = "AND DATE_FORMAT(`Update`, '%Y-%m-%d') BETWEEN '$From' AND '$To'";
        $Database = MySqlX("SELECT `Code` AS `Airport`,`Key` AS `Date`,`Value` AS `Metar` FROM `metar` WHERE `Code` = ? $DateFromTo ORDER BY `Code`, `Key` ASC",[$_REQUEST['Mater']],11,null);
        $Name = "Airport-Mater-".$_REQUEST['Mater']."-".substr($From,0,10).'-'.substr($To,0,10);
    }
    SimpleXLSXGenEditCellSaveFile($Database,$Name,['Metar'=>95],null,function ($V,$K)
    {
        if ($K === 'Metar')
        {
            if ($V === 'NULL')
            {
                return SimpleXLSXGenEditCell($V,14,"#FF0000", "#FFFFFF",'medium',20,true,false);
            }
            return SimpleXLSXGenEditCell(str_replace("\n",'',$V),14,"#000000", "#FFFFFF",'medium',20,true,false);
        }
        return SimpleXLSXGenEditCell($V);
    });
    exit();
}

?>

<?php
require_once "configuration/Header.php";
?>
    <form>
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="ui container center aligned">
            <div class="ui segment">
                <h1>Mater Reports</h1>
                <input class="large ui blue button" name="Mater" type="submit" value="ORBI">
                <input class="large ui blue button" name="Mater" type="submit" value="ORNI">
                <input class="large ui blue button" name="Mater" type="submit" value="ORMM">
                <input class="large ui blue button" name="Mater" type="submit" value="ORKK">
                <input class="large ui blue button" name="Mater" type="submit" value="ORER">
                <input class="large ui blue button" name="Mater" type="submit" value="ORSU">
                <input class="large ui blue button" name="Mater" type="submit" value="ORBM">
                <input class="large ui secondary button" name="Mater" type="submit" value="ALL">
            </div>
        </div>
    </form>
<?php
require_once "configuration/Footer.php";
?>
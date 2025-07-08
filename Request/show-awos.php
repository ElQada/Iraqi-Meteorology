<?php
if (isset($_REQUEST['Request']))
{
    require_once('index.php');
}
if (!isset($_REQUEST['Station']))
{
    $_REQUEST['Station'] = "BAGHDAD";
}

$Get = MySqlX("SELECT `id` FROM `stations` WHERE `StationName` = ? AND `id` NOT IN (42,43) LIMIT 1",[$_REQUEST['Station']],0);
$Station = null;
if ($Get && isset($Get['id']))
{
    $Station = $Get['id'];
}
$Values = ["Present"=>"","DD"=>"","TNTNTN"=>"","RH"=>"","FF"=>"","Metar"=>"","TAF"=>"","VV"=>"","Max"=>"","SN1"=>"","SN2"=>"","TDTDTD"=>"","TTT"=>"","POPOPOPO"=>"","PPPP"=>"","Low"=>"","High"=>"","Medium"=>""];
$IDCodes = ["BAGHDAD"=>"ORBI","ERBEEL"=>"ORER","MOSUL"=>"ORBM","SULAIMANIYA AIRPORT"=>"ORSU","BASRA AIRPORT"=>"ORMM","NAJAF"=>"ORNI","KIRKUK AIRPORT"=>"ORKK"];
$Date = date('Y-m-d');
if ($Station)
{
    $Return = MySqlX('SELECT * FROM `courier` WHERE `Station` = ? AND `date` = ? ORDER BY `id` DESC LIMIT 1',[$Station,$Date],0);
    if ($Return)
    {
        $Max = MySqlX('SELECT `max` FROM `courier` WHERE `Station` = ? AND `date` = ? AND ( `time` = ? OR `time` = ?) ORDER BY `max` DESC LIMIT 1',[$Station,$Date,'12','15'],0);
        $TNTNTN = Get_TNTNTN($Date,$Return['time'],$Station);
        if (in_array($Return['SN1'],[1,'-','1']))
        {
            $Values['TTT'] = '-'.$Return['TTT']." C";
        }
        else
        {
            $Values['TTT'] = $Return['TTT']." C";
        }
        /* ---------------------------------------------- */
        if (in_array($Return['SN2'],[1,'-','1']))
        {
            $Values['TDTDTD'] = '-'.$Return['TDTDTD']." C";
        }
        else
        {
            $Values['TDTDTD'] = $Return['TDTDTD']." C";
        }
        /* ---------------------------------------------- */
        if ($TNTNTN)
        {
            if (in_array($Return['SN3'],[1,'-','1']))
            {
                $Values['TNTNTN'] = '-'.$TNTNTN." C";
            }
            else
            {
                $Values['TNTNTN'] = $TNTNTN." C";
            }
        }
        /* ---------------------------------------------- */
        $Values['DD']  = $Return['DD'];
        $Values['RH']  = $Return['RH'].' %';
        $Values['FF']  = $Return['FF'];
        /* ---------------------------------------------- */
        if ($Max && strlen($Max['max']))
        {
            $Values['Max'] = $Max['max']." C";
        }
        /* ---------------------------------------------- */
        $Values['POPOPOPO'] = $Return['P0P0P0P0']." hpa";
        $Values['PPPP'] = $Return['PPPP']." HPA";
        /* ---------------------------------------------- */
        if ($Return['VV'] == 60)
        {
            $Values['VV'] = "CAVOK";
        }
        elseif (!$Return['VV'])
        {
            $Values['VV'] = "0000";
        }
        /* ---------------------------------------------- */
        elseif (in_array($Return["VV"],[56,57,58,59]))
        {
            $Values['VV'] = ($Return["VV"]%50)*1000;
        }
        else
        {
            $Values['VV'] = $Return['VV']*100;
        }
        while (strlen($Values['VV'])<4)
        {
            $Values['VV'] = '0'.$Values['VV'];
        }
        if ($Values['VV'] !== 'CAVOK')
        {
            $Values['VV'] .= ' m';
        }
        /* ---------------------------------------------- */
        if(!$Return['NH']&&!$Return['CL']&&!$Return['CM']&&$Return['CH'])
        {
            $Values['High'] = 'NSC';
        }

        if($Return['NH']&&!$Return['CL']&&$Return['CM']&&!$Return['CH'])
        {
            $Values['Medium'] = 'NSC';
        }

        if($Return['NH']&&$Return['CL']&&!$Return['CM']&&!$Return['CH'])
        {
            $Values['Low'] = 'NSC';
        }
    }
}
/* ---------------------------------------------- */
$Values['Metar'] = @file_get_contents('https://aviationweather.gov/api/data/metar?ids='.$IDCodes[$_REQUEST['Station']]);
$Code = date('d').date('H')."00Z";
/* ---------------------------------------------- */
if (!$Values['Metar'] || strlen($Values['Metar'])<15)
{
    $Values['Metar'] = "NULL";
};
/* ---------------------------------------------- */
$Insert = MySqlX("INSERT INTO `metar` (`Station`,`Code`,`Key`,`Value`) VALUES (?,?,?,?)", [$Station, $IDCodes[$_REQUEST['Station']], $Code, $Values['Metar']], 'K',null);
$Values['Insert'] = $Insert;
if (is_object($Insert))
{
    $Update = MySqlX("UPDATE `metar` SET `Value` = ? WHERE `Station` = ? AND `Code` = ? AND `Key` = ?", [ $Values['Metar'],$Station, $IDCodes[$_REQUEST['Station']], $Code], 'R',null);
    $Values['Update'] = $Update;
}
/* ---------------------------------------------- */
if ($Values['Metar']&&strlen($Values['Metar'])>15)
{
    $Metar = explode(' ',$Values['Metar']);
    /* ---------------------------------------------- */
    $Values['DD'] = substr($Metar[2],0,3);
    $Values['FF'] = substr($Metar[2],3,2)." KT";
    /* ---------------------------------------------- */
    if ($Metar[3] === 'CAVOK')
    {
        $Values['VV'] = 'CAVOK';
    }
    elseif (strrpos($Metar[3],'V'))
    {
        if ($Metar[4] === 'CAVOK')
        {
            $Values['VV'] = 'CAVOK';
        }
        else
        {
            $Values['VV'] = $Metar[4]." m";
        }
    }
    else
    {
        $Values['VV'] = $Metar[3]." m";
    }
    /* ---------------------------------------------- */
    $TDP = 4;
    if (isset($Metar[5])&&strrpos($Metar[5],'/'))
    {
        $TDP = 5;
    }
    elseif (isset($Metar[6])&&strrpos($Metar[6],'/'))
    {
        $TDP = 6;
    }
    elseif (isset($Metar[7])&&strrpos($Metar[7],'/'))
    {
        $TDP = 7;
        $Values['Low'] = $Metar[4]." ".$Metar[5]." ".$Metar[6];
    }

    $Values['TTT'] = str_replace('M','-',explode('/',$Metar[$TDP])[0])." C";
    $Values['TDTDTD'] = str_replace('M','-',explode('/',$Metar[$TDP])[1])." C";
    $Values['PPPP'] = substr($Metar[$TDP+1],1,4)." HPA";
}
$Values['TAF'] = @file_get_contents('https://aviationweather.gov/api/data/taf?ids='.$IDCodes[$_REQUEST['Station']]);

if (isset($_REQUEST['Request']))
{
    echo json_encode($Values);
}
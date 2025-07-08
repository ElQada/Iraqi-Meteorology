<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
$Keys = ["station","year","month","day","hour","ir","ix","h","vv","n","dd","ff","ttt","tdtdtd","popopopo","pppp","a","ppp","rrr","tr","ww","w1w2","nh","cl","cm","ch","ind","sn3","tntntn","e","sss","ns1","c1","hshs1","ns2","c2","hshs2","ns3","c3","hshs3","rb","rb1","wb","df","uu","vp","","","","","","",""];

$XK = [];
foreach ($Keys as $K => $V) {
    $XK[$V] = $K;
}
//print_r($XK);
/* ------------------------------------------------------------------------------------------------------------------ */
$Stations = MySqlX("SELECT * FROM `stations`",[],11);
$XS = [];
foreach ($Stations as $Station) {
    $XS[$Station["StationCode"]] = intval($Station["id"]);
}
//print_r($XS);
/* ------------------------------------------------------------------------------------------------------------------ */
function ReFormat($Number,$Before,$After = 0,$Array = [], $Only = false)
{
    $Number = str_replace([" ","+"],"",$Number);
    $Number = str_replace("--","-",$Number);

    $Find = array_search($Number,$Array);
    if (is_int($Find))
    {
        return $Array[$Find];
    }

    if ($After)
    {
        $Number = floatval($Number);
        if ($Before)
        {
            $Before += $After+1;
        }
    }
    else
    {
        $Number = intval($Number);
    }

    $Number = str_pad(number_format($Number,$After,'.',''), $Before, '0', STR_PAD_LEFT);

    $Find = array_search($Number,$Array);
    if (is_int($Find))
    {
        return $Array[$Find];
    }

    if ($Only || $Number == '')
    {
        return '';
    }

    return $Number;
}
//print_r(ReFormat('3',2,2,['2','//'],true));
/* ------------------------------------------------------------------------------------------------------------------ */
function SetData($XD)
{
    global $XK, $XS;
    foreach ($XD as $XR)
    {
        $Row = [];
        $Row[':Station'] = $XS[$XR[$XK['station']]]??0;
        $Row[':Account'] = 1;
        $Row[':name'] = 'Admin';
        $Row[':date'] = ReFormat($XR[$XK['year']],0,0,['2024','2023','2022','2021','2020','2019'],true)."-".ReFormat($XR[$XK['month']],2,0,['01','02','03','04','05','06','07','08','09','10','11','12'],true)."-".ReFormat($XR[$XK['day']],2,0,['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],true);
        $Row[':time'] = ReFormat($XR[$XK['hour']],2,0,['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],true);
        $Row[':max'] = '';
        $Row[':min'] = '';

        $Row[':VP'] = ReFormat($XR[$XK['vp']],2,1);
        $Row[':RH'] = ReFormat($XR[$XK['uu']],2,0);
        $Row[':WB'] = ReFormat($XR[$XK['wb']],2,1);

        $Row[':HSHS3'] = ReFormat($XR[$XK['hshs3']],2,0,['//']);
        $Row[':HSHS2'] = ReFormat($XR[$XK['hshs2']],2,0,['//']);
        $Row[':HSHS1'] = ReFormat($XR[$XK['hshs1']],2,0,['//']);

        $Row[':C3'] = ReFormat($XR[$XK['c3']],1,0);
        $Row[':C2'] = ReFormat($XR[$XK['c2']],1,0);
        $Row[':C1'] = ReFormat($XR[$XK['c1']],1,0);

        $Row[':NS3'] = ReFormat($XR[$XK['ns3']],1,0);
        $Row[':NS2'] = ReFormat($XR[$XK['ns2']],1,0);
        $Row[':NS1'] = ReFormat($XR[$XK['ns1']],1,0);



        $Row[':SSS'] = ReFormat($XR[$XK['sss']],3,0);
        $Row[':E'] = ReFormat($XR[$XK['e']],1,0);

        $Row[':TNTNTN'] = ReFormat($XR[$XK['tntntn']],2,1);
        $Row[':SN3'] = (($Row[':TNTNTN'])?'+':'-');
        $Row[':TNTNTN'] = str_replace(['+', '-'], '', $Row[':TNTNTN']);

        $Row[':TDTDTD'] = ReFormat($XR[$XK['tdtdtd']],2,1);
        $Row[':SN2'] = (($Row[':TDTDTD'])?'+':'-');
        $Row[':TDTDTD'] = str_replace(['+', '-'], '', $Row[':TDTDTD']);

        $Row[':TTT'] = ReFormat($XR[$XK['ttt']],2,1);
        $Row[':SN1'] = (($Row[':TTT'])?'+':'-');
        $Row[':TTT'] = str_replace(['+', '-'], '', $Row[':TTT']);


        $Row[':HALF'] = ReFormat($XR[$XK['ind']],1,0,['1','2'],true);

        $Row[':CH'] = ReFormat($XR[$XK['ch']],1,0,['/']);
        $Row[':CM'] = ReFormat($XR[$XK['cm']],1,0,['/']);

        $Row[':CL'] = ReFormat($XR[$XK['cl']],1,0);
        $Row[':NH'] = ReFormat($XR[$XK['nh']],1,0);

        $Row[':W1W2'] = ReFormat($XR[$XK['w1w2']],2,0);
        $Row[':WW'] = ReFormat($XR[$XK['ww']],2,0);
        $Row[':TR'] = ReFormat($XR[$XK['tr']],1,0);


        $Row[':RRR'] = ReFormat($XR[$XK['rrr']],3,0);
        $Row[':PPP'] = ReFormat($XR[$XK['ppp']],3,0);
        $Row[':A'] = ReFormat($XR[$XK['a']],1,0);

        $Row[':PPPP'] = ReFormat($XR[$XK['pppp']],4,1);
        $Row[':P0P0P0P0'] = ReFormat($XR[$XK['popopopo']],4,1);

        $Row[':FF'] = ReFormat($XR[$XK['ff']],2,0);
        $Row[':DD'] = ReFormat($XR[$XK['dd']],3,0);
        $Row[':N'] = ReFormat($XR[$XK['n']],1,0);
        $Row[':VV'] = ReFormat($XR[$XK['vv']],2,0);
        $Row[':H'] = ReFormat($XR[$XK['h']],1,0);
        $Row[':IX'] = ReFormat($XR[$XK['ix']],1,0);
        $Row[':IR'] = ReFormat($XR[$XK['ir']],1,0);

        $Success = MySqlX("INSERT INTO `courier`(`Station`,`Account`,`name`,`date`,`time`,`IR`,`IX`,`H`,`VV`,`N`,`DD`,`FF`,`SN1`,`TTT`,`SN2`,`TDTDTD`,`P0P0P0P0`,`PPPP`,`A`,`PPP`,`RRR`,`TR`,`WW`,`W1W2`,`NH`,`CL`,`CM`,`CH`,`HALF`,`SN3`,`TNTNTN`,`E`,`SSS`,`NS1`,`C1`,`HSHS1`,`NS2`,`C2`,`HSHS2`,`NS3`,`C3`,`HSHS3`,`WB`,`RH`,`VP`,`min`,`max`) VALUES (:Station,:Account,:name,:date,:time,:IR,:IX,:H,:VV,:N,:DD,:FF,:SN1,:TTT,:SN2,:TDTDTD,:P0P0P0P0,:PPPP,:A,:PPP,:RRR,:TR,:WW,:W1W2,:NH,:CL,:CM,:CH,:HALF,:SN3,:TNTNTN,:E,:SSS,:NS1,:C1,:HSHS1,:NS2,:C2,:HSHS2,:NS3,:C3,:HSHS3,:WB,:RH,:VP,:min,:max)",$Row,'R',null);
        if(!$Success)
        {
            file_put_contents('error_courier.txt', "['".join("','",array_values($Row))."'],\n", FILE_APPEND);
        }
    }
}
/* ------------------------------------------------------------------------------------------------------------------ */
$Data = [

];
/* ------------------------------------------------------------------------------------------------------------------ */
SetData($Data);
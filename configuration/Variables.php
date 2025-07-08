<?php
$Type = _TYPE_;
$Role = _ROLE_;

if (!isset($CurrentFile))
{
    $CurrentFile = 'Else';
}

$CurrentTime = explode(':', date('H:i:s'));
$EditTime = strtotime('0 day');

function CurrenData($CurrentFile)
{
    if ($CurrentFile == 'daily-monitoring' || $CurrentFile == 'show-daily')
    {
        return _SESSION_('daily',date('Y-m-d'));
    }
    else
    {
        return _SESSION_('Date',date('Y-m-d'));
    }
}

$SelectDate = CurrenData($CurrentFile);

$_SESSION['SelectDate'] = $SelectDate;
if (intval($CurrentTime[0]) === 23 && intval($CurrentTime[1]) >= 45)
{
    if (isset($CurrentFile) && in_array($CurrentFile, ["daily-monitoring", "show-daily"]))
    {
        $SelectDate = _SESSION_('daily',date('Y-m-d'));
    }
    else
    {
        $EditTime = strtotime('1 day');
        $SelectDate = _SESSION_('Date',date('Y-m-d', $EditTime));
    }
}

if (isset($CurrentFile) && in_array($CurrentFile, ["daily-monitoring", "show-daily"]))
{
    $EditTime = strtotime('-1 day');
    $SelectDate = _SESSION_('daily',date('Y-m-d', $EditTime));
}

$CurrentDate = date('Y-m-d');
$MaxDate = date('Y-m-d',$EditTime);
if ($Role == 'admin')
{
    $MinDate = "2024-08-01";
}
else
{
    $EditTime = strtotime('-1 month');
    $MinDate = date('Y-m-d',$EditTime);
}
$_SelectDate_ = explode('-', $SelectDate);
$_SESSION['MinDate'] = $MinDate;
$_SESSION['MaxDate'] = $MaxDate;

if (empty($_SESSION['SelectDate']) || strtotime($_SESSION['SelectDate']) < strtotime($MinDate) || strtotime($_SESSION['SelectDate']) > strtotime($MaxDate))
{
    $Change = false;
    if (strtotime($SelectDate) < strtotime($MinDate))
    {
        $SelectDate = $MinDate;
        $Change = true;
    }

    if (strtotime($SelectDate) > strtotime($MaxDate))
    {
        $SelectDate = $MaxDate;
        $Change = true;
    }
    $_SESSION['SelectDate'] = $SelectDate;
    if ($Change && isset($CurrentFile))
    {
        if ($CurrentFile == 'daily-monitoring' || $CurrentFile == 'show-daily')
        {
            $_SESSION['daily'] = $SelectDate;
        }
        else
        {
            $_SESSION['Date'] = $SelectDate;
        }
    }
}
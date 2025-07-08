<?php

use Shuchkin\SimpleXLSXGen;

function SimpleXLSXGenEditCell($Text, $FontSize=14, $FontColor="#000000", $BackgroundColor="#FFFFFF", $Border="medium", $Height = 20, $Middle = true, $Center = true, $Bold = true, $Wrap = true)
{
    if ($Wrap)
    {
        $Text = "<wraptext> $Text </wraptext>";
    }
    $Text = '<style height="'.$Height.'" font-size="'.$FontSize.'" color="'.$FontColor.'" bgcolor="'.$BackgroundColor.'" border="'.$Border.'" > '.$Text.' </style>';
    if ($Bold)
    {
        $Text = "<b> $Text </b>";
    }
    if ($Center)
    {
        $Text = "<center> $Text </center>";
    }
    if ($Middle)
    {
        $Text = "<middle> $Text </middle>";
    }
    return $Text;
}

function SimpleXLSXGenEditCellSaveFile($Database, $Name, $Width = [],$Keys = null,$Row = null)
{
    $Data = [];
    if ($Database && count($Database) > 0)
    {
        if (!is_array($Keys))
        {
            $SetKeys = [];
            foreach ($Database[0] as $Key => $Value)
            {
                if (is_callable($Keys))
                {
                    $SetKeys[] = $Keys($Key,$Value);
                }
                else
                {
                    $SetKeys[] = SimpleXLSXGenEditCell($Key,14,"#FFFFFF","#2185D0");
                }
            }
            $Data[] = $SetKeys;
        }
        else
        {
            $Data[] = $Keys;
        }

        for ($I=0; $I<count($Database); $I++)
        {
            $SetRow = [];
            foreach ($Database[$I] as $K => $V)
            {
                if (is_callable($Row))
                {
                    $SetRow[$K] = $Row($V,$K);
                }
                else
                {
                    $SetRow[$K] = SimpleXLSXGenEditCell($V);
                }
            }
            $Data[] = $SetRow;
        }
    }

    $Alphabet = explode('-',"A-B-C-D-E-F-G-H-I-J-K-L-M-N-O-P-Q-R-S-T-U-V-W-X-Y-Z");
    $Download = SimpleXLSXGen::fromArray($Data);
    $Count = count($Data);
    $Index = 0;
    if ($Count>0)
    {
        $Index = count($Data[1]);
        $I = 1;
        foreach ($Data[1] as $K => $V)
        {
            $SetWidth = _VAR_($Width,$K,(((intval((strlen($V)/10) + (strlen($K)/5)))+(intval((strlen($K)/10) + (strlen($V)/5))))/2));
            $Download->setColWidth($I++,$SetWidth);
        }
    }

    if ($Index<26)
    {
        $Download->autoFilter('A1:'.$Alphabet[$Index].$Count);
    }
    elseif ($Index<52)
    {
        $Download->autoFilter('A1:A'.$Alphabet[$Index-26].$Count);
    }
    else
    {
        $Download->autoFilter('A1:B'.$Alphabet[$Index-52].$Count);
    }
    $Download->freezePanes('A2');

    $Download->downloadAs($Name. ".xlsx");
}
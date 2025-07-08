<?php
if (00)
{
    $Dir = "Download/";
    $FileName   = "2024.csv";
    $Lines = file($Dir.$FileName);
    $LinesPerFile = 25000;
    $Total = count($Lines);
    $FileIndex = 1;

    for ($Index = 0; $Index < $Total; $Index += $LinesPerFile) {
        file_put_contents($Dir.($FileIndex++).'@'.$FileName, implode("", array_slice($Lines, $Index, $LinesPerFile)));
    }
}
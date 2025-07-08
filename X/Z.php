<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
function SetData()
{
    $Uppers = ["Additions","Attendances","Backups","Classes","Courses","Departments","Events","Files","Financials","Grades","Groups","Information_s","Keys","Languages","Messages","Notifications","Permissions","Records","Roles","Schedules","Sessions","Topics","Users"];
    $Lowers = ["additions","attendances","backups","classes","courses","departments","events","files","financials","grades","groups","information_s","keys","languages","messages","notifications","permissions","records","roles","schedules","sessions","topics","users"];
    $Upper = ["Addition","Attendance","Backup","Class","Course","Department","Event","File","Financial","Grade","Group","Information","Key","Language","Message","Notification","Permission","Record","Role","Schedule","Session","Topic","User"];
    $Lower = ["addition","attendance","backup","class","course","department","event","file","financial","grade","group","information","key","language","message","notification","permission","record","role","schedule","session","topic","user"];

    for ($i = 0; $i < count($Uppers); $i++)
    {
        $File = "\nMySql.Select.Keys =  async function (SelectID = null) {return await SendRequest(API+'keys/'+((SelectID)?SelectID:''), 'GET');};\nMySql.Insert.Keys =  async function (NewKey = {}) {return await SendRequest(API+'keys/', 'POST',NewKey);};\nMySql.Update.Keys =  async function (SelectID = null,UpdateKey = {}) {return await SendRequest(API+'keys/'+SelectID, 'PUT',UpdateKey);};\nMySql.Delete.Keys =  async function (SelectID = null) {return await SendRequest(API+'keys/'+SelectID, 'DELETE');};\n";
        $File = str_replace('Keys', $Uppers[$i], $File);
        $File = str_replace('Key', $Upper[$i], $File);
        $File = str_replace('keys', $Lowers[$i], $File);
        $File = str_replace('key', $Lower[$i], $File);
        echo $File;
    }
}
/* ------------------------------------------------------------------------------------------------------------------ */

/* ------------------------------------------------------------------------------------------------------------------ */
SetData();
// + 10 years   //
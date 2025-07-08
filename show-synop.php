<?php
$Title = "مركز تجميع المعلومات";
$CurrentFile = "show-synop";
require_once "configuration/Header.php";
?>

    <form class="ui form" autocomplete="off" method="POST">
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <textarea name="synop" id="synop" style="width: 96%; min-height: 400px; resize: none;text-align: start;text-align-last: start;font-size: 24px;padding: 20px;font-family: monospace;"></textarea>
        <div class="ui container center aligned">
            <div class="ui segment">
                <div class="ui Over">
                    <div style="overflow: auto;"> </div>
                </div>
            </div>
        </div>
    </form>

    <div class="ui container center aligned" style="display: none;">
        <div class="ui segment Station_Information">
            <input type="hidden" id="FileName" name="FileName" value="FileName.txt">
            <div onclick="Download(GetElementValue('FileName'),GetElementValue('synop'))" style="margin: 6px 4px; display: none;" class="large ui blue button"> اصدار ملف Text </div>
            <div onclick="CopyText(GetElementValue('synop'))" style="margin: 6px 4px;" class="large ui blue button"> Data Copy </div>
            <div onclick="SentEmailLink('orbi@ftp13.irimo.ir',GetElementValue('FileName'),elqada.$X.$O.Synop.Print.replaceAll('\n','<br>'))" style="margin: 6px 4px; display: none;" class="large ui blue button"> Data Send </div>
        </div>
    </div>

<?php
require_once "configuration/Footer.php";
?>
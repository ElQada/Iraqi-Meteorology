<?php
require_once "../configuration/Connection.php";
$Time = intval(date('Hi'));
if (($Time > 1400 && $Time < 1600))
{
    header('Location: ../courier.php');
}
/* الحضور */
// 08:00 => 09:30 AM
/* الإنصراف صباحى */
// 02:00 => 03:30 PM
/* الإنصراف مسائى */
// 08:00 => 09:30 PM

$message = "";
if (isset($_POST['AccountCode'], $_POST['image']))
{
    if (strlen($_POST['image'])>25)
    {
        $imageData = $_POST['image'];
        $RecordID = SetRecord(null, 'LOGOUT', 'accounts','0',json_encode(['NameOrCode'=>$_POST['AccountCode'],'File'=>$imageData]),null,$_POST['AccountCode'].'@LOGOUT@'.date('Y-m-d'));
        header('Location: ../courier.php');
        exit();
    }
    else
    {
        $message = "من فضلك افتح الكاميرة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>تسجيل خـــروج ( إنــصــراف )</title>
    <link rel="stylesheet" href="../css/icon.css">
    <link rel="stylesheet" href="../css/semantic.min.css">
    <link rel="stylesheet" href="../css/elqada.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<style>
    #video, #canvas
    {
        border: 1px solid black;
        margin: 5px;
    }
</style>
<body>

<div class="login">
    <br>
    <div style="text-align: center;">
        <img src="../logo.png" title="logo" alt="logo" style="width: 120px; height: 120px;">
    </div>

    <br>

    <center><h3>نظام الرصد الجوي السطحي لمحطات العراق</h3></center>
    <center> <h2>  تسجيل خـــروج ( إنــصــراف ) </h2> </center>
    <center> <h5 style="color:red;"><?php echo $message; ?></h5> </center>

    <form method="post" autocomplete="off" onsubmit="{captureImage();}">

        <div>
            <video id="video" width="222" height="166" autoplay></video>
            <br>
            <div class="Flex-2" style="display: none;">
                <button type="button" id="capture">Capture</button>
                <button type="button" id="stop">Stop</button>
                <button type="button" id="start">Start</button>
            </div>
        </div>

        <div class="Flex-2">
            <label for="AccountCode">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="AccountCode" placeholder="الأســم او الـكـود" id="AccountCode" required>

        </div>

        <input type="hidden" value="" name="image" id="image">


        <div>
            <canvas id="canvas" width="222" height="166" style="display: none;"></canvas>
        </div>
        <input type="submit" value="تسجيل خـــروج ( إنــصــراف )">
    </form>
    <hr>
    <center>
        <a class="ui button green large" onclick="{location.href = CurrentLink;}"> رجـــوع </a>
    </center>
</div>
<script src="../js/sweetalert.min.js"></script>
<script src="../js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="../js/semantic.min.js"></script>
<script src="../js/elqada.js"></script>
<script src="../js/index.js"></script>
</body>

<script>
    var PHP = {};
    PHP.CurrentFile = "index";

    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('capture');
    const stopBtn = document.getElementById('stop');
    const startBtn = document.getElementById('start');

    let stream = null;

    // Access the camera
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });
            video.srcObject = stream;
        } catch (err) {
            console.error("Error accessing camera: ", err);
            alert("Could not access the camera. Please make sure you've granted permission.");
        }
    }

    function captureImage()
    {
        if (!stream) return;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        document.getElementById('image').value = canvas.toDataURL("image/png");
        //document.getElementById('image').value = encodeURIComponent(canvas.toDataURL("image/png"));
    }

    function stopCamera()
    {
        if (stream)
        {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
            stream = null;
        }
    }
    captureBtn.addEventListener('click', captureImage);
    stopBtn.addEventListener('click', stopCamera);
    startBtn.addEventListener('click', startCamera);
    startCamera();

    document.getElementById('AccountKey').addEventListener('keyup',(Event)=>{
        Request('GetAccountName.php?Code='+Event.target.value,(Response)=>{
            if (Response.Name.length)
            {
                SetElementValue('AccountCode',Response.Name);
            }
        });
    });
</script>
</html>
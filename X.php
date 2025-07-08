<?php
if(isset($_POST['image'])){
    $imageData = $_POST['image'];
    $imageData = str_replace("data:image/png;base64,", "", $imageData);
    $imageData = base64_decode($imageData);

    file_put_contents("canvas_image.png", $imageData); // Save the image
    echo "Image saved successfully.";
} else {
    echo "No image data received.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Camera Capture</title>
    <style>
        #video, #canvas
        {
            border: 1px solid black;
            margin: 10px;
        }
        button {
            padding: 10px;
            margin: 5px;
        }
    </style>
</head>
<body>
<h1>Camera Capture</h1>
<video id="video" width="400" height="300" autoplay></video>
<br>
<button id="capture">Capture</button>
<button id="stop">Stop</button>
<button id="start">Start</button>
<br>
<canvas id="canvas" width="400" height="300"></canvas>
<form action="" method="post">
    <input type="hidden" value="" name="image" id="image">
    <button type="submit" value="Send"> Send </button>
</form>

<script>
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
</script>
</body>
</html>
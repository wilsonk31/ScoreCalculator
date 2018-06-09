<?php
$uploads_dir = '.';
foreach ($_FILES["upFile"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["upFile"]["tmp_name"][$key];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
        $name = basename($_FILES["upFile"]["name"][$key]);
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
        echo "<br> The file ".$name.
        " has been uploaded";
    } else {
      echo "There was an error uploading the Files, please try again!<br>";
    }
}
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Upload files</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="MainjQuery.js"></script>
</head>
<body>
<h2>Hit the Back button for Calculations</h2>
<br>
<button id="backBtn" onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}


</script>

</body>
</html>

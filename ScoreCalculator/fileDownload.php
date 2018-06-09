<?php
function fileDownload() // Done
{
  $fileName = basename('roundFile.txt');
  $filePath = realpath('roundFile.txt');
  if(!empty($fileName) && file_exists($filePath)){
      // Define headers
      header("Cache-Control: public");
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=$fileName");
      header("Content-Type: application/zip");
      header("Content-Transfer-Encoding: binary");
      flush(); // Flush system output buffer
      readfile($filePath);
      exit;
  }else{
      echo '<br>The file does not exist.';
  }
}
fileDownload();
 ?>

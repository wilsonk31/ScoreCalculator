<?php
// empty the team files

$path= "."; // path for Directory.
if ($handle = opendir($path)) {
    while (false !== ($FileName = readdir($handle))) {
        if ($FileName != "." && $FileName != "..") {
          $filePath = pathinfo($FileName);
          // Make sure file is a txt file
          if($filePath['extension'] =="txt" && $FileName !="roundFile.txt"
        && $FileName !="TimeTrack.txt" && $FileName !="scoreBoardTemp.txt"
        && $FileName !="scoreBoard.txt")
        {
          unlink($FileName);
          echo $FileName."<br> Deleted";
        }

        }
    }
}else {
  echo "Cannot delete files";
}
closedir($handle);
$myfile="scoreBoardTemp.txt";
file_put_contents($myfile,"");
$myfile="roundFile.txt";
file_put_contents($myfile,"");
$myfile="TimeTrack.txt";
file_put_contents($myfile,"");












 ?>

<?php
function Main()//
{
  $TotalScore = array();
  $TempArray = array();
  if(checkEmptyFile())
  {
    echo "First round Started";

  }else{
    $TempArray=tempFileReader();
    $TotalScore=ScoreFileReader();
    $TotalScore=addArrays($TotalScore,$TempArray);
    FileClear();// clears scoreBoards.txt
    WriteScores($TotalScore);
  }

}
function tempFileReader() //reads the round scores
{
  $TempArray = array();
  $myfile = fopen("scoreBoardTemp.txt", "r") or die("Unable to open file!");
    // Output one line until end-of-file
  while(!feof($myfile))
  {
    $Stringline = trim(fgets($myfile));
    if($Stringline !="")
      {
        list($Team,$Score) = explode(",",$Stringline);
        $TempArray += array($Team => $Score);
      }
  }
  return $TempArray;
}

function ScoreFileReader()
{
  $TempArray = array();
  $myfile = fopen("scoreBoard.txt", "r") or die("Unable to open file!");
  // Output one line until end-of-file
    while(!feof($myfile))
    {
      $Stringline = trim(fgets($myfile));
      if($Stringline !="")
       {
         list($Team,$Score) = explode(",",$Stringline);
         $TempArray += array($Team => $Score);
      }
    }
   return $TempArray;
}

 function addArrays($TotalScore,$TempArray)
 {
   $sums = array();
   foreach (array_keys($TotalScore + $TempArray) as $key)
   {
     $sums[$key] = (isset($TotalScore[$key]) ? $TotalScore[$key] : 0) +
      (isset($TempArray[$key]) ? $TempArray[$key] : 0);
   }
   return($sums);
 }

 function WriteScores($ScoreBoard)
 {
   $myfile ='scoreBoard.txt';
   foreach ($ScoreBoard as $Team => $value)
   {
     $score=$ScoreBoard[$Team];
     $txtLine = $Team.",".$score."\n";
     file_put_contents($myfile,$txtLine,FILE_APPEND);
   }
 }
 function checkEmptyFile()
 {
   if ( 0 == filesize("scoreBoard.txt"))
   {
       // file is empty
       copy("scoreBoardTemp.txt","scoreBoard.txt");
       echo "Files Copy";
       return true;
   }else{
     return false;
   }

 }
 function FileClear()
 {
   $myfile="scoreBoard.txt";
   file_put_contents($myfile,"");
   $myfile="scoreBoardTemp.txt";
   file_put_contents($myfile,"");
 }







Main();// calls main function

?>

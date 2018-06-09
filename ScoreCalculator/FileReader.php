<?php

function main()
{
  require 'phpFunctions.php';
  require 'ScoreBoard.php';
  FileClear();
  $FileArray = array();// to hold objectFiles
  $path= "."; // path for Directory.

  $ScoreBoard = new ScoreBoard(); // creates ScoreBoard obj
  // Reads all textfiles in the folder
  if ($handle = opendir($path)) {
      while (false !== ($FileName = readdir($handle))) {
          if ($FileName != "." && $FileName != "..") {
            $filePath = pathinfo($FileName);
            // Make sure file is a txt file
            if($filePath['extension'] =="txt" && $FileName !="roundFile.txt"
          && $FileName !="TimeTrack.txt" && $FileName !="scoreBoardTemp.txt"
          && $FileName !="scoreBoard.txt")
          {
              $FileObj=MainFileReader($FileName);
              $FileArray=array_push_assoc($FileArray,$FileName,$FileObj);
              $ScoreBoard->addTeams($FileName);//adds Teams to array.
            }
          }
      }
  }else {
    echo "Cannot read Dir";
  }
  closedir($handle);

  //Ittereates Array
  foreach ($FileArray as $TeamFile => $values)
  { //Takes 1 fileObject from FileArray
      $TotalScore=0;
      $TotalQuestions=0;

      $myfile ='roundFile.txt';
      $txtLine = " Team----: ".$TeamFile."---\n";
      file_put_contents($myfile, $txtLine, FILE_APPEND | LOCK_EX);

      foreach ($values as $key => $FileObj)
      { //Takes The file then itterates line by line
          $score;
          $score = ScoreCalc($TeamFile,$FileObj);
          $TotalQuestions +=1;
          $TotalScore += $score;
      }
      $ScoreBoard->addScore($TeamFile,$TotalScore);
      $txtLine = "Base Score: ".$TotalScore."\n\n";
      file_put_contents($myfile, $txtLine, FILE_APPEND | LOCK_EX);
      echo "<br><br>Total Questions:</u> <b>$TotalQuestions</b>";
  }

  $timeArrays=TimeArrayFunc();
  ExtraPoint($timeArrays,$TotalQuestions,$ScoreBoard);

  echo "<br><br>";
  $stringArray=$ScoreBoard->displayScore(); // gets the ranking and scores
  $myfile ='roundFile.txt';
  $txtLine ="Final Round Scores: ".$stringArray;
  file_put_contents($myfile, $txtLine, FILE_APPEND | LOCK_EX);

  $ScoreBoard->writeScores();

}//end of Main function.------------------------------------

function ExtraPoint($timeArrays,$TotalQuestions,$ScoreBoard)
{
  $count=1;
  while($count <=$TotalQuestions)
  {
    $timeArr=array();
    foreach ($timeArrays as $index => $timeObj)
    { //Takes 1 $timeObj from $timeArrays

      if($timeObj->QuestionNum==$count)
      {
        $timeArr=array_push_assoc($timeArr,$timeObj->Team,$timeObj->Time);
      }

    }

    if(count($timeArr)>0) //checks array if empty
    {
      arsort($timeArr); //sort the array in ascending by value.
      end($timeArr);
      $key=key($timeArr); //get the key from the internal pointer.
       $ScoreBoard->addScore($key,1);// add extra point
       $txtline="Extra point for ".$key."--> Question#: ".$count."\n";
       $myfile ='roundFile.txt';
       file_put_contents($myfile, $txtline, FILE_APPEND | LOCK_EX);
    }
    $count+=1;
  }
}
function ScoreCalc($TeamName,$FileObj)
{

  if($FileObj->Answered == $FileObj->CorrectAnswer)
  {
    echo "<br>";
    echo "<br><font color= 'green'> Correct!!!</font> ";
    echo"<br> QUESTION#: " . $FileObj->QuestionNum;
    echo"<br> ANSWERED: " . $FileObj->Answered;
    echo "<br> CORRECT: " . $FileObj->CorrectAnswer;
    echo "<br> TIME: " . $FileObj->Time;
    echo "<br>";
    OutputFile($TeamName,$FileObj," !! ");
    TimeFile($TeamName,$FileObj);//writes to time file if correct
    return 2; //2 points for correct answer
  }else {
    echo "<br>";
    echo "<br> <font color= 'red'> Incorrect </font> ";
    echo"<br> QUESTION#: " . $FileObj->QuestionNum;
    echo"<br> ANSWERED: " . $FileObj->Answered;
    echo "<br> CORRECT: " . $FileObj->CorrectAnswer;
    echo "<br>";
    OutputFile($TeamName,$FileObj," X ");
  }

}
function OutputFile($TeamName,$FileObj,$Flag_Mark)
{
  $myfile ='roundFile.txt';
  $txtLine = "Question#: ".$FileObj->QuestionNum .
  " | Answered: ". $FileObj->Answered.
  " | CorrectAnswer: ".$FileObj->CorrectAnswer.
  " | Time: ".$FileObj->Time." $Flag_Mark "."\n";
  file_put_contents($myfile, $txtLine, FILE_APPEND | LOCK_EX);
}
function TimeFile($TeamName,$FileObj)
{
  $myfile ='TimeTrack.txt';
  $txtLine = $TeamName.
  "|".$FileObj->QuestionNum.
  "|".$FileObj->Time."\n";
  file_put_contents($myfile, $txtLine,FILE_APPEND|LOCK_EX);
}
function TimeArrayFunc() //Creates array to hold times
{

  $myfile = fopen("TimeTrack.txt", "r") or die("Unable to open file!");
  $TempArray = array();
  $timeObjArray =array();
  while(!feof($myfile))
  {
   $Stringline = trim(fgets($myfile));

   if($Stringline != "")
   {
     list($TeamName,$Question,$Time) = explode("|",$Stringline);

     $TempArray=array_push_assoc($TempArray,"Team",$TeamName);
     $TempArray=array_push_assoc($TempArray,"QuestionNum",$Question);
     $TempArray=array_push_assoc($TempArray,"Time",floatval($Time)); //convert string to float
   }
   $objFile = json_decode(json_encode($TempArray)); // converts 2d array to object
   array_push($timeObjArray,$objFile);
 }
 array_pop($timeObjArray); // pops the last duplucate

 return $timeObjArray;

}
function FileClear()
{
  $myfile="roundFile.txt";
  file_put_contents($myfile,"");
  $myfile="TimeTrack.txt";
  file_put_contents($myfile,"");
}

main(); //calls main function




 ?>

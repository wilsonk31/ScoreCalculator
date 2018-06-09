<?php // For the Team
function MainFileReader($FilePath)
{
  // reads a file and returns an obj of the file
  $FileObject=FileRead($FilePath);
  return $FileObject;
}

function FileRead($TextFileName)
{
  $myfile = fopen($TextFileName, "r") or die("Unable to open file!");
  $FileArray = array(); //2d array - holds 1 team file

  // Output one line until end-of-file
   while(!feof($myfile))
   {
    $Stringline = trim(fgets($myfile));

    if($Stringline !="")
    {
      $LineArray = LineTest($Stringline); // puts lines into func
      array_push($FileArray,$LineArray); // appends $LineArray to $FileArray(2d Array)
    }

  }

  $objFile = json_decode(json_encode($FileArray)); // converts 2d array to object

  return $objFile; // returns the objectFile

  fclose($myfile);

}

function LineTest($String)// functions Splits the lines into list Variables.
{
  list($Question, $Answer, $CorrectAnswer, $Time ) = explode(",",$String);

  $LineArray = array(
  "QuestionNum"=>$Question,
  "Answered"=>$Answer,
  "CorrectAnswer"=>$CorrectAnswer,
  "Time"=>$Time);

   return $LineArray;
}
function array_push_assoc($array, $key, $value){
$array[$key] = $value;
return $array;
}


?>

<?php

// clears the main text files for calcs and display. 
function FileClear()
{
  $myfile="scoreBoard.txt";
  file_put_contents($myfile,"");
  $myfile="scoreBoardTemp.txt";
  file_put_contents($myfile,"");
}
FileClear();



 ?>

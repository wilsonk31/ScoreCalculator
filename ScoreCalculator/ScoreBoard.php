<?php

class ScoreBoard
{
  // property declaration
  private $ScoreBoard= array();


  public function addTeams($TeamName)
  {
    $this->ScoreBoard=array_push_assoc($this->ScoreBoard,$TeamName,0);
  }

  public function addScore($TeamName,$addScore)
  {
    foreach ($this->ScoreBoard as $Team => $value)
    {
      if($Team==$TeamName)
      {
        $score=$this->ScoreBoard[$TeamName];
        $newScore = $score + $addScore;
        $this->ScoreBoard[$TeamName]=$newScore;

      }
    }
  }
  public function displayScore()
  {
      echo "<br>";
      arsort($this->ScoreBoard);
      $results=print_r($this->ScoreBoard,True);
      return $results;

  }
  public function getScores($TeamName)
  {
    foreach ($this->ScoreBoard as $Team => $value)
    {
      if($Team==$TeamName)
      {
        $score=$this->ScoreBoard[$TeamName];
       return $score;
      }
    }
  }
  public function writeScores()
  {
    foreach ($this->ScoreBoard as $Team => $value)
    {
      $score=$this->ScoreBoard[$Team];
      $myfile ='scoreBoardTemp.txt';
      $txtLine = $Team.",".$score."\n";
      file_put_contents($myfile, $txtLine, FILE_APPEND | LOCK_EX);
      echo "<br>Scores Written";

    }

  }
  private function array_push_assoc($array, $key, $value)
  {
    $array[$key] = $value;
    return $array;
  }

  private function implodeArrayKeys($array)
  {
        return implode(", ",array_keys($array));
  }
}



 ?>

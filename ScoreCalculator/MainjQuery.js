
// jquery Functions
$(document).ready(function(){
  $('#dLink').hide();
  $('#dLink2').hide();
  $("#totalScores").hide(); // hides the download link
  $("#emptyFiles2").hide();
  $("#emptyFiles").hide();


  // runs the php code and returns the Round file.
  $("#restart").click(function(){
    $.post("emptyFiles.php");
    $.post("empty.php");
    alert("Clearing Files...");
    location.reload(true);
    });


  // runs the php code and returns the Round file.
  $("#RunPhp").click(function(){
    $.post("FileReader.php");
    alert("Calculating Scores...");//flag code
    $("#DisplayArea").load("roundFile.txt");
    $('#dLink').show();
    $("#totalScores").show();
    $('#RunPhp').hide();
    $("#emptyFiles").show();
    });

  $("#emptyFiles").click(function(){// for Round
    $.post("empty.php");
     alert("Clearing files for new round"); //flag code
     $("#DisplayArea").empty();
     $('#dLink').hide(); // hides the download link
     $('#RunPhp').show();
    });

    $("#emptyFiles2").click(function(){ // for Scoreboard
      $.post("emptyFiles.php");
       alert("Clearing ScoreBoard"); //flag code
       $('#dLink2').hide(); // hides the download link
       $("#DisplayTotal").empty();
      });

  $("#totalScores").click(function(){
      $.post("totalScores.php");
      $("#totalScores").hide();
      $('#dLink2').show();
      $("#emptyFiles2").show();
      alert("Getting Total Scores"); //flag code
      $("#DisplayTotal").load("scoreBoard.txt");
      });

});//End of document

$(document).ready(function(){
    $(".thumbnail").mouseover(function(e){
        $(this).next().css("color", "#14decd");
    })
    $(".thumbnail").mouseout(function(e){
        $(this).next().css("color", "#ffffff");
    })
    $(".mousehover").mouseover(function(e){
        $(this).css("color", "#14decd");
    })
    $(".mousehover").mouseout(function(e){
        $(this).css("color", "#ffffff");
    })
})

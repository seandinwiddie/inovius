function PopUpSize(){
  window.innerHeight<window.innerWidth//landscape
  ?$(".PopUpContent").css({
    height:"80%",width:parseInt((window.innerHeight*80)/window.innerWidth)+"%"})
  :$(".PopUpContent").css({
    height:parseInt((window.innerWidth*80)/window.innerHeight)+"%",width:"80%"});}
var SynopsisDotIconMouseOver=false;
function RefreshQuadrants(){
  $(".Under").css("display","none");
  $(".Over").css("display","block");}
function PopUpShow(){
  $(".PopUp").css("display","block");
  $("#body").addClass("Blur");
  //$("#body").blurjs({source:'body',radius:2});
  $("#SynopsisDotIcon").addClass("Saturate").removeClass("Pulse");
  $("#TopLeft").mouseover(function(){
    RefreshQuadrants();
    $("#TopLeft .Under").css("display","block");
    $("#TopLeft .Over").css("display","none");});
  $("#TopRight").mouseover(function(){
    RefreshQuadrants();
    $("#TopRight .Under").css("display","block");
    $("#TopRight .Over").css("display","none");});
  $("#BottomLeft").mouseover(function(){
    RefreshQuadrants();
    $("#BottomLeft .Under").css("display","block");
    $("#BottomLeft .Over").css("display","none");});
  $("#BottomRight").mouseover(function(){
    RefreshQuadrants();
    $("#BottomRight .Under").css("display","block");
    $("#BottomRight .Over").css("display","none");});
  SynopsisDotIconMouseOver=true;}
function PopUpHide(){
  $(".PopUp").css("display","none");
  $("#body").removeClass("Blur");
  //$("#body").blurjs({source:'body',radius:0});
  $("#SynopsisDotIcon").removeClass("Saturate").addClass("Pulse");
  $(".Under").css("display","none");
  $(".Over").css("display","block");
  SynopsisDotIconMouseOver=false;}
$(function(){
  PopUpSize();
  $("#SynopsisDotIcon").mouseover(function(){
    SynopsisDotIconMouseOver==false?PopUpShow():PopUpHide();});});
window.onresize=function(event){PopUpSize();}
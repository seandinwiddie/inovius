(function(){
  var body=document.getElementsByTagName("body")[0].innerHTML;
  var divBody="<div id='body' style='height:100%;'>"+body+"</div>";
  document.getElementsByTagName("body")[0].innerHTML=divBody;
  var divSynopsisDot=document.createElement("div");
  divSynopsisDot.setAttribute("id","SynopsisDot");
  document.getElementsByTagName("body")[0].appendChild(divSynopsisDot);
  var scriptJquery=document.createElement("script");
  scriptJquery.setAttribute("src","//inovius.com/products/synopsisdot/jquery-1.11.1.min.js");
  document.getElementsByTagName("head")[0].appendChild(scriptJquery);
  scriptJquery.onreadystagechange=function(){if(this.readyState=="complete")Blurjs();}
  scriptJquery.onload=Blurjs;
  function Blurjs(){
    var scriptBlurjs=document.createElement("script");
    scriptBlurjs.setAttribute("src","//inovius.com/products/synopsisdot/blur.min.js");
    document.getElementsByTagName("head")[0].appendChild(scriptBlurjs);
    scriptBlurjs.onreadystagechange=function(){if(this.readyState=="complete")SynopsisDot();}
    scriptBlurjs.onload=SynopsisDot();}
  function SynopsisDot(){
    var id=document.getElementById("SynopsisDotLoad").classList;
    $("#SynopsisDot").load("SynopsisDot.php",{id:id[0]},function(response){
      $(this).html(response);
      var scriptSynopsisDot=document.createElement("script");
      scriptSynopsisDot.setAttribute("src","//inovius.com/products/synopsisdot/SynopsisDot.js");
      document.getElementsByTagName("head")[0].appendChild(scriptSynopsisDot);});}
})();
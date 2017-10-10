<!-- God is good -->
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>SynopsisDot</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
      @font-face{
        font-family:'GillSans Light';
        src:url(ufonts.com_gillsans_light.woff) format('woff');}
      *{
        color:#333;
        font-size:108%;
        font-family:'GillSans Light';
        text-shadow:0 0 1px rgba(255,255,255,.25),
          1px 1px GhostWhite;}
      html,body{margin:0;height:100%;width:100%;padding:0;}
      a{text-decoration:none;}
      .form{text-align:right;}
      .h1,.h2,.h3{word-spacing:.2em;letter-spacing:.1em;font-weight:bold;}
      .h1{font-size:180%;}.h2{font-size:140%;}.h3{font-size:120%;}
      .ColumnWhole{float:left;margin:0 1%;width:96%;padding:0 1%;}
      .ColumnHalf{float:left;margin:1%;width:46%;padding:.5% 1%;}
      .ColumnThird{float:left;margin:1%;width:29%;padding:.5% 1%;}
      .ColumnFourth{float:left;margin:1%;width:21%;padding:.5% 1%;}
      .PopUpLittle{
        position:absolute;
        padding:1%;
        background:white;
        box-shadow:0 5px 25px rgba(0,0,0,.4);}
      #Content{
        background:White;}
      #Header{
        height:20%;width:96%;
        padding:2%;}
      #Logo{
        float:left;
        margin:2% 0 2% 10%;
        height:128px;width:128px;
        _background:url(//amotas.com/inovius/SynopsisDot/SynopsisDot.png)0 0/128px 128px no-repeat;
        background:url(//amotas.com/inovius/SynopsisDot/SynopsisDot2.svg);
        background-size:128px 128px;
        background-repeat:no-repeat;}
      #LogoText{
        float:left;
        margin:5% 1%;
        color:DimGray;
        font-size:240%;}
      #Login,.Order{
        float:right;
        margin:.5%;
        border:1px solid Gainsboro;
        padding:1%;
        background:WhiteSmoke;}
      #Login a,#Login span{color:#000066;}
      #LoginPopUp{display:none;top:1%;right:1%;}
      #Login:hover #LoginPopUp{display:block;}
      .Order,.Order *{color:#FF6600;}
      #Main{
        margin:auto;
        _height:56%;
        width:80%;
        _border:1px solid Gainsboro;
        padding:6% 1%;
        background:white;}
      #Footer{
        position:fixed;
        bottom:0;
        width:98%;
        border-top:1px solid Gainsboro;
        padding:1%;
        text-align:center;
        color:#333;
        background:WhiteSmoke;}
      #Inovius,#Inovius-i{font-family:"Trebuchet MS",Arial,Helvetica,sans-serif;}
      #Inovius{color:#000066;}
      #Inovius-i{color:#FF6600;}
    </style>
    <script src="jquery-1.11.1.min.js"></script>
    <script>
      $(function(){
        $(".Order").click(function(){$("#Main").load("order.php");});
        $("#Login input[type=submit]").click(function(){$("#Main").load("control.php",
          {Email:$("input[name=Email]").val(),Password:$("input[name=Password]").val()},
          function(){$("#Login").html("<a href='../synopsisdot'><span class='fa fa-sign-out'></span> Log Out</a>");});});});
    </script>
  </head>
  <body>
    <div id="Content" style="height:100%;">
      <div id="Header">
        <div>
          <div id="Logo"></div>
          <div id="LogoText">SynopsisDot</div>
        </div>
        <div id="Login">
          <a href="#"><span class="fa fa-sign-in"></span> Login</a>
          <div id="LoginPopUp" class="PopUpLittle">
            <h2 style="text-align:center;">Login</h2>
            <div class="form">
              <p>Email <input name="Email"></p>
              <p>Password <input name="Password" type="password"></p>
              <p><input type="submit" value="Login"></p>
            </div>
          </div>
        </div>
        <div class="Order"><a href="#"><span class="fa fa-shopping-cart"></span> Order</a></div>
      </div>
      <div id="Main">
        <div class="ColumnWhole h1">Quadrants Galore</div>
        <div class="ColumnThird">
          <div class="h2">25 Words</div>
          <div>Lorem ipsum dolor sit amet, utinam pericula in mea, erant labores no mel. Eam cu nominavi.</div>
        </div>
        <div class="ColumnThird">
          <div class="h2">25 Dollors</div>
          <div>An ipsum persius euismod eum. Solum delectus mea eu. Cibo erat omittantur ne sed, percipit facilisi.</div>
        </div>
        <div class="ColumnThird">
          <div class="h2">25 Minutes</div>
          <div>Modus regione debitis vim et, te has mollis fastidii disputationi. Wisi qualisque vituperatoribus usu ea sonet.</div>
        </div>
      </div>
      <div id="Footer">
        <div>Powered by <span id="Inovius">Inov<span id="Inovius-i">i</span>us, Inc.</span> ©2014 - All rights reserved</div>
      </div>
    </div>
    <script id="SynopsisDotLoad" class="4294967295" src="//inovius.com/products/synopsisdot/SynopsisDotLoad.js"></script>
  </body>
</html>
<!-- God is good -->
<?php
  if(!$Connect=mysql_connect("MySQLB5.webcontrolcenter.com","inovius","graceabc1A")){
    die("Could not connect: ".mysql_error());exit;}
  if(!mysql_select_db("synopsisdot",$Connect)){
    echo"Could not select database.";exit;}
  if(!$Query=mysql_query(
    "select *
    from inventory
    where inventory_id='".$_POST["id"]."'",$Connect)){
      echo"DB Error, could not query the database\n";
      echo"MySQL Error: ".mysql_error();exit;}
  $Result=mysql_fetch_assoc($Query);
?>
<div>
  <style>
    @font-face{
      font-family:'GillSans Light';
      src:url(ufonts.com_gillsans_light.woff) format('woff');}
    @keyframes pulse{
      from{transform:scale(1,1);}
      to{transform:scale(1.2,1.2);}}
    @-o-keyframes pulse{
      from{-o-transform:scale(1,1);}
      to{-o-transform:scale(1.2,1.2);}}
    @-ms-keyframes pulse{
      from{-ms-transform:scale(1,1);}
      to{-ms-transform:scale(1.2,1.2);}}
    @-moz-keyframes pulse{
      from{-moz-transform:scale(1,1);}
      to{-moz-transform:scale(1.2,1.2);}}
    @-webkit-keyframes pulse{
      from{-webkit-transform:scale(1,1);}
      to{-webkit-transform:scale(1.2,1.2);}}
    html,body{margin:0;height:100%;width:100%;padding:0;}
    .Pulse{
      animation:pulse 2s infinite alternate;
      -o-animation:pulse 2s infinite alternate;
      -ms-animation:pulse 2s infinite alternate;
      -moz-animation:pulse 2s infinite alternate;
      -webkit-animation:pulse 2s infinite alternate;}
    .Blur{
      filter:blur(2px);
      -o-filter:blur(2px);
      -ms-filter:blur(2px);
      -moz-filter:blur(2px);
      -webkit-filter:blur(2px);
      filter:progid:DXImageTransform.Microsoft.Blur(pixelradius=2);}
    .Saturate{
      filter:saturate(200%);
      -moz-filter:saturate(200%);
      -webkit-filter:saturate(200%);}
    .PopUp{
      display:none;
      position:fixed;
      top:0;
      height:100%;width:100%;
      background:rgba(0,0,0,.3);}
    .PopUpContent{
      position:absolute;
      top:0;bottom:0;left:0;right:0;
      margin:auto;
      _height:60vw;_width:60vw;
      height:80%;width:80%;
      border-radius:8px;
      font-size:28px;
      _background:url(//amotas.com/inovius/SynopsisDot/SynopsisDot.svg)center/80% 80% no-repeat,White;
      background:url(//amotas.com/inovius/SynopsisDot/SynopsisDot.svg),White;
      background-size:128% 128%;
      background-repeat:no-repeat;
      background-position:center;
      box-shadow:0 10px 50px rgba(0,0,0,.8);}
    .PopUpContent *{
      color:#333;
      font-family:'GillSans Light';}
    .Quadrant{
      position:relative;
      float:left;
      margin:2%;
      height:46%;width:46%;
      overflow:hidden;}
    .Over{
      position:absolute;
      top:0;bottom:0;left:0;right:0;
      margin:auto;
      height:12%;width:85%;
      text-align:center;}
    .Under{display:none;position:relative;height:100%;}
    .Under div{position:absolute;margin:auto;top:0;bottom:0;height:100%;}
    #SynopsisDotIcon{
      position:fixed;
      top:<?php echo$Result["from_top"];?>%;
      <?php echo$Result["which_side"];?>:1%;
      height:96px;width:96px;
      background:url(//amotas.com/inovius/SynopsisDot/SynopsisDot.svg);
      background-size:96px 96px;
      background-repeat:no-repeat;z-index:99;}
  </style>
  <div id="SynopsisDotIcon" class="Pulse"></div>
  <div class="PopUp">
    <div class="PopUpContent">
      <div class="Quadrant" id="TopLeft">
        <div class="Over">Who We Are</div>
        <div class="Under">
          <div>We are an Insurance Agency. We work for you. We explain your options in a straight forward and comprehensive manner. You make the decision!</div>
        </div>
      </div>
      <div class="Quadrant" id="TopRight">
        <div class="Over">What We Do</div>
        <div class="Under">
          <div><?php echo$Result["what"];?></div>
        </div>
      </div>
      <div class="Quadrant" id="BottomLeft">
        <div class="Over">What We Offer</div>
        <div class="Under">
          <div><?php echo$Result["where"];?></div>
        </div>
      </div>
      <div class="Quadrant" id="BottomRight">
        <div class="Over">Where We Are</div>
        <div class="Under">
          <div><?php echo$Result["when"];?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  mysql_free_result($Query);
  mysql_close($Connect);
?>
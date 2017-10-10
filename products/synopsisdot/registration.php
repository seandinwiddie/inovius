<!-- God is good -->
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SynopsisDot</title>
    <style>
      @font-face{
        font-family:'GillSans Light';
        src:url(ufonts.com_gillsans_light.woff) format('woff');}
      *{
        color:#333;
        font-size:108%;
        font-family:'GillSans Light';
        _text-shadow:0 0 1px rgba(0,0,0,.125),
          1px 1px GhostWhite;}
      html,body{margin:0;height:100%;width:100%;padding:0;}
      p{text-align:right;}
      form{
      margin:2% auto;
      width:40%;
      border:2px solid #333;
      padding:1%;}
      em{font-size:80%;}
    </style>
    <script src="//inovius.com/products/synopsisdot/jquery-1.11.1.min.js"></script>
  </head>
  <body>
    <div style="margin:2%;text-align:center;">
      <h1>
        <?php
          if(!$Connect=mysql_connect("MySQLB5.webcontrolcenter.com","inovius","graceabc1A")){
            die("Could not connect: ".mysql_error());exit;}
          if(!mysql_select_db("synopsisdot",$Connect)){
            echo"Could not select database.";exit;}
          $symbls=implode(array('!','\'','$','%','^','&','*','(',')','-','_','=','+','[','{',']','}',';',':','@','#','~','|','.','>','/','?'));
          $pw;
          for($i=0;$i<2;$i++){
            $pw.=chr(mt_rand(97,122));
            $pw.=strtoupper(chr(mt_rand(97,122)));
            $pw.=chr(mt_rand(49,57));
            $pw.=substr(str_shuffle($symbls),0,1);}
          $pw=str_shuffle($pw);
          $hsh=crypt($pw);
          $date=date("Y-m-d H:i:s");
          if(!$Query=mysql_query(
            "insert into customer(email,password,create_date)
            values('".$_POST["NewEmail"]."','$hsh','".date("Y-m-d H:i:s")."')",$Connect)){
              echo"DB Error, could not query the database\n";
              echo"MySQL Error: ".mysql_error();exit;}
          echo "You have successfully registered ".$_POST["NewEmail"]." with SynopsisDot.<br>
            Your password is: ".$pw."<br>
            Please retain this password in your records.";
          $Result=mysql_fetch_assoc(mysql_query("select customer_id from customer where email='".$_POST["NewEmail"]."'"));
          ini_set("SMTP","mail.inovius.com");ini_set("sendmail_from","do_not_reply@inovius.com");
          mail($_POST["NewEmail"],"SynopsisDot Registration",
"Customer # ".$Result["customer_id"]."
Registration Date ".date("D M j G:i:s T Y")."
PASSWORD ".$pw."
Thank you for registering with SynopsisDot!");
          $Result=mysql_fetch_assoc(mysql_query("select customer_id from customer where email='".$_POST["NewEmail"]."'",$Connect));
        ?>
        <script>
          $(function(){
            $("#Form").load("quantity.php",{amount:$("#Quantity").val()});
            $("#Quantity").keyup(function(){$("#Form").load("quantity.php",{
              customer_id:<?php echo$Result["customer_id"];?>,amount:$("#Quantity").val()});});
          });
        </script>
        <form action="https://test.authorize.net/gateway/transact.dll" method="post">
        <!--<form action="https://secure.authorize.net/gateway/transact.dll" method="post">-->
          <span id="Form"></span>
          <input type="hidden" name="x_test_request" value="true">
          <!--<input type="hidden" name="x_test_request" value="false">-->
          <input type="hidden" name="x_show_form" value="PAYMENT_FORM">
          <fieldset>
            <label for="Quantity">Quantity</label>
            <input id="Quantity" name="cust_quantity" value="1">
          </fieldset>
          <input type="submit" value="Continue">
        </form>
        <?php
          mysql_free_result($Query);
          mysql_close($Connect);
        ?>
      </h1>
    </div>
  </body>
</html>
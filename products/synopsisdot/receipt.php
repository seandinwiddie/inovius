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
  </head>
  <body>
    <div style="margin:2%;text-align:center;">
      <p style="text-align:center;">Thank you for purchasing <?php echo$_POST["cust_quantity"];?> SynopsisDot(s)!<br>
      A receipt has been sent to your email.<br>
      Please log back in to continue.</p>
      <?php
        if(!$Connect=mysql_connect("MySQLB5.webcontrolcenter.com","inovius","graceabc1A")){
          die("Could not connect: ".mysql_error());exit;}
        if(!mysql_select_db("synopsisdot",$Connect)){
          echo"Could not select database.";exit;}
        if(!$Query=mysql_query(
          "insert into payment(payment_id,customer_id)
          values('".$_POST["x_invoice_num"]."','".$_POST["x_cust_id"]."')",$Connect)){
            echo"DB Error, could not query the database\n";
            echo"MySQL Error: ".mysql_error();exit;}
        for($i=0;$i<$_POST["cust_quantity"];$i++){mysql_query("insert into inventory(payment_id)
          values('".$_POST["x_invoice_num"]."')");}
        $Query=mysql_query("select inventory_id
          from inventory where payment_id=".$_POST["x_invoice_num"]);
        while($Result=mysql_fetch_assoc($Query)){
          $Scripts.="<script id='SynopsisDotLoad' class='".$Result["inventory_id"]."' src='//inovius.com/products/synopsisdot/SynopsisDotLoad.js'></script>

";}
        $Result=mysql_fetch_assoc(mysql_query("select email from customer where customer_id=".$_POST["x_cust_id"]));
        ini_set("SMTP","mail.inovius.com");ini_set("sendmail_from","do_not_reply@inovius.com");
        mail($Result["email"],"SynopsisDot Receipt",
"Customer # ".$_POST["x_cust_id"]."
Invoice # ".$_POST["x_invoice_num"]."
Invoice Date ".date("D M j G:i:s T Y")."
Invoice Amount $".$_POST["x_amount"]."
Thank you for purchasing ".$_POST["cust_quantity"]." SynopsisDot(s)!

To set-up your SynopsisDot, first, place this/[one of ]these script(s)

".$Scripts."

one line above the </body> tag in (each of) your website's
index.* file(s)( commonly index.html, index.apx, index.cfm, or index.php).
Second, login to your dashboard at Inovius' SynopsisDot website and update your SynopsisDot's Quadrants' text.");
      ?>
      <form method="post" action="control.php">
        <p>Email <input name="Email" value="<?php echo$Result["email"];?>"></p>
        <p>Password <input type="password" name="Password"></p>
        <input type="submit" value="Continue">
      </form>  
      <?php
        mysql_free_result($Query);
        mysql_close($Connect);
      ?>
    </div>
  </body>
</html>
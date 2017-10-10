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
      form{
      margin:2% auto;
      width:40%;
      border:2px solid #333;
      padding:1%;}
      em{font-size:80%;}
      form,fieldset{border:none;}
      label{display:block;text-align:left;font-weight:bold;}
      textarea{width:100%;}
    </style>
    <script src="//inovius.com/products/synopsisdot/jquery-1.11.1.min.js"></script>
  </head>
  <body>
    <div style="margin:2%;text-align:center;">
      <?php
        if(!$Connect=mysql_connect("MySQLB5.webcontrolcenter.com","inovius","graceabc1A")){
          die("Could not connect: ".mysql_error());exit;}
        if(!mysql_select_db("synopsisdot",$Connect)){
          echo"Could not select database.";exit;}
        if(!$Query=mysql_query(
          "select password,customer_id
          from customer
          where email='".$_POST["Email"]."'",$Connect)){
            echo"DB Error, could not query the database\n";
            echo"MySQL Error: ".mysql_error();exit;}
        if($Result=mysql_fetch_assoc($Query)){
          if(crypt($_POST["Password"],$Result["password"])==$Result["password"]){
            $Query=mysql_query(
              "select create_date,customer_id from customer
              where customer.customer_id=".$Result["customer_id"]);
            if($Result=mysql_fetch_assoc($Query)){
              ?>
              <h1>Welcome</h1>
              <p>Your first SynopsisDot has been active since <?php echo$Result["create_date"];?>.</p>
              <?php
                $loginID="4Sa3E3a6g8qc";
                //$loginID="7E69erYp";
                $sequence=rand(1,1000);
                $timestamp=time();
                $amount=25;
                $fingerprint=bin2hex(mhash(MHASH_MD5,$loginID."^".$sequence."^".$timestamp."^".$amount."^","2dNL2N3Cp8gg5h8b"));
                //$fingerprint=bin2hex(mhash(MHASH_MD5,$loginID."^".$sequence."^".$timestamp."^".$amount."^","3F76u7GpsfKpK98b"));
                $Query=mysql_query(
                  "select inventory.last_update from customer,payment,inventory
                  where customer.customer_id=".$Result["customer_id"]."
                  and payment.customer_id=customer.customer_id
                  and inventory.payment_id=payment.payment_id");
              ?>
              <form action="https://test.authorize.net/gateway/transact.dll" method="post">
              <!--<form action="https://secure.authorize.net/gateway/transact.dll" method="post">-->
                You have <?php echo mysql_num_rows($Query);?> SynopsisDot(s) available:
                <input type="hidden" name="x_login" value="<?php echo $loginID;?>">
                <input type="hidden" name="x_logo_url" value="//inovius.com/products/synopsisdot/branding.png">
                <input type="hidden" name="x_amount" value="<?php echo $amount;?>">
                <input type="hidden" name="x_description" value="SynopsisDot">
                <input type="hidden" name="x_invoice_num" value="<?php echo date(YmdHis);?>">
                <input type="hidden" name="x_cust_id" value="<?php echo $Result["customer_id"];?>">
                <input type="hidden" name="x_fp_sequence" value="<?php echo $sequence;?>">
                <input type="hidden" name="x_fp_timestamp" value="<?php echo $timestamp;?>">
                <input type="hidden" name="x_fp_hash" value="<?php echo $fingerprint;?>">
                <input type="hidden" name="x_test_request" value="true">
                <!--<input type="hidden" name="x_test_request" value="false">-->
                <input type="hidden" name="x_show_form" value="PAYMENT_FORM">
                <input type="hidden" name="cust_quantity" value="1">
                <input class="Order" type="submit" value="Add">
              </form>
              <?php
                $Query=mysql_query(
                  "select inventory_id,who,what,`where`,`when`,which_side,from_top from customer,payment,inventory
                  where customer.customer_id=".$Result["customer_id"]."
                  and payment.customer_id=customer.customer_id
                  and inventory.payment_id=payment.payment_id");
                $i=1;
                while($Result=mysql_fetch_assoc($Query)){
                  echo
                    "<p>SynopsisDot ".$i++." ( ID # ".$Result["inventory_id"]."), quadrant management:</p>
                    <form>
                      <fieldset>
                        <label for='Who'>Who: </label>
                        <textarea id='".$Result["inventory_id"].":Who'>".$Result['who']."</textarea>
                      </fieldset>
                      <fieldset>
                        <label for='What'>What: </label>
                        <textarea id='".$Result["inventory_id"].":What'>".$Result['what']."</textarea>
                      </fieldset>
                      <fieldset>
                        <label for='Where'>Where: </label>
                        <textarea id='".$Result["inventory_id"].":Where'>".$Result['where']."</textarea>
                      </fieldset>
                      <fieldset>
                        <label for='When'>When: </label>
                        <textarea id='".$Result["inventory_id"].":When'>".$Result['when']."</textarea>
                      </fieldset>
                      <fieldset>
                        <legend>Side of page</legend>
                        <label for='which_side-left'>Left</label>
                        <input type='radio' name='which_side' id='which_side-left' value='left' checked>
                        <label for='which_side-right'>Right</label>
                        <input type='radio' name='which_side' id='which_side-right' value='right'>
                      </fieldset>
                      <fieldset>
                        <label>position percentage from top to bottom</label>
                        <input type='range' id='".$Result["inventory_id"].":From_Top' value='".$Result["from_top"]."'>
                      </fieldset>
                    </form>";}
              ?>
              <script>
                function Update(that){
                  var Parameters={};
                  Parameters["Email"]="<?php echo$_POST["Email"];?>";
                  Parameters["Password"]="<?php echo$_POST["Password"];?>";
                  Parameters["inventory_id"]=that.id.replace(/[A-z]|:/g,"");
                  Parameters[that.id.replace(/\d|:/g,"")]=that.value;console.log(Parameters);
                  $.post("update.php",Parameters);}
                $(function(){
                  $("textarea").keyup(function(){Update(this);});
                  $("input").change(function(){Update(this);});});
              </script>
              <?php
            }}
          else{echo"Sorry, but those login credentials are invalid.";}}
        else{echo"Sorry, but those login credentials are invalid.";}
        mysql_free_result($Query);
        mysql_close($Connect);
      ?>
    </div>
  </body>
</html>
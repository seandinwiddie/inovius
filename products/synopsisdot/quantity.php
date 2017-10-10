<?php
  $loginID="4Sa3E3a6g8qc";
  //$loginID="7E69erYp";
  $sequence=rand(1,1000);
  $timestamp=time();
  $amount=$_POST["amount"]*25;
  $fingerprint=bin2hex(mhash(MHASH_MD5,$loginID."^".$sequence."^".$timestamp."^".$amount."^","2dNL2N3Cp8gg5h8b"));
  //$fingerprint=bin2hex(mhash(MHASH_MD5,$loginID."^".$sequence."^".$timestamp."^".$amount."^","3F76u7GpsfKpK98b"));
?>
<input type="hidden" name="x_login" value="<?php echo $loginID;?>">
<input type="hidden" name="x_logo_url" value="//inovius.com/products/synopsisdot/branding.png">
<input type="hidden" name="x_amount" value="<?php echo $amount;?>">
<input type="hidden" name="x_description" value="SynopsisDot">
<input type="hidden" name="x_invoice_num" value="<?php echo date(YmdHis);?>">
<input type="hidden" name="x_cust_id" value="<?php echo $_POST["customer_id"];?>">
<input type="hidden" name="x_fp_sequence" value="<?php echo $sequence;?>">
<input type="hidden" name="x_fp_timestamp" value="<?php echo $timestamp;?>">
<input type="hidden" name="x_fp_hash" value="<?php echo $fingerprint;?>">
<!-- God is good -->
<style>
  p{text-align:right;}
  form{
    margin:2% auto;
    width:50%;
    border:2px solid #333;
    padding:1%;}
  em{font-size:80%;}
</style>
<script>
  function ValidateEmail(){
    var NewEmail=document.forms[1]["NewEmail"].value;
    var NewEmailVerify=document.forms[1]["NewEmailVerify"].value;
    if(NewEmail!=NewEmailVerify){
      alert("Emails do not match.");
      return false;}
    var AtPosistion=NewEmail.indexOf("@");
    var DotPosition=NewEmail.indexOf(".");
    if(AtPosistion<1||DotPosition<AtPosistion+2||DotPosition+2>=NewEmail.length){
      alert("Not a valid email address.");
      return false;}}
</script>
<div style="text-align:center;">
  <h1><?php echo"Purchasing";?></h1>
  <div>SynopsisDot is a hosted service.<br>Please sign-in or register, and then place an order.</div>
  <form onsubmit="return ValidateEmail();" action="registration.php" method="post">
    <h2>New Customer Registration</h2>
    <p>Email Address <input name="NewEmail"></p>
    <p>Confirm Email <input name="NewEmailVerify"></p>
    <p><input type="submit" value="Register"></p>
    <em>Registrants without orders will be removed.</em>
  </form>
</div>
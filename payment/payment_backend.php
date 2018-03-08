<?php
/**
 * Created by PhpStorm.
 * User: JAshMe
 * Date: 3/7/2018
 * Time: 4:29 AM
 */

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
    //$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode
    $KEY = "6Qfm5exu";
    $SALT = "JcShuxWUzy";
    $hash ='';


    // If came by clicking Pay button
    if(isset($_POST['Pay'])&&$_POST['Pay']=="Pay")
    {
        $data = array();
        $data['key'] = $KEY;
        $data['txnid']=  $_POST['txnid'];
        $data['firstname'] = $_POST['fname'];
        $data['email'] = $_POST['email'];
        $data['amount'] = $_POST['amt'];
        $data['phone'] = $_POST['phone'];
        $data['productinfo'] = $_POST['product_info'];
        $data['success_url'] = "http://localhost/MUN/payment/success.php";
        $data['fail_url'] = "http://localhost/MUN/payment/failure.php";
        $action = $PAYU_BASE_URL."/_payment";
        $hash = '';



        //calculate hash
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        //echo $hashSequence;
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var)
        {
            $hash_string .= isset($data[$hash_var]) ? $data[$hash_var] : '';
            $hash_string .= '|';
        }
        $hash_string .= $SALT;
       //echo $hash_string;

        $hash = strtolower(hash('sha512', $hash_string));

        }


        //Inserting the transaction to the database.
}
else
{
    die("<h2>Unauthorised Access!!!</h2>");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Merchant ID</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
</head>
<script>
    function submitPayuForm(){
        var payuForm = document.forms.payuForm;
       payuForm.submit();
    }
</script>
<body onload="submitPayuForm()">
    <form method="post" action="<?=$action?>" name="payuForm">
        <input type="hidden" name="key" value="<?= $KEY ?>">
        <input type="hidden" name="hash" value="<?= $hash ?>">
        <input type="hidden" name="txnid" value="<?= $data['txnid'] ?>">
        <input type="hidden" name="firstname" value="<?= $data['firstname'] ?>">
        <input type="hidden" name="amount" value="<?=  $data['amount'] ?>">
        <input type="hidden" name="email" value="<?= $data['email'] ?>">
        <input type="hidden" name="phone" value="<?=  $data['phone'] ?>">
        <input type="hidden" name="productinfo" value="<?=  $data['productinfo']?>">
        <input type="hidden" name="surl" value="<?=  $data['success_url']?>">
        <input type="hidden" name="furl" value="<?=  $data['fail_url']?>">
        <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
    </form>
</body>
<script>

</script>


</html>
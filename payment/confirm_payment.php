<?php
/**
 * Created by PhpStorm.
 * User:JAshMe
 * Date: 3/7/2018
 * Time: 3:58 AM
 */
require_once "includes/database.php";
$db = new PDOdb("culrav2k18");
$txnid='';
$firstname ='';
$email = '';
$amount = '';
$phone = '';
$college='';
$product_info ="MUN Registration";
if($_SERVER['REQUEST_METHOD']=="POST")
{
        //echo $_POST['Proceed'];
        // If came by clicking Apply button
    if(isset($_POST['Proceed'])&&$_POST['Proceed']==htmlentities(trim(stripslashes("Proceed for Payment"))))
    {
            //calculate transaction id
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

            //getting the values
            $firstname = htmlentities(trim(stripslashes($_POST['name'])));
            $email = htmlentities(trim(stripslashes($_POST['email'])));
            $amount = htmlentities(trim(stripslashes($_POST['fees'])));
            $phone = htmlentities(trim(stripslashes($_POST['phone'])));
            $college = htmlentities(trim(stripslashes($_POST['college'])));

            // validate

            if($amount!="1200" && $amount!="1500")
            {
                    die("Sorry Amount Not Proper. Please try again.");
            }
            $cat =($amount=="1200")?0:1;



            //inserting the values in database


            //checking if user exists
            $checkQuery = "select * from mun_users where Email=? or Phone=?";
            $params = array($email,$phone);
            $stmt = $db->select_query($checkQuery,$params);
            if($stmt->rowCount()>0) //user already exists
            {
                    //throw error and redirect
            }

            //if user doesn't exist then note its info
                //user info
            $prepared = "insert into mun_users VALUES (?,?,?,?,?);";
            $params = array($email,$firstname,$phone,$cat,$college);
            $db->ins_del_query($prepared,$params);

                //transaction info
            $prepared2 = "insert into transac_details(Email,Ref_no,status,amount,productinfo) VALUES (?,?,?,?,?);";
            $params2 = array($email,$txnid,"pending",$amount,$product_info);
            //print_r($params2);
            $db->ins_del_query($prepared2,$params2);
    }
        else{
                die("<h2>Unauthorised Access!!!</h2>");
        }
}
else
{
    die("<h2>Unauthorised Access!!!</h2>");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Make Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
</head>
<body>
<div align="center">
    <label>Transaction ID : </label><span><?= $txnid ?></span><br>
    <label>First Name : </label><span><?= $firstname ?></span><br>
    <label>Amount: </label><span><?= $amount ?></span><br>
    <label>Email: </label><span><?= $email ?></span><br>
    <label>Phone: </label><span><?= $phone ?></span><br>
    <label>Purpose: </label><span><?= $product_info?></span><br>
    <form method="post" action="payment_backend.php">
        <input type="hidden" name="txnid" value="<?= $txnid ?>">
        <input type="hidden" name="fname" value="<?= $firstname ?>">
        <input type="hidden" name="amt" value="<?= $amount ?>">
        <input type="hidden" name="email" value="<?=$email ?>">
        <input type="hidden" name="phone" value="<?= $phone ?>">
        <input type="hidden" name="product_info" value="<?= $product_info?>">
        <button type="submit" name="Pay" value="Pay">Pay</button><br>
    </form>

</div>
</body>
<script>
</script>


</html>



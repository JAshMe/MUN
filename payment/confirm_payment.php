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

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Invalid email . Please enter valid e-mail.");
            }
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
                echo '<script>alert("This e-mail or phone number is already registered!!!!");';
                echo 'window.location= "index.html";</script>';
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
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 50%;
            left: 25%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #table tr:nth-child(even){background-color: #f2f2f2;text-align: center;}

        #table tr:hover {background-color: #ddd;}

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #29afbb;
            color: white;
        }
        h3{
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #29afbb;
            color: white;
        }
        #paybutton{
            padding: 12px;
            margin: 5px;
            color: white;
            background-color: #ff331d;
            border-radius: 5px;
        }
        #paybutton:hover{
            background-color: #29afbb;
        }
    </style>

</head>
<body>
<div align="center">
    <h3><b>Please note the transaction ID for future reference.</b></h3>
    <table style="left: 25%;width: 50%;" id="table">
        <tr><th><b>Transaction ID</b></th>  <th><b><?= $txnid ?></b></th></tr>
        <tr><td><b>First Name</b></td><td> <?= $firstname ?></td></tr>
        <tr><td><b>Amount</b></td><td> <?= $amount ?></td></tr>
        <tr><td><b>Email</b></td><td> <?= $email ?></td></tr>
        <tr><td><b>Phone</b></td><td> <?= $phone ?></td></tr>
        <tr><td><b>Purpose</b></td><td><?= $product_info?></td></tr>

    </table>

    <form method="post" action="payment_backend.php">
        <input type="hidden" name="txnid" value="<?= $txnid ?>">
        <input type="hidden" name="fname" value="<?= $firstname ?>">
        <input type="hidden" name="amt" value="<?= $amount ?>">
        <input type="hidden" name="email" value="<?=$email ?>">
        <input type="hidden" name="phone" value="<?= $phone ?>">
        <input type="hidden" name="product_info" value="<?= $product_info?>">
        <button type="submit" name="Pay" value="Pay" id="paybutton">Pay</button><br>
    </form>

</div>
</body>
<script>
</script>


</html>



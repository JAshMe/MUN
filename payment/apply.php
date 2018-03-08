<?php
/**
 * Created by PhpStorm.
 * User: JAshMe
 * Date: 3/6/2018
 * Time: 10:03 PM
 */

    //calculate transaction id
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
</head>
<body>
    <div align="center">
        <form method="post" action="confirm_payment.php">

            <button type="submit" name="Apply" value="Apply">Apply</button>
        </form>

    </div>
</body>


</html>

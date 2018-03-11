<?php
/**
 * Created by PhpStorm.
 * User: jAshMe
 * Date: 3/7/2018
 * Time: 4:17 AM
 */

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    require_once "includes/database.php";
    $db = new PDOdb("culrav2k18");
    if(isset($_POST['hash']))
    {
        $data = array();
        $data['key'] = $KEY;
        $data['txnid']= htmlentities(trim(stripslashes( $_POST['txnid'])));
        $data['firstname'] = htmlentities(trim(stripslashes($_POST['firstname'])));
        $data['email'] = htmlentities(trim(stripslashes($_POST['email'])));
        $data['amount'] = htmlentities(trim(stripslashes($_POST['amount'])));
        $data['phone'] = htmlentities(trim(stripslashes($_POST['phone'])));
        $data['productinfo'] = htmlentities(trim(stripslashes($_POST['productinfo'])));
        $data['hash'] = htmlentities(trim(stripslashes($_POST['hash'])));
        $data['payuMoneyId'] = htmlentities(trim(stripslashes($_POST['payuMoneyId'])));
        $data['status'] = htmlentities(trim(stripslashes($_POST['status'])));
        $data['mode'] =htmlentities(trim(stripslashes( $_POST['mode'])));
        $data['bankcode'] =htmlentities(trim(stripslashes( $_POST['mode'])));


        //store verdict in database
        $prepared  = "update mun_users set trans_no=?,status=?,amount=?,mode=?,bank_code=? where Ref_no=? and email=?";
        $params = array($data['payuMoneyId'],$data['status'],$data['amount'],$data['mode'],$data['bankcode'],$data['txnid'],$data['email']);
        $db->ins_del_query($prepared,$params);
        echo "<h2>FAILED</h2><br>";
    }
}
else
    die("<h2>Unauthorised Access!!!</h2>");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Transaction Verdict</title>
        <style>
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 50%;
                margin-left: 25%;
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
            #button{
                padding: 12px;
                margin: 15px;
                color: white;
                background-color: #ff331d;
                border-radius: 5px;
                border: none;
                text-decoration: none;
                margin-left: 45%;
                width: 10%;
            }
            #button:hover{
                background-color: #29afbb;
            }
        </style>
    </head>
    <body>
        <table id="table">
            <tr>
                <td>Status:</td>
                <td><?= $data['status']?></td>
</tr>
<tr>
    <td><b>First Name</b></td>
    <td><?= $data['firstname']?></td>
</tr>
<tr>
    <td><strong>Reference  ID</strong></td>
    <td><?= $data['txnid']?></td>
</tr>
<tr>
    <td><b>Purpose</b></td>
    <td><?= $data['productinfo']?></td>
</tr>
<tr>
    <td><b>Amount</b></td>
    <td><?= $data['amount']?></td>
</tr>
<tr>
    <td><b>Email</b></td>
    <td><?= $data['email']?></td>
</tr>
<tr>
    <td><b>Mobile Number</b></td>
    <td><?= $data['phone']?></td>
</tr>
</table>
<a href="../index.html" id="button">Back to homepage</a>
</body>

</html>
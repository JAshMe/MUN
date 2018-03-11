<?php
/**
 * Created by PhpStorm.
 * User: JAshMe
 * Date: 3/7/2018
 * Time: 4:17 AM
 */

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    require_once "includes/database.php";
    $db = new PDOdb("culrav2k18");
    $KEY = "6Qfm5exu";
    $SALT = "JcShuxWUzy";
    $hash ='';
    $verdict = '';
    if(isset($_POST['hash']))
    {

        //checking if hash matches
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

        $hashSequence= "status||||||udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        $hash_string .= $SALT;
        foreach($hashVarsSeq as $hash_var)
        {
            $hash_string .= '|';
            $hash_string .= isset($data[$hash_var]) ? $data[$hash_var] : '';
        }
       // echo $hash_string;


        $hash = strtolower(hash('sha512', $hash_string));
//        echo "<br>Computed Hash=".$hash."<br>";
//        echo "Received Hash=".$data['hash']."<br>";

        if($hash==$data['hash'])
        {

                //store verdict in database
                $prepared  = "update transac_details set trans_no=?,status=?,amount=?,mode=?,bank_code=? where Ref_no=? and email=?";
                $params = array($data['payuMoneyId'],$data['status'],$data['amount'],$data['mode'],$data['bankcode'],$data['txnid'],$data['email']);
                $db->ins_del_query($prepared,$params);
                $verdict="SUCCESS";

<<<<<<< HEAD
=======


                echo "<h2 style='text-align: center;width: 100%;border: solid 2px green;color: #1e7e34;background-color: #c4e3f3;'>SUCCESS</h2><br>";
>>>>>>> 5399ff636303e2a3228ded300dff2fc434525b9b
        }
        else
           die("Something went wrong. Please try again.<br><a href='apply.php'>Back to Home Page</a> ");
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
            #button,#button1{
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
            #button:hover,#button1:hover{
                background-color: #29afbb;
            }
        </style>

    </head>
    <body>
<<<<<<< HEAD
    <h2 style='text-align: center;width: 100%;border: solid 2px green;color: #1e7e34;background-color: #c4e3f3;margin-bottom: 0px;'><?= $verdict ?></h2>";
        <h3 style="margin-top: 10px;">Please get a print of this receipt.</h3>
=======
        <h3 style="margin-top: 10px;">Please get a print of this reciept.</h3>
>>>>>>> 5399ff636303e2a3228ded300dff2fc434525b9b
        <div id="printdiv">
        <table id="table">
            <tr>
                <td><b>Status</b></td>
                <td style="text-transform: uppercase;"><?= $data['status']?></td>
<<<<<<< HEAD
            </tr>
            <tr>
=======
            </tr>            <tr>
>>>>>>> 5399ff636303e2a3228ded300dff2fc434525b9b
                <td><b>First Name</b></td>
                <td><?= $data['firstname']?></td>
            </tr>
            <tr>
                <td><strong>Reference ID</strong></td>
                <td><b><?= $data['txnid']?></b></td>
            </tr>
            <tr>
                <td><strong>Transaction ID</strong></td>
                <td><b><?= $data['payuMoneyId']?></b></td>
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
        <br>
        <br>
        </div>
        <a href="../index.html" id="button" style="font-size: medium;">Back to homepage</a>
        <button id="button1" style="font-size: medium;margin-left: 46%;" onclick="printElem()">Print</button>
    </body>

</html>

<script>
    function printElem() {
        var content = document.getElementById("printdiv").innerHTML;
        var mywindow = window.open('', 'Print', 'height=1080,width=1920');

        var style = "<style> \
                        #table { \
                            font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif; \
                            border-collapse: collapse; \
                            width: 50%; \
                            margin-left: 25%; \
                        } \
                        #table td, #table th { \
                            border: 1px solid #ddd; \
                            padding: 8px; \
                            text-align: center; \
                        } \
 \
                        #table tr:nth-child(even){background-color: #f2f2f2;text-align: center;} \
 \
                        #table tr:hover {background-color: #ddd;} \
 \
                        #table th { \
                            padding-top: 12px; \
                            padding-bottom: 12px; \
                            text-align: center; \
                            background-color: #29afbb; \
                            color: white;} \
 \
 \
            </style> ";

        mywindow.document.write('<html><head><title>Reciept</title>');
        mywindow.document.write(style);
        mywindow.document.write('</head><body >');
        mywindow.document.write(content);
        mywindow.document.write('</body></html>');

        mywindow.document.close();
        mywindow.focus()
        mywindow.print();
        mywindow.close();
        return true;
    }

</script>
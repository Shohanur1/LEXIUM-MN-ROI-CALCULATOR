<html>
    <head>
        <title>LEXIUM MN ROI Calculator</title>
        <meta name="description" content="A Simple Calculator to Calculate LEXIUM MN ROI">
        <meta name="author" content="alamin">
        <link rel="icon" href="http://lexiumcoin.org/images/logo.png" type="image/gif">
        <style type="text/css">
            body {
                font-weight: bold;
                font-size: 18px;
            }
            table, th, td {
                font-size: 18px;
                border: 2px solid #55a79a;
            }
            .input1 {
                text-align: center;
                font-weight: bold;
                font-size: 18px;
                width: 400px;
                height : 30px;
            }
            b {
                text-align: center;
                font-weight: bold;
                font-size: 18px;
                width: 400px;
                height : 30px;
            }
            .button {
                background-color: #55a79a; /* Green */
                border: none;
                color: white;
                padding: 16px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                -webkit-transition-duration: 0.4s; /* Safari */
                transition-duration: 0.4s;
                cursor: pointer;
            }
            .button1 {
                background-color: white; 
                color: black; 
                border: 2px solid #55a79a;
            }
            .button1:hover {
                background-color: #55a79a;
                color: white;
            }
            .option {
                text-align: center;
                font-size: 15px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <center><div style="max-width:50%; padding-bottom: 25px; border: 5px solid #55a79a;";>
            <h2>LEXIUM MN ROI Calculator</h1>
            <form method="POST">
                <input class="input1" name="tm" type="number" placeholder="Total MN Count on Network" size="100"><br><br>
                <input class="input1" name="ym" type="number" placeholder="Your MN Count on Network" size="100"><br><br>
                <input class="input1" name="lp" type="number" placeholder="LEXIUM Price in Satoshi" size="100"><br><br>
                <b>Your MN Status: &nbsp; </b> <select class="option" name="ms"><option value="1">Deployed</option><option value="0">Not Deployed</option></select><br><br>
                <input class="button button1" type="submit" value="Calculate!">
            </form>
<?php
if (isset($_POST['tm']) && isset($_POST['ym']) && isset($_POST['lp']) && isset($_POST['ms'])) {
    $tm = $_POST['tm'];
    $ym = $_POST['ym'];
    $lp = $_POST['lp'];
    $ms = $_POST['ms'];
    if ($tm > 0 && $ym > 0 && $lp > 0) {
        $get_rate = file_get_contents('https://blockchain.info/tobtc?currency=USD&value=1');
        $btc_rate = 1 / $get_rate;
        if ($ms == 1 && $tm > $ym) {
            $roi = round(((2880 / $tm) * $ym), 2); //Deployed
        } elseif ($ms == 0) {
            $roi = round(((2880 / ($tm + $ym)) * $ym), 2); //Not Deployed
        } else {
            echo '<b style="color:red;">Something is wrong!</b>';
        }
        $pbd = round((($lp * $roi) / 100000000), 9); //Profit in BTC (per day)
        $pud = round(($pbd * $btc_rate), 2); //Profit in USD (per day)
        $a_roi_p = round(((($roi * 365) / ($ym * 25000)) * 100), 2); //Annual ROI Percentage
        $dbl = round((($ym * 25000) / $roi), 2); //2x in Days
        echo '
            <table cellpadding="10">
                <tr>
                    <th>Period</th>
                    <th>LEXIUM</th>
                    <th>BTC</th>
                    <th>USD</th>
                </tr>
                <tr>
                    <td>1 Day</td>
                    <td>'.$roi.'</td>
                    <td>'.$pbd.'</td>
                    <td>'.$pud.'</td>
                </tr>
                <tr>
                    <td>1 Week</td>
                    <td>'.($roi * 7).'</td>
                    <td>'.($pbd * 7).'</td>
                    <td>'.($pud * 7).'</td>
                </tr>
                <tr>
                    <td>1 Month</td>
                    <td>'.($roi * 30).'</td>
                    <td>'.($pbd * 30).'</td>
                    <td>'.($pud * 30).'</td>
                </tr>
                <tr>
                    <td>1 Year</td>
                    <td>'.($roi * 365).'</td>
                    <td>'.($pbd * 365).'</td>
                    <td>'.($pud * 365).'</td>
                </tr>
            </table><br>
            <table cellpadding="10">
                <tr>
                    <td><b>Annual ROI</b></td>
                    <td>'.$a_roi_p.' %</td>
                </tr>
                <tr>
                    <td><b>100% ROI</b></td>
                    <td>'.$dbl.' days</td>
                </tr>
            </table>
        ';
    } else {
        echo '<b style="color:red;">Invalid Input!</b>';
    }
    
}
?>
        </div></center>
    </body>
</html>

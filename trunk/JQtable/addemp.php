<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ADD LOCATION</title>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {

                $("#hiredate").datepicker({dateFormat: 'dd-mm-yy'});
            });

        </script>
    </head>
    <body>
        <h1>ADD LOCATION</h1>
        <?php
        include 'connectdb.php';



        $total = 0;
        if (isset($_POST['back']))
            $back = $_POST['back'];
        else
            $back = $_SERVER['HTTP_REFERER'];

        if (isset($_POST['lid']) && isset($_POST['position']) && isset($_POST['address'])) {
              //echo $_POST['comm'];

            if ($_POST['lid'] != '') {
                $strSQL = "SELECT LID,POSITION,ADDRESS FROM LOCATION WHERE LID = " . ($_POST['lid']) . " ORDER BY LID ";
                $objParse = oci_parse($objConnect, $strSQL);
                $objExecute = oci_execute($objParse, OCI_DEFAULT);

                $total = oci_fetch_all($objParse, $Result);
                //  echo $total;
            }
            //  echo 'aa';
            if ($total == 0 && ctype_digit($_POST['lid']) && ctype_digit($_POST['position']) && ctype_alnum($_POST['address'])) {

             //   $ename = strtoupper($_POST["lid"]);
                $strSQL = "INSERT INTO LOCATION ";
                $strSQL .="(LID,POSITION,ADDRESS) ";
                $strSQL .="VALUES ";
                $strSQL .="('" . $_POST["lid"] . "','" . $_POST["position"] . "','" . $_POST["address"] . "') ";
                $objParse = oci_parse($objConnect, $strSQL);
                $objExecute = oci_execute($objParse, OCI_DEFAULT);
                if ($objExecute) {
                    oci_commit($objConnect); //*** Commit Transaction ***//

                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=" . $back . "\">";
                }

                exit;
            }
        }
        $a = array(0, 0, 0);
        if (isset($_POST['lid']) && (!ctype_digit($_POST['lid']) || $total > 0)) {
            $a[0] = 1;
        }
        if (isset($_POST['position']) && !ctype_digit($_POST['position'])) {
            $a[1] = 1;
        }
        if (isset($_POST['address']) && !ctype_alnum($_POST['address'])) {
            $a[2] = 1;
        }
        ?>
        <form id="frm1" action="addemp.php"  method="post">
            <table>
                <tr>
                    <td>LID :</td>
                    <td><input id="lid" name="lid" type="text" value="<?php if (isset($_POST['lid'])) echo $_POST['lid'] ?>"<?php if ($a[0] == 1) echo "style='background-color: #FFFF66;'" ?>/></td>
                </tr>
                <tr>
                    <td>Position :</td>
                    <td><input id="position" name="position" type="text" value="<?php if (isset($_POST['position'])) echo $_POST['position'] ?>"<?php if ($a[1] == 1) echo "style='background-color: #FFFF66;'" ?> /></td>
                </tr>
               
                <tr>
                    <td>Address :</td>
                    <td><input id="address" name="address" type="text" value="<?php if (isset($_POST['address'])) echo $_POST['address'] ?>" <?php if ($a[2] == 1) echo "style='background-color: #FFFF66;'" ?> /></td>
                </tr>
                
                <tr>

                    <td><input id="back" name="back" type="hidden" value="<?php echo $back; ?>" /></td>
                </tr>
                <tr>

                    <td><input id="submit" name="submit" type="submit" value="เพิ่มสถานที่" /></td>
                </tr>
            </table>

        </form>
        <form id="frm" action="<?php echo $back ?>" methid="post">

            <input type="submit" value="back." />
        </form>
    </body>
</html>

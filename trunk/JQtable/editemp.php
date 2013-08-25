<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>EDIT LOCATION</title>
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
        <h1>EDIT EMP</h1>
        <?php
        $username = "NAMMON";
        $password = "123456789";
        $hostname = "//localhost/XE";



        $objConnect = oci_connect($username, $password, $hostname);
        $total = 0;
        if (isset($_POST['back']))
            $back = $_POST['back'];
        else
            $back = $_SERVER['HTTP_REFERER'];

        if (isset($_POST['lid']) && isset($_POST['position']) && isset($_POST['address'])) {
            //  echo $_POST['comm'];
            $total = 0;
            if ($_POST['lid'] != '') {
                $strSQL = "SELECT LID,POSITION,ADDRESS FROM LOCATION WHERE LID = " . ($_POST['lid']) . " ORDER BY LID ";
                $objParse = oci_parse($objConnect, $strSQL);
                $objExecute = oci_execute($objParse, OCI_DEFAULT);

                $total = oci_fetch_all($objParse, $Result);
                //  echo $total;
            }
           
            if ($total > 0  && ctype_digit($_POST['position']) && ctype_alnum($_POST['address'])) {

               // $ename = strtoupper($_POST["ename"]);
                $strSQL = "UPDATE LOCATION SET ";
                $strSQL .="LID='" . $_POST["lid"] . "',POSITION='" . $_POST["position"] . "',ADDRESS='" . $_POST["address"] . "' ";
                $strSQL .= "WHERE LID='" . $_POST['lid'] . "'";
              //  echo $strSQL;
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
        if (isset($_POST['lid']) && (!ctype_digit($_POST['lid']) || $total == 0)) {
            $a[0] = 1;
            $lid = $_POST['lid'];
        }
        if (isset($_POST['position']) && !ctype_digit($_POST['position'])) {
            $a[1] = 1;
            $position = $_POST['position'];
        }
		if (isset($_POST['address']) && !ctype_alnum($_POST['address'])) {
            $a[2] = 1;
            $address = $_POST['address'];
        }
        
        if (!isset($_POST['lid']) || !isset($_POST['position']) || !isset($_POST['address'])) {
            $strSQL = "SELECT LID ,POSITION,ADDRESS FROM LOCATION WHERE LID = '" . $_GET['lid'] . "' ORDER BY lid ";

            $objParse = oci_parse($objConnect, $strSQL);
            $objExecute = oci_execute($objParse, OCI_DEFAULT);
            $lid = '';
            $position = '';
            $address = '';
            
            while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
                $lid = $row['LID'];
                $position = $row['POSITION'];
                $address = $row['ADDRESS'];
                
            }
        }
        ?>
        <form id="frm1" action="editemp.php"  method="post">
            <table>
                <tr>
                    <td>LID :</td>
                    <td><input readonly="readonly" id="lid" name="lid" type="text" value="<?php
                        if (isset($_POST['lid']))
                            echo $_POST['lid'];
                        else
                            echo $lid;
                        ?> "/></td>

                </tr>
                <tr>
                    <td>POSITION :</td>
                    <td><input id="position" name="position" type="text" value="<?php
                        if (isset($_POST['position']))
                            echo $_POST['position'];
                        else
                            echo $position;
                        ?>"<?php if ($a[1] == 1) echo "style='background-color: #FFFF66;'" ?> /></td>
                </tr>
				<tr>
                    <td>ADDRESS :</td>
                    <td><input id="address" name="address" type="text" value="<?php
                        if (isset($_POST['address']))
                            echo $_POST['address'];
                        else
                            echo $address;
                        ?>"<?php if ($a[2] == 1) echo "style='background-color: #FFFF66;'" ?> /></td>
                </tr>
              
                
                <tr> 

                    <td><input id="back" name="back" type="hidden" value="<?php echo $back; ?>" /></td>
                </tr>
                <tr>

                    <td><input id="submit" name="submit" type="submit" value="แก้ไขรายละเอียดสถานที่" /></td>
                </tr>
            </table>

        </form>
        <form id="frm" action="<?php echo $back ?>" methid="post">

            <input type="submit" value="back." />
        </form>
    </body>
</html>

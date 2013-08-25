<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Datatables Sample</title>
        <style type="text/css" title="currentStyle">
            @import "css/demo_page.css";
            @import "css/demo_table_jui.css";
            @import "css/jquery-ui-1.8.4.custom.css";
            @import "css/ColReorder.css";
        </style>
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="js/ColReorder.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#employeestable').dataTable({
                    "sDom": 'R<"H"lfr>t<"F"ip>',
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers"
                });
            });
            function onDelete()
            {
                if (confirm('Do you want to delete ?') == true)
                {
                    document.getElementById('frm').submit();
                    return true;
                }
                else
                {
                    return false;
                }
            }

        </script>
    </head>
    <body>

        <div style="width: 100%;">
            <h1>DataTables</h1> 
            <form name="create" action="addemp.php" method="post">
                <input id="submit" name="newemp" type="submit" value="เพิ่มพนักงาน"/>
            </form>
            <br/>

            <form id="frm" style="float:left;width: 100%;" name="delete" action="datatable.php" method="post" >
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="employeestable" width="100%">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสพนักงาน</th>
                            <th>ชื่อ</th>
                            <th>ตำแหน่ง</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                           include 'connectdb.php';




                        $strSQL = "SELECT EMPNO,ENAME,JOB FROM EMP ORDER BY EMPNO ";

                        $objParse = oci_parse($objConnect, $strSQL);
                        $objExecute = oci_execute($objParse, OCI_DEFAULT);

                        while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
                            //   if ($row['typeroom'] == 'fan-room') {
                            $td = ' <tr class="gradeA">';
                            //     } else {
                            //         $td = ' <tr class="gradeU">';
                            //     }
                            $td = $td . ' <td class="center">' . '<input name="checkbox[]" type="checkbox" id="checkbox[]" value="' . $row['EMPNO'] . '">' . '</td>';
                            $td = $td . ' <td class="center">' . $row['EMPNO'] . '</td>';
                            $td = $td . ' <td class="center">' . $row['ENAME'] . '</td>';
                            $td = $td . ' <td class="center">' . $row['JOB'] . '</td>';
                            $td = $td . ' <td class="center"><a href="editemp.php?empno='. $row['EMPNO'] .'">แก้ไข </a></td>';
                            $td = $td . '</tr>';
                            echo $td;
                        }
                        ?>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>รหัสพนักงาน</th>
                            <th>ชื่อ</th>
                            <th>ตำแหน่ง</th>
                            <th>แก้ไข</th>
                        </tr>
                    </tfoot>
                </table>

                <input id="delete" name="delete"  type="submit" value="ลบพนักงาน" onClick="onDelete();
                return false;"/>
            </form><br/>  <br/> 
            <form action="index.php">
                <input type="submit" value="back." />
            </form>
            <?php
            //   echo 'i';

            if (isset($_POST["checkbox"])) {
                // echo 'Here';

               for ($i = 0; $i < count($_POST["checkbox"]); $i++) {
                    if ($_POST["checkbox"][$i] != "") {
                        $strSQL = "DELETE FROM EMP ";
                        $strSQL .="WHERE EMPNO = " . $_POST["checkbox"][$i] . "";
                        //echo $strSQL ;
                        $objParse = oci_parse($objConnect, $strSQL);
                        $objExecute = oci_execute($objParse, OCI_DEFAULT);
                        if ($objExecute) {
                            oci_commit($objConnect); //*** Commit Transaction ***//
                        }
                    }
                }

                echo "<meta http-equiv=\"refresh\" content=\"0;URL=datatable.php\">";
            }

         //   exit;
            ?>

        </div>

    </body>
</html>

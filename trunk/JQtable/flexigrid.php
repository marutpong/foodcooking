<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Flxigrid Sample</title>
        <link rel="stylesheet" type="text/css" href="css/flexigrid.css" />

    </head>

    <body>
        <h1>Flexigrid</h1>
        <?php
        //   echo 'i';
        $username = "NAMMON";
        $password = "123456789";
        $hostname = "//localhost/XE";



        $objConnect = oci_connect($username, $password, $hostname);

        if (isset($_GET["delete"])) {
            // echo 'Here';


            if ($_GET["delete"] == "1") {
                $strSQL = "DELETE FROM LOCATION ";
                $strSQL .="WHERE LID = '" . $_GET["lid"] . "' ";
                $objParse = oci_parse($objConnect, $strSQL);
                $objExecute = oci_execute($objParse, OCI_DEFAULT);
                if ($objExecute) {
                    oci_commit($objConnect); //*** Commit Transaction ***//
                }
            }

            echo "<meta http-equiv=\"refresh\" content=\"0;URL=flexigrid.php\">";
        }

        
        ?>
        <table id="myflexigrid" style="display:none"></table>
        <form name="nxt" action="seedfarm.php" method="post">
            <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
            <script type="text/javascript" src="js/flexigrid.js"></script>  
            <script type="text/javascript">
                $(document).ready(function() {

                    $("#myflexigrid").flexigrid({
                        url: "flexigriddb.php",
                        dataType: 'json',
                        colModel: [{display: 'รหัสสถานที่', name: 'LID', width: 100, sortable: true, align: 'center'},
                            {display: 'ตำแหน่ง', name: 'POSITION', width: 300, sortable: true, align: 'center'},
                            {display: 'สถานที่', name: 'ADDRESS', width: 300, sortable: true, align: 'center'},
                        ],
                        buttons: [
                            {name: 'Add', bclass: 'add', onpress: test},
                            {name: 'Edit', bclass: 'edit', onpress: test},
                            {name: 'Delete', bclass: 'delete', onpress: test},
                            {separator: true}
                        ],
                        searchitems: [
                            {display: 'รหัสสถานที่.', name: 'LID', isdefault: true},
                            {display: 'ตำแหน่ง', name: 'POSITION'}
                        ],
                        sortname: "lid",
                        sortorder: 'asc',
                        usepager: true,
                        title: 'EMPLOYEE LIST',
                        useRp: true,
                        rp: 10,
                        showTableToggleBtn: true,
                        singleSelect: true,
                        width: 750,
                        height: 255
                    });

                    function test(com, grid) {
                        if (com == 'Add') {
                            // alert(window.location.host);
                            window.location = "/JQtable/addemp.php";
                        }
                        else if (com == 'Delete') {
                            $('.trSelected', grid).each(function() {


                                var id = $(this).attr('id');
                                id = id.substring(id.lastIndexOf('row') + 3);
                                if (confirm('Confirm Delete LID = ' + id + '?') == true)
                                    window.location = "/JQtable/flexigrid.php?lid=" + id + "&delete=1";
                                    
                            });

                        }
                        else if (com == 'Edit') {
                            $('.trSelected', grid).each(function() {
                                var id = $(this).attr('id');
                                id = id.substring(id.lastIndexOf('row') + 3);
                                if (confirm('Confirm Edit EMPNO = ' + id + '?') == true)
                                    window.location = "/JQtable/editemp.php?lid=" + id;
                            });
                        }
                    }


                });
            </script>
        </form><br/>
        <form action="index.php">
            <input type="submit" value="back." />
        </form>
    </body>
</html>
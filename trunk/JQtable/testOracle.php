<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test Oracle</title>
      
    </head>
    <body>

        
            <h1>Test Oracle</h1> 
            
                        <?php
                        $username = "TUKKY"; /// workspace
                        $password = "tuktuk"; //password
                        $hostname = "//localhost/XE";



                        $objConnect = oci_connect($username, $password, $hostname);


                        $strSQL = "SELECT EMPNO,ENAME,JOB FROM EMP ORDER BY EMPNO ";

                        $objParse = oci_parse($objConnect, $strSQL);
                        $objExecute = oci_execute($objParse, OCI_DEFAULT);

                        while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
                            //   if ($row['typeroom'] == 'fan-room') {
                           echo "EMPNO :".$row['EMPNO']."<br/>" ;
                        }
                        ?>



    </body>
</html>

<!DOCTYPE HTML>
<html>
<head>
<title>Add Food</title>
<meta charset="UTF-8" />
<link href="css/flexigrid2.css" rel="stylesheet" type="text/css">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" src="js/jquery.numeric.js"></script>

 	<?
		include 'connectDB.php'; 
		$strSQL = "SELECT * FROM IINGREDIENT";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rows.= '<option value="'.$row['IID'].'">'.$row['NAME'].'</option>';
		}
		
		$strSQL = "SELECT * FROM ITOOLS";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rowsTools="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rowsTools.= '<option value="'.$row['TID'].'">'.$row['NAME'].'</option>';
		}
	?>
<script type="text/javascript">
$(document).ready(function() {
		//$( "#combobox" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<table border="0">\
    	  <tr>\
    	    <td><select class="labelF" id="combobox" name="ingredient[]" onChange="getUnit(this)" required>\
    	      <option value=""></option>\
    	      <? echo $rows;?></select>\
  	      </td>\
    	    <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" tabindex="1" size="10" \
            onFocus="checkNum(this)"></td>\
    	    <td><input name="unit[]" type="text"  required disabled class="input unit" id="unit[]" tabindex="1" size="10"></td>\
  	    </tr>\
  	  </table>';
			$('#addIngre').append(htmlStr);
			//$( ".combobox" ).combobox();
		});
		$('#addToolMore').click(function () {
			var htmlStr = '<table border="0">\
            <tr>\
              <td><select class="labelF" id="combobox" name="tool[]"  required>\
                <option value=""></option>\
                <? echo $rowsTools;?></select></td>\
              </tr>\
          </table>';
			$('#addTool').append(htmlStr);
		});
		

	});
	
	
var checkNum = function(evt) { 
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus();
			$('.unit').val("11");
		});
}
var getUnit = function(evt) {
	var url = 'getunit.php?id='+$(evt).val();
	$.get(url, function(data) {
		$(evt).parent().next().next().find("input").val(data);
	});
}
</script>

  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
  </style>
  <script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  </script>
</head>
<body>
<?
if (isset($_POST['name']) && isset($_POST['picture']) && isset($_POST['method']) && isset($_POST['views']) && $_POST['confirm']==1){
	$name = $_POST['name'];
	$picture = $_POST['picture'];
	$method = $_POST['method'];
	$views = $_POST['views'];
	include 'connectDB.php'; 
	if (is_numeric($_POST['views'])){	
			$sql = "INSERT INTO $table (NAME, PICTURE, METHOD, VIEWS) VALUES ('$name','$picture','$method','$views')";
			$strSQL = $sql;
			//echo $sql;
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
	}
	
	echo '<br><br><br><center><div class="textC1">';
	if($count){
		$strSQL = "
		SELECT x.* , ROWNUM r FROM 
		   ( SELECT * FROM IFOODS ORDER BY FID DESC) x
		 WHERE ROWNUM = 1";
		$objParse = oci_parse($objConnect, $strSQL);
    	$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$row = oci_fetch_array($objParse, OCI_BOTH);	   	
		$fid =  $row['FID'];
		//echo $fid;
		if ( isset($_POST['ingredient']) && isset($_POST['quantity']) && (is_numeric($fid)) ){
			$ingredient = $_POST['ingredient'];
			$quantity = $_POST['quantity'];
			$num = count($_POST['ingredient']);
			for ($i=0;$i<$num;$i++){
				if (is_numeric($_POST['quantity'][$i])){	
					$sql = "INSERT INTO ICONTAIN (FID, IID, QUANTITY) VALUES ('$fid','$ingredient[$i]','$quantity[$i]')";
					$strSQL = $sql;
					$objParse = oci_parse($objConnect , $strSQL);
					$objExecute = oci_execute($objParse);
				}
			}
		}
		if ( isset($_POST['tool']) && (is_numeric($fid)) ){
			$tool = $_POST['tool'];
			$num = count($_POST['tool']);
			for ($i=0;$i<$num;$i++){
				if (is_numeric($_POST['tool'][$i])){	
					$sql = "INSERT INTO IUSE (FID, TID) VALUES ('$fid','$tool[$i]')";
					$strSQL = $sql;
					$objParse = oci_parse($objConnect , $strSQL);
					$objExecute = oci_execute($objParse);
				}
			}
		}
		
		echo 'Add Succesful '.$count.' items<P>';
		echo '<a href="addMul.php"  class="button_addmore">Add more Food</a>';
	} else {
		echo 'Unsuccessful, some input are incorect.';
	}
	echo '</div></center>';
} else {
?>
<div style="width:400">
<form action="" method="post">
<div>
    <table id="dynamic_tb">
	    <tr class="labelF">
	      <td align="right" valign="top">ชื่ออาหาร :</td>
	      <td><input name="name" type="text"  required class="input" id="name" tabindex="1" size="50"></td>
        </tr>
	    <tr>
	      <td align="right" valign="top"><span class="labelF">รูปภาพ :</span></td>
	      <td><span class="labelF">
	        <input name="picture" type="text"  required class="input" id="picture" tabindex="2" size="50">
	      </span></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">วิธีทำ :</td>
	      <td><textarea name="method" cols="50" rows="10" required class="input" id="method" tabindex="2"></textarea>
          <input name="views" type="hidden" required class="input number" id="views" tabindex="2" value="0"></td>
        </tr>
    </table>
    <table>
      <tr>
        <td valign="top" class="labelF">ส่วนผสม :</td>
        <td><div id="addIngre">
          <table border="0">
            <tr>
              <td><select class="labelF" id="combobox" name="ingredient[]" onChange="getUnit(this)" required>
                <option value=""></option>
                <? echo $rows;?>
              </select></td>
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" tabindex="1" size="10" 
            onFocus="checkNum(this)"></td>
              <td><input name="unit[]" type="text"  required disabled class="input unit" id="unit[]" tabindex="1" size="10"></td>
            </tr>
          </table>
        </div></td>
        </tr>
    </table>
    <div class="button_addmore" id="addmore" tabindex="4" ><img src="css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
</div>

<table>
      <tr>
        <td valign="top" class="labelF">อุปกรณ์ :</td>
        <td><div id="addTool">
          <table border="0">
            <tr>
              <td><select class="labelF" id="combobox" name="tool[]"  required>
                <option value=""></option>
                <? echo $rowsTools;?>
              </select></td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table>
    <div class="button_addmore" id="addToolMore" tabindex="4" ><img src="css/images/add.png" width="16" height="16">เพิ่มอุปกรณ์</div>

	<footer>
	  <p>
	    <input name="confirm" type="hidden" value="1">
	    <br>
<center><input type="submit" class="button_sub" value="เพิ่ม" tabindex="4"></center>
      </p>
</footer>
</form>
</div>
<? } ?>

</body>
</html>

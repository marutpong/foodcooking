<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Food</title>
	<link rel="stylesheet" href="../core/css/style.css" /> 
	<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="../core/js/flexigrid.js"></script>
    <script type="text/javascript" src="../core/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../core/js/jquery.min-1.8.3.js"></script>
    <script type="text/javascript" src="../core/js/flexigrid.pack.js"></script>
    <link href="../core/css/flexigrid2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../core/fancyapps/source/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../core/fancyapps/source/jquery.fancybox.css" media="screen" />
</head>
<body>
<h2>Food</h2>
<div class="fancybox2" style="display: none">ddddddddd</div>
	<table class="flexme3" style="display: none"></table>
	<script type="text/javascript">
		$(".flexme3").flexigrid({
			url : 'post-xml.php',
			dataType : 'xml',
			colModel : [ 
				{ display : 'ลำดับ', name : 'FID', width : 40, sortable : true, align : 'center' }, 
				{ display : 'ชื่ออาหาร', name : 'NAME', width : 180, sortable : true, align : 'left' }, 
				{ display : 'รูปภาพ', name : 'PICTURE', width : 120, sortable : true, align : 'left' }, 
				{ display : 'วิธีทำ', name : 'METHOD', width : 130, sortable : true, align : 'left', }, 
				{ display : 'จำนวนคนดู', name : 'VIEW', width : 130, sortable : true, align : 'left', } 
			],
			buttons : [ 
				{ name : 'Add', bclass : 'add', onpress : test}, 
                {name: 'Edit', bclass: 'edit', onpress : test},
				{ name : 'Delete', bclass : 'delete', onpress : test}, 
				{separator : true}
			],
			searchitems : [ 
				{ display : 'ลำดับ', name : 'FID'}, 
				{ display : 'ชื่ออาหาร', name : 'NAME', isdefault : true},
				
			],
			sortname : "FID",
			sortorder : "desc",
			usepager : true,
			title : 'Food',
			useRp : true,
			rp : 10,
			showTableToggleBtn : true,
			width : 700,
			height : 300
		});

		function test(com, grid) {
			if (com == 'Delete') {
				if ($('.trSelected', grid).length==0){
					alert("Please select any record to delete.");
				} else if(confirm('Delete ' + $('.trSelected', grid).length + ' items?')){
					//$.get('delete.php?id='+$('.trSelected', grid));
					var items = $('.trSelected',grid);
                    var itemlist ='';
                    for(i=0;i<items.length;i++){
                        itemlist+= items[i].id.substr(3)+",";
                    }
					//alert(itemlist);
					$.fancybox.open({
					href : 'delete.php?confirm=1&ids='+itemlist,
					type : 'iframe',
					padding: 0,
					openEffect : 'elastic',
					openSpeed  : 150,
					closeEffect : 'elastic',
					closeSpeed  : 150,
					width  : 500,
					height : 1000,
					afterClose : function() {
						window.location.reload();
					}
				});
				}
			} else if (com == 'Add') {
				$.fancybox.open({
					href : 'addMul.php',
					type : 'iframe',
					width  : 420,
					height : 500,
					fitToView   : true,
					autoSize    : false,
					padding: 5,
					openEffect : 'elastic',
					openSpeed  : 150,
					closeEffect : 'elastic',
					closeSpeed  : 150,
					afterClose : function() {
						window.location.reload();
					}
				});

			} else if (com == 'Edit') {
				if ($('.trSelected', grid).length==0){
					alert("Please select any record to edit.");
				} else if(confirm('Edit ' + $('.trSelected', grid).length + ' items?')){
					//$.get('delete.php?id='+$('.trSelected', grid));
					var items = $('.trSelected',grid);
                    var itemlist ='';
                    for(i=0;i<items.length;i++){
                        itemlist+= items[i].id.substr(3)+",";
                    }
					//alert(itemlist);
					$.fancybox.open({
					href : 'edit.php?confirm=1&ids='+itemlist,
					type : 'iframe',
					padding: 5,
					width  : 600,
					openEffect : 'elastic',
					openSpeed  : 150,
					closeEffect : 'elastic',
					closeSpeed  : 150,
					width  : 600,
					height : 1000,
					afterClose : function() {
						window.location.reload();
					}
				});
				}
			}
		}
	</script>
</body>
</html>
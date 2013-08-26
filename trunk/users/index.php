<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Ingredient</title>
	<link rel="stylesheet" href="css/style.css" /> 
	<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="js/flexigrid.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/flexigrid.pack.js"></script>
    <link href="css/flexigrid2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="./fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="./fancyapps/source/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="./fancyapps/source/jquery.fancybox.css" media="screen" />
</head>
<body>
<h2>Ingredient</h2>
<div class="fancybox2" style="display: none">Users</div>
	<table class="flexme3" style="display: none"></table>
	<script type="text/javascript">
		$(".flexme3").flexigrid({
			url : 'post-xml2.php',
			dataType : 'xml',
			colModel : [ 
				{ display : 'ลำดับ', name : 'ID', width : 40, sortable : true, align : 'center' }, 
				{ display : 'ชื่อ', name : 'NAME', width : 180, sortable : true, align : 'left' }, 
				{ display : 'Username', name : 'USERNAME', width : 120, sortable : true, align : 'left' }, 
				{ display : 'เพศ', name : 'GENDER', width : 130, sortable : true, align : 'left', }, 
				{ display : 'วันเกิด', name : 'BIRTHDATE', width : 130, sortable : true, align : 'left', }
			],
			buttons : [ 
				{ name : 'Add', bclass : 'add', onpress : test}, 
                {name: 'Edit', bclass: 'edit', onpress : test},
				{ name : 'Delete', bclass : 'delete', onpress : test}, 
				{separator : true}
			],
			searchitems : [ 
				{ display : 'ลำดับ', name : 'ID'}, 
				{ display : 'ชื่อ', name : 'NAME', isdefault : true},
				{ display : 'Username', name : 'USERNAME'}, 
				{ display : 'วันเกิด', name : 'BIRTHDATE'}
			],
			sortname : "ID",
			sortorder : "desc",
			usepager : true,
			title : 'Ingredient',
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
					alert(itemlist);
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
					width  : 400,
					height : 300,
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
					width  : 470,
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
			}
		}
	</script>
</body>
</html>
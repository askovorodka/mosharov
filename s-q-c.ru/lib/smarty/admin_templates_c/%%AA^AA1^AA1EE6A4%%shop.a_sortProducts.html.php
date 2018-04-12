<?php /* Smarty version 2.6.11, created on 2016-03-01 17:59:00
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_sortProducts.html */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="templates/style.css">
<?php echo '
<script language="JavaScript" type="text/javascript" src="templates/core.js"></script>
<script language="JavaScript" type="text/javascript" src="templates/events.js"></script>
<script language="JavaScript" type="text/javascript" src="templates/css.js"></script>
<script language="JavaScript" type="text/javascript" src="templates/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="templates/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="templates/dragsort.js"></script>
<script language="JavaScript" type="text/javascript" src="templates/cookies.js"></script>
<script language="JavaScript" type="text/javascript"><!--
	var dragsort = ToolMan.dragsort()
	var junkdrawer = ToolMan.junkdrawer()

	window.onload = function() {
		//junkdrawer.restoreListOrder("sortList")
		dragsort.makeListSortable(document.getElementById("sortList"), verticalOnly, saveOrder)
	}

	function verticalOnly(item) {
		item.toolManDragGroup.verticalOnly()
	}

	function speak(id, what) {
		var element = document.getElementById(id);
		element.innerHTML = \'Clicked \' + what;
	}

	function saveOrder(item) {
	}

	//-->
</script>
'; ?>

<title>Список продукции</title>
</head>
<body>
<?php if (trim ( $this->_tpl_vars['message'] ) != ""): ?>
<script language="javascript" type="text/javascript">
<!--//
	window.opener.location.reload();
//-->
</script>
<?php endif; ?>
<form action="" method="post" onSubmit="junkdrawer.getSortList('sortList')" name="frmSort">
	<input type="hidden" name="sortArray" value="">
	<input type="hidden" name="cat_id" value="<?php echo $_GET['cat']; ?>
">
	<table width="100%" border="0">
		<tr>
			<td width="100%" height="100%">
				<?php if (count ( $this->_tpl_vars['items'] ) > 0): ?>
					<ul id="sortList" class="sortBox">
						<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
							<li itemID="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</li>
						<?php endforeach; endif; unset($_from); ?>
					</ul>
				<?php else: ?>
					<center>Список продукции отсутсвует</center>
				<?php endif; ?>
			</td>
		</tr>
	</table>
	<center>
	<input type="submit" value="Сортировать" name="submit_sort_products" class="hand">&nbsp;<input type="button" onClick="window.close();" value="Закрыть"  class="hand"></center>
</form>
</body>
</html>
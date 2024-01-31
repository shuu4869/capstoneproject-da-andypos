<?php require_once('Connections/andypos_connect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_GET['search'])) {
  $search_term = $_GET['search'];
  $query_Rec_menulist = "SELECT menulist.*, menutype.type_name FROM menulist INNER JOIN menutype ON menulist.type_id = menutype.type_id WHERE menu_name LIKE '%" . $search_term . "%' ORDER BY menu_id ASC";
} else {
  $query_Rec_menulist = "SELECT menulist.*, menutype.type_name FROM menulist INNER JOIN menutype ON menulist.type_id = menutype.type_id ORDER BY menu_id ASC";
}

mysql_select_db($database_andypos_connect, $andypos_connect);
$Rec_menulist = mysql_query($query_Rec_menulist, $andypos_connect) or die(mysql_error());
$row_Rec_menulist = mysql_fetch_assoc($Rec_menulist);
$totalRows_Rec_menulist = mysql_num_rows($Rec_menulist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!-- Navbar================================================================-->
<title>Andy Coffee&amp;Friends</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Navbar================================================================-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AndyPOS</title>

<!-- เพิ่มไฟล์ css-->
<link rel="stylesheet" type="text/css" href="editbutton.css"> 
<link rel="stylesheet" type="text/css" href="deletebutton.css">
<link rel="stylesheet" type="text/css" href="add.css">
<link rel="stylesheet" type="text/css" href="searchbar.css">

<style type="text/css">
.text-kanit {
  font-family: Kanit;
  font-size: 16px;
}

/* ปรับขนาดตาราง */
table {
    width: 80%;
    table-layout: fixed;
}

/* ปรับระยะห่างของบรรทัด */
table tr {
    margin: 50px 0; /* ปรับระยะห่างระหว่างบรรทัดด้านบนและด้านล่าง */
}


</style>

</head>

<body>

<!-- Navbar================================================================-->
<nav class="navbar navbar-inverse">
  <div class="text-kanit">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Andy Coffee&Friends </a>
    </div>
    <ul class="nav navbar-nav">
      <li class=""><a href="Index.php">POS</a></li>
      <li><a href="menu_edit_menu.php">Menu</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Sale <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">สรุปบิลประจำวัน</a></li>
          <li><a href="#">สรุปบิลประจำเดือน</a></li>
          <li><a href="#">สรุปการขายสินค้า</a></li>
        </ul>
      </li>
      
      <li><a href="#">About</a></li>
    </ul>
  </div>
</nav>
<p>
  <!-- Navbar================================================================-->
  
</p>
<p>&nbsp;</p>
<table width="80%" border="0" align="center">
  <tr align="right">
    <td width="52%" class="text-kanit"><form action="" method="get">
        <p>
          <input type="text" name="search" placeholder="ป้อนชื่อเมนู" />
          <input type="submit" value="Search" />
        </p>
        <p>&nbsp;</p>
    </form></td>
    <td width="2%" align="left" class="text-kanit">&nbsp;</td>
    <td width="46%" align="left" class="text-kanit"><p><a href="menu_insert.php" class="add-new-button">Add New</a></p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="text-kanit"><table width="60%" border="0" align="center" cellpadding="10">
        <tr>
          <td width="13%" height="54" align="center" bgcolor="#66CCFF"><strong>ID</strong></td>
          <td width="26%" align="center" bgcolor="#66CCFF"><strong>Name</strong></td>
          <td width="18%" align="center" bgcolor="#66CCFF"><strong>Type</strong></td>
          <td width="14%" align="center" bgcolor="#66CCFF"><strong>Price</strong></td>
          <td width="14%" align="center" bgcolor="#66CCFF"><strong>Cost</strong></td>
          <td width="7%" align="center" bgcolor="#66CCFF"><strong>Edit</strong></td>
          <td width="8%" align="center" bgcolor="#66CCFF"><strong>Delete</strong></td>
        </tr>
        <?php do { ?>
          <tr>
            <td align="center"><?php echo $row_Rec_menulist['menu_id']; ?></td>
            <td align="center"><?php echo $row_Rec_menulist['menu_name']; ?></td>
            <td align="center"><?php echo $row_Rec_menulist['type_id']; ?> - <?php echo $row_Rec_menulist['type_name']; ?></td>
            <td align="center"><?php echo $row_Rec_menulist['menu_price']; ?></td>
            <td align="center"><?php echo $row_Rec_menulist['menu_cost']; ?></td>
            <td align="center"><a href="menu_edit.php?mid=<?php echo $row_Rec_menulist['menu_id']; ?>" class="edit-button">Edit</a></td>
            <td align="center"><a href="menu_delete.php?mid=<?php echo $row_Rec_menulist['menu_id']; ?>" class="delete-button">Delete</a></td>
          </tr>
          <?php } while ($row_Rec_menulist = mysql_fetch_assoc($Rec_menulist)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Rec_menulist);
?>

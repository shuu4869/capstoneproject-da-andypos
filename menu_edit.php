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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE menulist SET menu_name=%s, menu_price=%s, menu_cost=%s, type_id=%s WHERE menu_id=%s",
                       GetSQLValueString($_POST['menu_name'], "text"),
                       GetSQLValueString($_POST['menu_price'], "double"),
                       GetSQLValueString($_POST['menu_cost'], "double"),
                       GetSQLValueString($_POST['type_id'], "text"),
                       GetSQLValueString($_POST['menu_id'], "int"));

  mysql_select_db($database_andypos_connect, $andypos_connect);
  $Result1 = mysql_query($updateSQL, $andypos_connect) or die(mysql_error());

  $updateGoTo = "menu_edit_menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Rec_menu = "-1";
if (isset($_GET['mid'])) {
  $colname_Rec_menu = $_GET['mid'];
}
mysql_select_db($database_andypos_connect, $andypos_connect);
$query_Rec_menu = sprintf("SELECT * FROM menulist WHERE menu_id = %s", GetSQLValueString($colname_Rec_menu, "int"));
$Rec_menu = mysql_query($query_Rec_menu, $andypos_connect) or die(mysql_error());
$row_Rec_menu = mysql_fetch_assoc($Rec_menu);
$totalRows_Rec_menu = "-1";
if (isset($_GET['mid'])) {
  $totalRows_Rec_menu = $_GET['mid'];
}
$colname_Rec_menu = "-1";
if (isset($_GET['mid'])) {
  $colname_Rec_menu = $_GET['mid'] ;
}
mysql_select_db($database_andypos_connect, $andypos_connect);
$query_Rec_menu = sprintf("SELECT menulist.*, menutype.type_name FROM menulist INNER JOIN menutype ON menulist.type_id = menutype.type_id WHERE menu_id = %s", GetSQLValueString($colname_Rec_menu, "int"));
$Rec_menu = mysql_query($query_Rec_menu, $andypos_connect) or die(mysql_error());
$row_Rec_menu = mysql_fetch_assoc($Rec_menu);
$totalRows_Rec_menu = mysql_num_rows($Rec_menu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Menu ID*:</td>
            <td><?php echo $row_Rec_menu['menu_id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Menu Name*:</td>
            <td><input type="text" name="menu_name" value="<?php echo htmlentities($row_Rec_menu['menu_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Price*:</td>
            <td><input type="text" name="menu_price" value="<?php echo htmlentities($row_Rec_menu['menu_price'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Cost*:</td>
            <td><input type="text" name="menu_cost" value="<?php echo htmlentities($row_Rec_menu['menu_cost'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Type*:</td>
            <td><input type="text" name="type_id" value="<?php echo htmlentities($row_Rec_menu['type_id'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="  Save  " /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="menu_id" value="<?php echo $row_Rec_menu['menu_id']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Rec_menu);
?>

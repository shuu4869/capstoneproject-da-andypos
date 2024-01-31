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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO menulist (menu_id, menu_name, menu_price, menu_cost, type_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['menu_id'], "int"),
                       GetSQLValueString($_POST['menu_name'], "text"),
                       GetSQLValueString($_POST['menu_price'], "double"),
                       GetSQLValueString($_POST['menu_cost'], "double"),
                       GetSQLValueString($_POST['type_id'], "text"));

  mysql_select_db($database_andypos_connect, $andypos_connect);
  $Result1 = mysql_query($insertSQL, $andypos_connect) or die(mysql_error());
  
  // เมื่อสำเร็จในการเพิ่มข้อมูล ให้เปลี่ยนไปยังหน้า result.php
  header("Location: result.php");
  exit;
}

mysql_select_db($database_andypos_connect, $andypos_connect);
$query_Rec_type = "SELECT * FROM menutype";
$Rec_type = mysql_query($query_Rec_type, $andypos_connect) or die(mysql_error());
$row_Rec_type = mysql_fetch_assoc($Rec_type);
$totalRows_Rec_type = mysql_num_rows($Rec_type);

mysql_select_db($database_andypos_connect, $andypos_connect);
$query_Rec_maxnum = "SELECT MAX(menulist.menu_id) AS max_num FROM menulist";
$Rec_maxnum = mysql_query($query_Rec_maxnum, $andypos_connect) or die(mysql_error());
$row_Rec_maxnum = mysql_fetch_assoc($Rec_maxnum);
$totalRows_Rec_maxnum = mysql_num_rows($Rec_maxnum);


$max_num = $row_Rec_maxnum['max_num'];

// เพิ่มเลขที่ต่อจากรายการล่าสุด
$new_num = $max_num + 1;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.text-warning {
	color: #F00;
}
</style></head>

<body>

<p>&nbsp;</p>
<p>&nbsp;</p>
<form action="<?php 
echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Menu ID<span class="text-warning">*</span>:</td>
      <td><input name="menu_id" type="text" disabled="disabled" value="<?php echo $new_num; ?>" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Menu Name<span class="text-warning">*</span>:</td>
      <td><input type="text" name="menu_name" value="" size="32" placeholder="ป้อนชื่อเมนู" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Price<span class="text-warning">*</span>:</td>
      <td><input type="number" name="menu_price" size="32" placeholder="ป้อนราคาขายต่อหน่วย"/> 
      บาท</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cost<span class="text-warning">*</span>:</td>
      <td><input type="number" name="menu_cost" value="" size="32" placeholder="ป้อนราคาต้นทุนต่อหน่วย"/> 
      บาท</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Type<span class="text-warning">*</span>:</td>
      <td><select name="type_id">
      <option value=''>-- เลือกประเภทเมนู --</option>
    <?php
    do {  
    ?>
    <option value="<?php echo $row_Rec_type['type_id']?>"><?php echo $row_Rec_type['type_id']?> - <?php echo $row_Rec_type['type_name']?></option>
    <?php
    } while ($row_Rec_type = mysql_fetch_assoc($Rec_type));
    $rows = mysql_num_rows($Rec_type);
    if($rows > 0) {
        mysql_data_seek($Rec_type, 0);
        $row_Rec_type = mysql_fetch_assoc($Rec_type);
    }
    ?>
</select>
</td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="  Insert  " />
      <input type="reset" name="Reset" id="button" value="  Cancel  " /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Rec_type);

mysql_free_result($Rec_maxnum);

?>

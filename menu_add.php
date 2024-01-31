<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "andypos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงค่าเลขล่าสุดจากฐานข้อมูล
$sql = "SELECT MAX(menulist.menu_id) AS max_num FROM menulist";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$max_num = $row['max_num'];

// เพิ่มเลขที่ต่อจากรายการล่าสุด
$new_num = $max_num + 1;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AndyPOS</title>
<style type="text/css">
.text-warning {
	color: #F00;
}
.text-font {
	font-family: Kanit;
	font-size: larger;
}

.input-number {
  width: 75px; /* กำหนดความกว้างของช่อง input */
  text-align: center; /* จัดข้อความไว้ที่ขวา */
  font-family: Kanit;
  font-size: larger;
}

/* เพิ่ม CSS เพื่อเติมสีเทาอ่อนให้กับช่อง Menu ID* */
#menu_id {
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  padding: 5px;
}
/* เปลี่ยนสีและตัวหนังสือของปุ่ม Cancel */
#Cancel {
  background-color: #38B6FF; /* สีฟ้า */
  color: #ffffff; /* สีขาว */
  width: 90px;
  height: 50px;
  font-family: Kanit;
  font-size: larger;
  
}

/* เปลี่ยนสีและตัวหนังสือของปุ่ม Save */
#Save {
  background-color: #FF3B3B; /* สีแดง */
  color: #ffffff; /* สีขาว */
  width: 90px;
  height: 50px;
  font-family: Kanit;
  font-size: larger;
}

</style>
<script type="text/javascript">
function validateForm() {
    var menuName = document.forms["form1"]["menu_name"].value;
    var type = document.forms["form1"]["type"].value;
    var cost = document.forms["form1"]["cost"].value;
    var price = document.forms["form1"]["price"].value;
    
    if (menuName == "" || type == "" || cost == "" || price == "") {
        alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
        return false;
    }
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="result.php" onsubmit="return validateForm()">
  <p id="form1">&nbsp;</p>
  <table width="30%" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="26%" align="right"><img src="images/drinks-menu.png" width="90" height="90" /></td>
      <td width="25%"><strong class="text-font">ADD Menu</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="left" class="text-font"><strong>Menu ID*</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="left"><label for="menu_id"></label>
      <input name="menu_id" type="text" class="text-font" id="menu_id" value="<?php echo $new_num; ?>" size="4" readonly /></td>
    </tr>
    <tr>
      <td colspan="2" align="left" class="text-font"><strong>Menu Name*</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="left"><label for="menu_id"></label>
      <input name="menu_name" type="text" class="text-font" id="menu_name" placeholder="ป้อนชื่อเมนู"/>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="left" class="text-font"><strong>Type*</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="left"><label for="type_id"></label>
   
        <select name="type_id" class="text-font" id="type_id">
        <option value=''>-- เลือกประเภทเมนู --</option>
        
        <?php
            // Query เพื่อดึงข้อมูล menutype จากฐานข้อมูล
            $sql = "SELECT * FROM menutype";
            $result = $conn->query($sql);

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                // Loop เพื่อแสดงรายการ menutype ในช่องเลือก
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["type_id"] . "'>" . $row["type_name"] . "</option>";
                }
            } else {
                echo "<option value=''>No data available</option>";
            }
          ?>
      </select></td>
    </tr>
   <tr>
      <td colspan="2" align="left" class="text-font"><strong>Cost*</strong> ฿
  <input name="cost" type="number" class="input-number" id="cost" step="0.01" />        
  &nbsp;&nbsp;&nbsp;&nbsp;<strong>Price*</strong> ฿
<input name="price" type="number" class="input-number" id="price" step="0.01" />
      </td>
    </tr>
     <tr>
      <td colspan="2" align="left" class="text-font"><input type="reset" name="Cancel" id="Cancel" value="Cancel"> <input type="submit" name="Save" id="Save" value="Save"></td>
    </tr>
  </table>
</form>
</body>
</html>

<?php
$conn->close();
?>

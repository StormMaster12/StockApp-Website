<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>

<?php
//phpinfo();



$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

mysqli_query($connection, "DELETE FROM Stock WHERE Pan = 5000309007668 ");
//mysqli_query($connection,"DELETE FROM Stock WHERE Pan = '9781841498959'");
$columns = mysqli_query($connection, "SELECT * FROM Stock ") or die(mysqli_error($connection));
$columnNames = mysqli_query($connection, "SHOW columns FROM Stock");


echo "<table>";
while ($rowName = mysqli_fetch_array($columnNames))
{
	echo "<tr>";
	foreach ($rowName as $_ColumnName)
	{
		echo "<th>{$_ColumnName}</th>";
	}
	echo "</tr>";
}


while ($row = mysqli_fetch_row($columns))
{
  echo "<tr>";
  foreach ($row as $_Column)
  {
   echo "<td>{$_Column}</td>";
  }
  echo "</tr>";
}
echo "</table>";

$sqlCommand = mysqli_query($connection, "ALTER TABLE Stock CHANGE 'Runout Date' expiryDate") or die(mysqli_error($connection));
mysqli_query($connection, "ALTER TABLE Stock CHANGE 'Purchase Date' purchaseDate") or die(mysqli_error($connection));

$sql = mysqli_query($connection, "SELECT * FROM Stock") or die(mysqli_error($connection));
?>

<table>
<tr>
<th>Id</th>
<th>Pan</th>
<th>Amount</th>
<th>Short Description</th>
<th>Long Description</th>
<th>Purchase Date</th>
<th>Expiry Date</th>
</tr>
<?php
while($row=mysqli_fetch_assoc($sql))
{
?>
<tr>
<td><?php echo $row['idStock']; ?></td>
<td><?php echo $row['Pan']; ?></td>
<td><?php echo $row['Amount']; ?></td>
<td><?php echo $row['Short Description']; ?></td>
<td><?php echo $row['Long Description']; ?></td>
<td><?php echo $row['Purchase Date']; ?></td>
<td><?php echo $row['Runout Date']; ?></td>
</tr>
<?php
}
?>
</table>
<?php echo "This is something"; ?>

</body>
</html>

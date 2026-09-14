<?php
session_start();
include("db.php");

$result = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<title>All Users</title>
<style>
table{
width:100%;
border-collapse:collapse;
}
th,td{
border:1px solid #ddd;
padding:10px;
text-align:center;
}
th{
background:#007bff;
color:white;
}
</style>
</head>
<body>

<h2>All Registered Users</h2>

<table>

<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['email']; ?></td>
</tr>

<?php } ?>

</table>

<br>

<a href="admin.php">⬅ Back to Dashboard</a>

</body>
</html>
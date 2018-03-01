<?php
session_start();
include_once 'db_connect.php';

if(isset($_SESSION['sess_role']) != 'admin')
{
  header("Location: login.php");
}
include 'admin_navbarlgdin.php';
 ?>

 <!DOCTYPE html>
   <head>
	<title>Add Tree</title>

  <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

   </head>
   <header>
     <ul>
       <?php echo "Welcome ",  $_SESSION['sess_user'] ?>
       <?php date_default_timezone_set("America/Menominee"); echo date("h:i:sa");?></br>
       (<?php  echo $_SESSION['sess_role'] ?>)
       <a href="adminhome.php">Admin Home</a>
       <a href="logout.php">Log Out</a>

   </ul>
 </header>
 </br></br></br>
   <body>


       <form method="post" action="uploadTree.php" enctype="multipart/form-data">
	   <fieldset>
		<table width="420" border="0" align="center">
		 <legend align="center">ADD TREE</legend>

		 <tr>
			<td>Tree Name:</td><td width="229" >
			<input type="text" name="species" placeholder="Tree Name">
			</td>
		</tr>

		<tr>
			<td>Tree Description:</td><td width="229" >
				<input type="text" name="tree_desc" placeholder="Description">
			</td>
		</tr>

		<tr>
			<td>Tree Age:</td><td width="229" >
				<input type="text" name="age" placeholder="Age">
			</td>
		</tr>

		<tr>
			<td>City:</td><td width="229" >
				<input type="text" name="city" placeholder="City">
			</td>
		</tr>

		<tr>
			<td>State:</td><td width="229" >
				<input type="text" name="state" placeholder="State">
			</td>
		</tr>

		<tr>
			<td>Latitude:</td><td width="229" >
				<input type="text" name="lat" placeholder="Latitude">
			</td>
		</tr>

		<tr>
			<td>Longitude:</td><td width="229" >
				<input type="text" name="lng" placeholder="Longitude">
			</td>
		</tr>

		<tr>
			<td>Upload Image:</td><td width="229" >
				<input type="file" name="file" id="file">
			</td>
		</tr>

		<tr>
            <td colspan="2" align="center"><button type="submit" name="submit">Submit</button></td>
		</tr>

         </form>
		</fieldset>

	</table>

   </body>
 </html>

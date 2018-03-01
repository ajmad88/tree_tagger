<?php
  session_start();
  include_once 'db_connect.php';

  if(isset($_SESSION['sess_role']) != 'admin'){
    header("Location: login.php");
  }
include 'admin_navbarlgdin.php';
 ?>

<!DOCTYPE html>
  <head>
  <title>ADMIN HOME</title>
  <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

  </head>

  <header>

  </header>
</br></br></br>
  <body>
    <h2 align="center">ADMIN HOME</h2>
	</br>

	<div class="container-fluid">
		<table class="table table-hover table-bordered table-responsive" align="center">
			<thead>
				<tr>
					<th>ID</th>
					<th>species</th>
					<th class="col-sm-4">Tree Description</th>
					<th>Age</th>
					<th>City</th>
					<th>State</th>
					<th>Latitude</th>
					<th>Longitude</th>
					<th>Image</th>
					<th>Edit</th>
					<th>Remove</th>
				</tr>
			</thead>

			<tbody>

			<?php
				include ('db_connect.php');

				$sql = ("SELECT tree_id, species, tree_desc, age, city, state, lat, lng, image_path FROM tree_info");
				$q = $db->query($sql);
				$q->setFetchMode(PDO::FETCH_ASSOC);

			?>

			<?php while ($row = $q->fetch()): ?>
				<tr>
					<td><?php echo $row['tree_id']; ?></td>
					<td><?php echo $row['species']; ?></td>
					<td><?php echo $row['tree_desc']; ?></td>
					<td><?php echo $row['age']; ?></td>
					<td><?php echo $row['city']; ?></td>
					<td><?php echo $row['state']; ?></td>
					<td><?php echo $row['lat']; ?></td>
					<td><?php echo $row['lng']; ?></td>
					<td align="center"><?php echo '<img src="Photos/'.$row['image_path'].'"style="width="65px height=65" alt="Image"'; ?></td>

					<td align="center">
						<a href="edit_tree.php?id=<?php echo $row['tree_id']; ?>" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-edit"></span> Edit
						</a>
					</td>

					<td align="center">
						<a href="delete_dataTree.php?id=<?php echo $row['tree_id']; ?>" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-trash"></span> Remove
						</a>
					</td>
				</tr>

				<?php endwhile; ?>
			</tbody>
		</table>


  </body>
</html>

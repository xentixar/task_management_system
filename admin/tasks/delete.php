<?php
require '../../connection/database.php';
require '../../middleware/authenticated.php';

if(isset($_GET['id']))
{
	$id = $_GET['id'];
	if($id && is_numeric($id))
	{
		$user_id = $_SESSION['user']['id'];
		$select_query = "SELECT * FROM tasks WHERE id=$id AND user_id=$user_id";
		$select_result = $conn->query($select_query);
		$task = mysqli_fetch_assoc($select_result);

		if(!$task)
		{
			?>
				<script type="text/javascript">
			    	window.location.href="index.php";
			  	</script>
			<?php
		}
		unlink('../../uploads/'. $task['image']);
		$delete_query = "DELETE FROM tasks WHERE id=$id AND user_id=$user_id";
		$delete_result = $conn->query($delete_query);
		?>
			<script type="text/javascript">
		    	window.location.href="index.php";
		  	</script>
		<?php
		
	}else{
		?>
			<script type="text/javascript">
		    	window.location.href="index.php";
		  	</script>
		<?php
	}
}else{
	?>
	<script type="text/javascript">
    	window.location.href="index.php";
  	</script>
	<?php
}
?>


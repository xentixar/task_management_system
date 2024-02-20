<?php
require '../../connection/database.php';
require '../../middleware/authenticated.php';

if(isset($_GET['id']))
{
	$id = $_GET['id'];
	if($id && is_numeric($id))
	{
		$user_id = $_SESSION['user']['id'];
		$update_query = "UPDATE tasks SET status=1 WHERE id=$id AND user_id=$user_id";
		$update_result = $conn->query($update_query);
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


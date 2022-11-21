<?php

/*include("db.php");

$trek_id = $_GET['trek_id'];
$stmt = $conn->prepare("SELECT tf.*,(select category_title from sg_faq_categories where faq_cat_id=tf.cat_id) as cat_name FROM sg_trek_faq tf where tf.status='0' and tf.trek_id=".$trek_id);
  $stmt->execute();

  // set the resulting array to associative


// set the resulting array to associative
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
*/
?>
<html>
<head>
	<title>Faq's</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' /><script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/js/froala_editor.pkgd.min.js'></script>
	</head>
	<style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
	body {
		background-color: #fff;
		margin: 0;
		padding: 0;
		font-family: 'Poppins', sans-serif;
		font-size: 13px !important;
	}
	.btn_update {
		background-color: green;
		color: #fff;
		margin-top: 15px;
		padding: 15px 25px;
		border: none;
		font-size: 15px;
		cursor: pointer;
		text-transform: uppercase;
	}
	.btn_update:hover {
		background-color: black;
	}
	.form_bg {
		width: 100%;
		margin: 10px auto;
		padding: 50px;
		background-color: #f0f0f0;
		margin-top: 50px;
		border-radius: 25px;
	}
</style>
	<body>
				<div class="form_bg">

		<table border="1" cellpadding="0" cellspacing="0">
					<a  class="btn_update" href="addFaq.php?trek_id=<?php echo $trek_id;?>">Add New</a>

			<thead>
				<tr>
					<th>S.No</th>
					<th>Question</th>
					<th>Category</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($result['faq'] AS $k=>$value) { ?>
				<tr>
					<td><?php echo $k; ?></td>
					<td><?php echo $value->question; ?></td>
					<td><?php echo $value->cat_name;?></td>
					<td><a href="editFaq.php?faq_id=<?php echo $value->faq_id; ?>">Edit</a></td>
					<td><a href="deleteFaq.php?faq_id=<?php echo $value->faq_id;?>" onclick="return confirm('Are you sure?')">Delete</a></td>

				</tr>
				<?php } ?>
			</tbody>
			
			
		</table>
	</div>
	</body>
	<script> 
		$(document).ready(function() {
			$('#trek_id').on('change', function(){
				alert('hi');
			});
		});
		
			var trek_overview = new FroalaEditor('#trek_overview');
			var things_carry = new FroalaEditor('#things_carry');
			var terms = new FroalaEditor('#terms');
			var map_image = new FroalaEditor('#map_image');
		</script>
</html>
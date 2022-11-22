<html>
<head>
	<title>Admin</title>
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
</style>
	<body>
		<form action="" method="post" name="adminform" id="adminform">
		<table border="1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Trek Title</th>
					<th>Detail Itinerary</th>
					<th>Faq's</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($result['alltreks'] AS $k=>$value) { ?>
				<tr>
					<td><?php echo $k; ?></td>
					<td><?php echo $value->trek_title; ?></td>
					<td><a href="<?php echo base_url(); ?>/gettrekitinerary/<?php echo $value->trek_id; ?>">Itinerary</a></td>
					<td><a href="<?php echo base_url(); ?>/getfaq/<?php echo $value->trek_id; ?>">Trek Faq's</a></td>
					<td><a href="<?php echo base_url(); ?>/gettrek/<?php echo $value->trek_id; ?>">Edit</a></td>


				</tr>
				<?php } ?>
			</tbody>
			
			
		</table>
		</form>
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
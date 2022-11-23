<html>
<head>
	<title>Admin</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' /><script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/js/froala_editor.pkgd.min.js'></script>

	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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

		<div class="container">
			<div class="row">
			<div class="col-md-12 text-right"><a class="btn btn-success btn-sm" href="<?php echo base_url();?>/addBikeTrip">Add</a></div>
		</div>
		</div>
		<form action="" method="post" name="adminform" id="adminform">

		<table border="2" class="table-strip" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>S.No</th>
					<th> Title :</th>
					<th> Itinerary :</th>
					
					
					<th>Edit : </th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($result['allBikeTrips'] AS $k=>$value) { ?>
				<tr>
					<td><?php echo $k; ?></td>
					<td><?php echo $value->tripTitle; ?></td>
					
					<td><a href="<?php echo base_url(); ?>/getBikeTripItinerary/<?php echo $value->tripId; ?>">Itinerary</a></td>

					<!-- <td><a href="<?php echo base_url(); ?>/getfaq/<?php echo $value->tripId; ?>">trip Faq's</a></td> -->
					<td><a href="<?php echo base_url(); ?>/getBiketrip/<?php echo $value->tripId; ?>">Edit</a></td>


				</tr>
				<?php } ?>
			</tbody>
			
			
		</table>
		</form>
	</body>
	<script> 
		$(document).ready(function() {
			$('#tripId').on('change', function(){
				alert('hi');
			});
		});
		
			var trip_overview = new FroalaEditor('#trip_overview');
			var things_carry = new FroalaEditor('#things_carry');
			var terms = new FroalaEditor('#terms');
			var map_image = new FroalaEditor('#map_image');
		</script>
</html>
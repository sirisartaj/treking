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
			<div class="col-md-12 text-right"><a class="btn btn-success btn-sm" href="<?php echo base_url();?>/addTrek">Add</a></div>
		</div>
		</div>
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
					<td><a href="<?php echo base_url(); ?>/gettrek/<?php echo $value->trek_id; ?>">Edit</a>
						<a href="javascript:void(0)" onclick="deletea('<?php echo $value->trek_id; ?>');">Delete</a>
					</td>


				</tr>
				<?php } ?>
			</tbody>
			
			
		</table>
		</form>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script> 
		$(document).ready(function() {
			$('#trek_id').on('change', function(){
				alert('hi');
			});
		});
		
			function deletea(a){
		console.log(a);
				Swal.fire({
				  title: 'Are you sure?',
				  text: "You won't be able to revert this!",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
				  if (result.isConfirmed) {
				  	$.ajax({
				      
				      type: "GET",
				      url: '<?php echo base_url()."/deleteTrek/";?>'+a,
				      cache: false,
				      contentType: false,
				      processData: false,
				      success: function(result1) {
				      	console.log(result1);
				      	location.reload();
				      	 
				      }
				    });
				    
				  }
				})
			}
		</script>
	</body>
	
</html>
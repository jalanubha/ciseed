<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>CISeed Project</title>
		
		<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.js"></script>
		<script type="text/javascript" src="resources/scripts/handlebars-v2.0.0.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="resources/css/index.css">
	</head>
	<body>
		<div class="container">
		
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="javascript:void(0)">CISeed Project</a>
					</div>
					<div></div>
				</div>
			</nav>

			<h4 class='tblTitle'>Student List</h4>
			<hr/>

			<section class='scrollCont'>
				<table class='table table-striped tblCard'>
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Password</th>
						</tr>
					</thead>
					<tbody id='tblUser'>
					</tbody>
				</table>
			</section>			
			
			<button class='btn btn-primary btnFluid' id='btnUpdate' data-loading-text="Randomizing..." class="btn btn-primary" autocomplete="off">			
				Update !!
			</button>

			<script id="tmpUserTable" type="text/x-handlebars-template">
				{{#each this}}
				<tr>
					<td>{{id}}</td>
					<td>{{user_name}}</td>
					<td>{{password}}</td>
				</tr>
				{{/each}}
			</script>
		</div>
	
	<script>
		(function() {
			var source   = $("#tmpUserTable").html()
				,template = Handlebars.compile(source)
				,$tblUser = $('#tblUser')
				,$btnUpdate = $('#btnUpdate')
				,ids = [];

			function populateUserTable(afterUpdate) {
				$.ajax({
					method: 'GET',
					url: 'api/user',
					success: function(data) {
						$tblUser.fadeOut('fast', function(){
							$tblUser.empty();
							$tblUser.append(template(data));
							ids = data.map(function(user) {
								return user.id;
							});
							$tblUser.fadeIn();
							afterUpdate && afterUpdate();
						});
					},
					error:function(data) {
						console.log(data);
					}
				});
			}

			$btnUpdate.on('click', function() {
				var $btn = $(this).button('loading');
				$.ajax({
					method: 'POST',
					url: 'api/user/update',
					data: {ids:ids},
					success: function(data) {
						console.log(data);
						populateUserTable(function(){
							$btn.button('reset');
						});
					},
					error:function(data) {
						console.log(data);
						$btn.button('reset')
					}
				});
			});

			populateUserTable();
		})();
	</script>
	</body>
</html>
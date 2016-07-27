<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE)
?>
<!Doctype HTML>
<html>
<head>
	<title>CJ Image Uploader Admin</title>
	<meta charset="utf-8">
	<meta name="title" content="" >
	<meta name="description" content="">
    
	<meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:type" content="website">

    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!--Jquery conditional loader-->
	<!--[if lt IE 9]>
	    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<![endif]-->
	<!--[if gte IE 9]><!-->
	    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
	<!--<![endif]-->
	
	<!--
	JQuery UI
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
	-->

	<!--
	Fontawesome
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	-->


	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


	<!--
	Mapbox
	<script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.3/mapbox.js'></script>
	<link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.3/mapbox.css' rel='stylesheet' />
	-->
	

	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js'></script>

	
	<style>
		* {
			-webkit-box-sizing: border-box; 
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}

		main{
			width:80%;
			margin:0 auto;
		}

		a[ng-click]{
		    cursor: pointer;
		}

		a.danger{
			color:red;
		}

		td:last-child{
			vertical-align:middle !important;
		}

	</style>

</head>
<body ng-app="imageUploaderAdmin">
	<!--**********Content starts**********-->

	<main ng-controller="main">
	<table class="table table-striped table-hover">
		<tr><th>ID</th><th>First</th><th>Last</th><th>Email</th><th>Caption</th><th>Timestamp</th><th>Preview</th><th>Action</th></tr>
		<tr ng-repeat="row in listData">
			<td>{{row.id}}</td>
			<td>{{row.first_name}}</td>
			<td>{{row.last_name}}</td>
			<td>{{row.email}}</td>
			<td>{{row.caption}}</td>
			<td>{{row.time_stamp}}</td>
			<td>
				<a target="_blank" href="../images/{{row.file_name}}"><img ng-src="../images/th_{{row.file_name}}"></a>
			</td>
			<td>
				<a class="btn btn-danger btn-sm" ng-click="deleteEntry(row)"><span class="glyphicon glyphicon-remove pull-left" aria-hidden="true" title="Delete"></span></a><br><br>
				<a class="btn btn-primary btn-sm" href="../images/{{row.file_name}}" download><span class="glyphicon glyphicon-download-alt pull-right" aria-hidden="true" title="Download"></span></a>
			</td>
		</tr>
	</table>
	</main>


	<!--**********Content ends**********-->

	<script>

		var imageUploaderAdmin = angular.module('imageUploaderAdmin', []);

		imageUploaderAdmin.controller('main', function($scope, $http){
			$scope.getList = function(){
				$http.get('app.php?action=list').then(function(data){
					if (data.data.ok){
						$scope.listData = data.data.data;
					}
				})
			}


			$scope.deleteEntry = function(row){
				console.log('delete row: ' + row.id);
				$http.get('app.php?action=delete&value=' + row.id +'&file=' + row.file_name).then(function(response){
					if (response.data.ok){
						$scope.getList();
					}
					else{
						alert("There was an error deleting this file :(");
					}
				})
			}

			$scope.getList();
		})


	</script>
</body>
</html>
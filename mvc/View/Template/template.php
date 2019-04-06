<!DOCTYPE html>
<html lang="ru">
	<head>
	  	<meta charset="UTF-8"> 
		<!-- bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		<!-- jq -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
	    <link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/start/jquery-ui.css">

	    <style type="text/css">
	    	.main {
	    		background-color: #50c878;
	    	}
		    .header {
		    	background-color: #50c878; 
		    	padding: 20px
		    }
	    	.menu {
	    		background-color: #dcdcdc; 
	    		margin: 0px; 
	    		padding: 20px
	    	}
	    	.content {
	    		background-color: #e6e6e6; 
	    		padding: 20px
	    	}
	    	.footer {
	    		background-color: #50c878; 
	    		margin: 10px; padding: 10px
	    	}
	    	.myTable {
	    		background-color: #dbd7d2
	    	}
	    	.myButton {
	    		background-color: #50c878;
	    		color: white
	    	}

		</style>
	</head>
	<body>
		<div class="container main">	
			<div class="row header">
				<?php require_once __DIR__ . "/TemplateElements/header.php"; ?> 
			</div>	

			<div class="row" >
				<div class="col-md-12 col-xs-12 col-sm-4 menu">
					<?php require_once __DIR__ . "/TemplateElements/menu.php"; ?>	
				</div>

				<div class="col-md-12 col-xs-12 col-sm-8 content">
					<div>
						<?php require_once __DIR__ .  $pathToPage . $contentOfPage.'.php'; ?>  
					</div>
				</div>
		  	</div>
	  	

			<div class="row footer">
				<?php require_once __DIR__ . "/TemplateElements/footer.php"; ?> 
			</div>
		<div>
	</body>
</html>
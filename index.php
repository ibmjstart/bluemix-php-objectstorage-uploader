<!DOCTYPE html>
<html>
<head>
  <title>PHP-Uploader</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="/stylesheets/style.css" />
  
  <link href="/stylesheets/bootstrap.css" rel="stylesheet">
  <script src="/javascripts/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
	    <div class="hero-unit">
	      <div class="pull-right">    
	        <a href="/delete.php" class="btn btn-danger" title="Clear All">Delete All</a>
	      </div>
	      <div class="text-center">
	        <h1><a href="/">PHP Upload</a></h1>
	        <p>
				<form action="/upload.php" method="POST" enctype="multipart/form-data">
	            	<input type="file" name="file" /><br>
	            	<input type="submit" class="btn" value="Upload">
	          	</form>
	        </p>
	      </div>
	    </div>
	    <div class="hero-unit">
	      	<?php
		      	require 'vendor/autoload.php';
		      	
				//code modified from https://github.com/ibmjstart/wp-bluemix-objectstorage/blob/master/classes/swift.php
				$vcap = getenv("VCAP_SERVICES");
				$data = json_decode($vcap, true);
				$creds = $data['Object-Storage']['0']['credentials'];
				$auth_url = $creds['auth_url'] . '/v3'; //keystone v3
				$region = $creds['region'];
				$userId = $creds['userId'];
				$password = $creds['password'];
				$projectId = $creds['projectId'];
				$openstack = new OpenStack\OpenStack([
							    'authUrl' => $auth_url,
							    'region'  => $region,
							    'user'    => [
							        'id'       => $userId,
							        'password' => $password
							    ],
							    'scope'   => [
							    	'project' => [
							    		'id' => $projectId
							    	]
							    ]
							]);
				
				$container = $openstack->objectStoreV1()
				                       ->getContainer('php-uploader');
				                       
				echo "<h2>Files in php-uploader</h2>";
				
				echo "<ul class=\"unstyled\">";
				foreach ($container->listObjects() as $object) {
					echo "<li>";
				    echo $object->name;
					echo "</li>";
				}
				echo "</ul>";
	      ?>
      </div>
    </div>
</body>
</html>

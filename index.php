<!--
/*-------------------------------------------------------------------*/
/*                                                                   */
/* Copyright IBM Corp. 2016 All Rights Reserved                      */
/*                                                                   */
/*-------------------------------------------------------------------*/
/*                                                                   */
/*        NOTICE TO USERS OF THE SOURCE CODE EXAMPLES                */
/*                                                                   */
/* The source code examples provided by IBM are only intended to     */
/* assist in the development of a working software program.          */
/*                                                                   */
/* International Business Machines Corporation provides the source   */
/* code examples, both individually and as one or more groups,       */
/* "as is" without warranty of any kind, either expressed or         */
/* implied, including, but not limited to the warranty of            */
/* non-infringement and the implied warranties of merchantability    */
/* and fitness for a particular purpose. The entire risk             */
/* as to the quality and performance of the source code              */
/* examples, both individually and as one or more groups, is with    */
/* you. Should any part of the source code examples prove defective, */
/* you (and not IBM or an authorized dealer) assume the entire cost  */
/* of all necessary servicing, repair or correction.                 */
/*                                                                   */
/* IBM does not warrant that the contents of the source code         */
/* examples, whether individually or as one or more groups, will     */
/* meet your requirements or that the source code examples are       */
/* error-free.                                                       */
/*                                                                   */
/* IBM may make improvements and/or changes in the source code       */
/* examples at any time.                                             */
/*                                                                   */
/* Changes may be made periodically to the information in the        */
/* source code examples; these changes may be reported, for the      */
/* sample code included herein, in new editions of the examples.     */
/*                                                                   */
/* References in the source code examples to IBM products, programs, */
/* or services do not imply that IBM intends to make these           */
/* available in all countries in which IBM operates. Any reference   */
/* to the IBM licensed program in the source code examples is not    */
/* intended to state or imply that IBM's licensed program must be    */
/* used. Any functionally equivalent program may be used.            */
/*-------------------------------------------------------------------*/
-->
<!-- Most of the html is directly from https://github.com/ibmjstart/bluemix-node-mysql-uploader -->
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
				                       
				echo "<h2>Files in Object Storage</h2>";
				
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

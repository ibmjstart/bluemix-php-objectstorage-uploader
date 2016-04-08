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
                       
echo "<h1>Files in php-uploader</h1>";

echo "<ul>";
foreach ($container->listObjects() as $object) {
	echo "<li>";
    echo $object->name;
	echo "</li>";
}
echo "</ul>";
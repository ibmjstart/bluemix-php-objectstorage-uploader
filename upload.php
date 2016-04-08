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

//creates the container if it does not already exist
$openstack->objectStoreV1()->createContainer(['name' => 'php-uploader']);

$container = $openstack->objectStoreV1()
                       ->getContainer('php-uploader');

//found on http://stackoverflow.com/questions/16888722/get-content-of-file-uploaded-by-user-before-saving
$fileContent = file_get_contents($_FILES["file"]["tmp_name"]);

$options = [
    'name'    => $_FILES['file']['name'],
    'content' => $fileContent
];

echo "uploading " . $options['name'];

$container->createObject($options);

//found on http://stackoverflow.com/questions/14810399/php-form-redirect
header( 'Location: /' ) ;
?>
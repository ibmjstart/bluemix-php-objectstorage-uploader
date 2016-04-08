<?php
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
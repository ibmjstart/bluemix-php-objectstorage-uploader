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
	<div>
		<!-- used code directly from http://php.net/manual/en/features.file-upload.post-method.php -->
		<!-- The data encoding type, enctype, MUST be specified as below -->
		<form enctype="multipart/form-data" action="upload.php" method="POST">
		    <!-- MAX_FILE_SIZE must precede the file input field -->
		    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		    <!-- Name of input element determines name in $_FILES array -->
		    Send this file: <input name="userfile" type="file" />
		    <input type="submit" value="Send File" />
		</form>
	</div>
</body>
</html>

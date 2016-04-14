# bluemix-php-objectstorage-uploader

A simple PHP application for demonstrating how to upload and delete files from Object Storage.

## Deployment

We highly recommend using the Deploy to Bluemix button for any users unfamiliar with deploying applications on [Bluemix](https://bluemix.net).

### Option 1:

[![Deploy to Bluemix](https://bluemix.net/deploy/button.png)](https://bluemix.net/deploy?repository=https://github.com/ibmjstart/bluemix-php-objectstorage-uploader)

### Option 2:

You can manually push the app using the [Cloudfoundy CLI](https://github.com/cloudfoundry/cli/releases) like so: 

1. Clone the repo  
	```
	git clone https://github.com/ibmjstart/bluemix-php-objectstorage-uploader

	cd bluemix-php-objectstorage-uploader
	```
2. Modify "host" in [manifest.yml](manifest.yml)
	```
	host: NEW_UNIQUE_HOST
	```

3. Create the Object Storage service
	```
	cf create-service Object-Storage Free Uploader_Object-Storage
	```

4. Push app
	```
	cf push
	``` 

> If you need help setting up the Cloudfoundry CLI please refer to the [Bluemix docs](https://console.ng.bluemix.net/docs/starters/install_cli.html)  

This sample is provided under the [MIT license](License.txt)

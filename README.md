# NGINX Microservices Reference Architecture: Pages Service

This repository contains a simple PHP application which is used to provide the user interface for the NGINX _Ingenious_ application. The 
_Ingenious_ application has been developed by the NGINX Professional Services team to provide a reference 
architecture for building your own microservices based application using NGINX as the service mesh for the services. 

The pages application is configured to retrieve data from other components in the NGINX Microservice Reference Architecture: 
- [Album Manager Service](https://github.com/nginxinc/ngra-album-manager "Album Manager")
- [Content Service](https://github.com/nginxinc/ngra-content-service "Content Service")
- [Photo Uploader Service](https://github.com/nginxinc/ngra-photouploader "Photo Uploader")
- [User Manager Service](https://github.com/nginxinc/user-manager "User Manager Service")

The default configuration for all the components of the MRA, including the Pages service, is to use the 
[Fabric Model Architecture](https://www.nginx.com/blog/microservices-reference-architecture-nginx-fabric-model/ "Fabric Model").
Instructions for using the [Router Mesh](https://www.nginx.com/blog/microservices-reference-architecture-nginx-router-mesh-model/) or 
[Proxy Model](https://www.nginx.com/blog/microservices-reference-architecture-nginx-proxy-model/) architectures will be made available in the future.

## Quick start
As a single service in the set of services which comprise the NGINX Microservices Reference Architecture application, _Ingenious_,
the Pages service is not meant to function as a standalone service. Once you have built the image, it can be deployed 
to a container engine along with the other components of the _Ingenious_ application, and then the application will be 
accessible via your browser. 

There are detailed instructions about the service below, and in order to get started quickly, you can follow these simple 
instructions to quickly build the image.  

0. (Optional) If you don't already have an NGINX Plus license, you can request a temporary developer license 
[here](https://www.nginx.com/developer-license/ "Developer License Form"). If you do have a license, then skip to the next step. 
1. Copy your licenses to the **<repository-path>/ngra-pages/nginx/ssl** directory
2. Run the command ```docker build . -t <your-image-repo-name>/pages:quickstart``` where <image-repository-name> is the username
for where you store your Docker images
3. Once the image has been built, push it to the docker repository with the command ```docker push -t <your-image-repo-name>/pages:quickstart```

At this point, you will have an image that is suitable for deployment on to a DC/OS installation, and you can deploy the
image by creating a JSON file and uploading it to your DC/OS installation.

To build customized images for different container engines and set other options, please follow the directions below.

## Building a Customized Docker Image
The Dockerfile for the Pages service is based on the php:7.0.5-fpm image, and installs NGINX open source or NGINX Plus. Note that the features
in NGINX Plus make discovery of other services possible, include additional load balancing algorithms, persistent SSL/TLS connections, and
advanced health check functionality.

The command, or entrypoint, for the Dockerfile is the [php-start.sh script](php-start.sh "Dockerfile entrypoint"). 
This script sets some local variables, then starts [PHP FPM](https://php-fpm.org/ "PHP FPM") and NGINX in order to handle page requests.
Configuration for PHP FPM is found in the [php5-fpm.conf file](php5-fpm.conf "PHP FPM Conf")

### 1. Build options
The Dockerfile sets some ENV arguments which are used when the image is built:

- **USE_NGINX_PLUS**  
    The default value is true. When this value is set to false, NGINX open source will be built in to the image and several 
    features, including service discovery and advanced load balancing will be disabled.
    See [installing nginx plus](#installing-nginx-plus)
    
    When the nginx.conf file is built, the [fabric_config_local.yaml](nginx/fabric_config_local.yaml) will be
    used to populate the open source version of the [nginx.conf template](nginx/nginx-fabric.conf.j2)
    
- **USE_VAULT**  
    The default value is false. Setting this value to true will cause install-nginx.sh to look 
    for a file named vault_env.sh which contains the _VAULT_ADDR_ and _VAULT_TOKEN_ environment variables to
    retrieve NGINX Plus keys from a [vault](https://www.vaultproject.io/) server.
    
    ```
    #!/bin/bash
    export VAULT_ADDR=<your-vault-address>
    export VAULT_TOKEN=<your-vault-token>
    ```
    
    You must be certain to include the vault_env.sh file when _USE_VAULT_ is true. There is an entry in the .gitignore
    file for vault_env.sh
    
    In the future, we will release an article on our [blog](https://www.nginx.com/blog/) describing how to use vault with NGINX.    
    
- **CONTAINER_ENGINE**  
    The container engine used to run the images in a container. _CONTAINER_ENGINE_ can be one of the following values
     - docker: to run on Docker Cloud 
     
        When the nginx.conf file is built, the [fabric_config_docker.yaml](nginx/fabric_config_docker.yaml) will be
        used to populate the open source version of the [nginx.conf template](nginx/nginx-plus-fabric.conf.j2)
        
     - kubernetes: to run on Kubernetes
     
        When the nginx.conf file is built, the [fabric_config_k8s.yaml](nginx/fabric_config_k8s.yaml) will be
        used to populate the open source version of the [nginx.conf template](nginx/nginx-plus-fabric.conf.j2)
             
     - mesos (default): to run on DC/OS
     
        When the nginx.conf file is built, the [fabric_config.yaml](nginx/fabric_config.yaml) will be
        used to populate the open source version of the [nginx.conf template](nginx/nginx-plus-fabric.conf.j2)
                  
     - local: to run in containers on the machine where the repository has been cloned
     
        When the nginx.conf file is built, the [fabric_config_local.yaml](nginx/fabric_config_local.yaml) will be
        used to populate the open source version of the [nginx.conf template](nginx/nginx-plus-fabric.conf.j2)                  
     
### 2. Decide whether to use NGINX Open Source or NGINX Plus
 
#### <a href="#" id="installing-nginx-oss"></a>Installing NGINX Open Source

Set the _USE_NGINX_PLUS_ property to false in the Dockerfile
    
#### <a href="#" id="installing-nginx-plus"></a>Installing NGINX Plus
Before installing NGINX Plus, you'll need to obtain your license keys. If you do not already have a valid NGINX Plus subscription, you can request 
developer licenses [here](https://www.nginx.com/developer-license/ "Developer License Form") 

Set the _USE_NGINX_PLUS_ property to true in the Dockerfile

##### Vault
By default _USE_VAULT_ is set to false, and you must manually copy your **nginx-repo.crt** and **nginx-repo.key** 
files to the _<path-to-repository>/ngra-photoresizer/nginx/ssl/_ directory.

Download the **nginx-repo.crt** and **nginx-repo.key** files for your NGINX Plus Developer License or subscription, and move them to the root directory of this project. You can then copy both of these files to the `/etc/nginx/ssl` directory of each microservice using the commands below:
```
cp nginx-repo.crt nginx-repo.key <path-to-repository>/photoresizer/nginx/ssl/
```

If _USE_VAULT_ is set to true, you must have installed a vault server and written the contents of the **nginx-repo.crt**
and **nginx-repo.key** file to vault server. Refer to the vault documentation for instructions configuring a vault server
and adding values to it. 

### 3. Decide which container engine to use

#### Set the _CONTAINER_ENGINE_ variable
As described above, the _CONTAINER_ENGINE_ environment variable must be set to one of the following four options.
The install-nginx.sh file uses this value to determine which template file to use when populating the nginx.conf file.

- docker 
- kubernetes 
- mesos 
- local

### 4. Build the image

Replace _&lt;your-image-repo-name&gt;_ and execute the command below to build the image. The _&lt;tag&gt;_ argument is optional and defaults to **latest**

```
docker build . -t <your-image-repo-name>/photoresizer:<tag>
```

### Runtime environment variables
In order to run the image, some environment variables must be set so that they are available during runtime.

| Variable Name | Description | Example Value |
| ------------- | ----------- | ----------- |
| AWS_ACCESS_KEY_ID | Your AWS Access Key ID | ABCD12345ABCD12345ABCD12345 |
| AWS_REGION | The AWS Region | us-west-1 |
| AWS_SECRET_ACCESS_KEY | Your AWS Secret Access Key | ABCD12345ABCD12345ABCD12345 |
| PHOTOMANAGER_ALBUM_PATH | The URI of the album manager albums| /album-manager/albums |
| PHOTOMANAGER_CATALOG_PATH | The URI of the album manager catalogs | /album-manager/albums |
| PHOTOMANAGER_ENDPOINT_URL | The URL of the album manager service| http://localhost |
| PHOTOMANAGER_IMAGES_PATH | The URI for the photouploader images | /album-manager/images |
| PHOTOUPLOADER_ALBUM_PATH | The URI for the photouploader albums | /uploader/album |
| PHOTOUPLOADER_ENDPOINT_URL | The port and host of the photo uploader service| http://localhost |
| PHOTOUPLOADER_IMAGE_PATH | The URI to the image uploader service | /uploader/image |
| REDIS_CACHE_PORT | The redis cache port | "6379" |
| REDIS_CACHE_URL | The hostname of the redis cache service | redis.service |
| S3_BUCKET | The name of the S3 bucket where images are stored | <your bucket name> |
| USERMANAGER_ENDPOINT_URL | The URL of the user manager service | http://localhost |
| USERMANAGER_LOCAL_PATH | The local URI for the user manager service| /user-managear/v1/users |
| USERMANAGER_USER_PATH | The URI to the user manager service | /user-manager/v1/users |


### 6. Service Endpoints
| Method | Endpoint | Description | Parameters |
| ------------- | ------------- | ----------- | ----------- |
| GET | /      | Render the home page | None |
| GET | /about | Render the about page| None |
| GET | /account      | Render the account page. Must be authenticated | None |
| GET | /login      | Renders the login page | None |
| POST| /login      | Sends username and password for authentication | username, password |
| GET | /myphotos   | Render the albums and photos for the user. Must be authenticated | None |
| GET | /photos/{catalogID}/{albumName}/{albumID}| Renders photos for a specific album. Must be authenticated | catalogID, albumName, albumID |
| GET | /stories/{articleID}      | Renders the posts for the user. Must be authenticated | articleID |

#### \*Disclaimer\*

In this service, the `nginx/ssl/dhparam.pem` file is provided for ease of setup. In production environments, it is highly recommended for secure key-exchange to replace this file with your own generated DH parameter.

The `ingenious-pages/app/config/parameters.yml` file is pre-generated for running the service locally. If using other methods of container orchestration, it will be necessary to generate your own parameters.yml file for use in that environment.

#NGINX Microservices Reference Architecture: Pages Service

This repository contains a simple PHP application which is used to provide the user interface for the NGINX _Ingenious_ application. The 
_Ingenious_ application has been developed by the NGINX Professional Services team to provide a reference 
architecture for building your own microservices based application using NGINX as the service mesh for the services. 

The pages application is configured to retrieve data from other components in the NGINX Microservice Reference Architecure: 
- [Album Manager Service](https://github.com/nginxinc/ngra-album-manager "Album Manager")
- [Content Service](https://github.com/nginxinc/ngra-content-service "Content Service")
- [Photo Uploader Service](https://github.com/nginxinc/ngra-photouploader "Photo Uploader")
- [User Manager Service](https://github.com/nginxinc/user-manager "User Manager Service")

The default configuration for all the components of the MRA, including the Pages service, is to use the 
[Fabric Model Architecture](https://www.nginx.com/blog/microservices-reference-architecture-nginx-fabric-model/ "Fabric Model").
Instructions for using the [Router Mesh](https://www.nginx.com/blog/microservices-reference-architecture-nginx-router-mesh-model/) or 
[Proxy Model](https://www.nginx.com/blog/microservices-reference-architecture-nginx-proxy-model/) architectures will be made available in the future.

## Docker Image

The Dockerfile for the Pages service is based on the php:7.0.5-fpm image, and installs NGINX open source or NGINX Plus. Note that the features
in NGINX Plus make discovery of other services possible, include additional Load Balancing algorithms, persistent SSL/TLS connections, and
advanced health check functionality.

The command, or entrypoint, for the Dockerfile is the [php-start.sh script](https://github.com/nginxinc/ngra-pages/blob/master/php-start.sh "Dockerfile entrypoint"). 
This script sets some local variables, then starts [PHP FPM](https://php-fpm.org/ "PHP FPM") and NGINX in order to handle page requests.
Configuration for PHP FPM is found in the [php5-fpm.conf file](https://github.com/nginxinc/ngra-pages/blob/master/php5-fpm.conf "PHP FPM Conf")

###Build options
The Dockerfile sets some ENV arguments which are used when the image is built:

- **USE_NGINX_PLUS**  
    The default value is false. Set this environment variable to true when you want to use NGINX Plus. When this value is false, 
    NGINX open source will be used, and it lacks support for features like service discovery, advanced load balancing,
    and health checks. See [installing nginx plus](#installing-nginx-plus)
    
- **USE_VAULT**  
    The default value is interpreted as false. The installation script uses [vault](https://www.vaultproject.io/) to retrieve the keys necessary to install NGINX Plus.
    Setting this value to true will cause install-nginx.sh to look for a file named vault_env.sh which contains the _VAULT_ADDR_ and _VAULT_TOKEN_
    environment variables.        
    
    ```
    #!/bin/bash
    export VAULT_ADDR=<your-vault-address>
    export VAULT_TOKEN=<your-vault-token>
    ```
    
    You must be certain to include the vault_env.sh file when _USE_VAULT_ is true. There is an entry in the .gitignore
    file for vault_env.sh
    
- **CONTAINER_ENGINE**  
    The container engine used to run the images. It can be one of the following values
     - docker: to run on Docker Cloud 
     - kubernetes: to run on Kubernetes
     - mesos: to run on DC/OS
     - local: to run in containers on the machine where the repository has been cloned
     
- **SYMFONY_ENV**  
    The configuration for the Symfony framework. Valid values are _prod_ and _dev_ and this value is used by [app.php](https://github.com/nginxinc/ngra-pages/blob/MRADEV-547_optional_elk_logging/ingenious-pages/web/app.php "app.php")
    
## <a href="#" id="installing-nginx-plus"></a>Installing NGINX Plus
Before installing NGINX Plus, you'll need to obtain your license keys. If you do not already have a valid NGINX Plus subscription, you can request 
developer licenses [here](https://www.nginx.com/developer-license/ "Developer License Form") 

To deploy the MRA with NGINX Plus, first perform the steps in [Deploying with Open Source NGINX](https://github.com/nginxinc/fabric-model-architecture/#deploying-with-nginx-plus) then, perform the following steps:

If you have not set _USE_VAULT_ to true, then you'll need to manually copy your **nginx-repo.crt** and **nginx-repo.key** files to the _<path-to-repository>/ngra-pages/nginx/ssl/_ directory. 

Download the **nginx-repo.crt** and **nginx-repo.key** files for your NGINX Plus Developer License or subscription, and move them to the root directory of this project. You can then copy both of these files to the `/etc/nginx/ssl` directory of each microservice using the commands below:
```
cp nginx-repo.crt nginx-repo.key <path-to-repository>/ngra-pages/nginx/ssl/
```

{ Original source of Wiki duplicate }

The nudj-backend repository contains the api code, the mobileweb code and the desk (admin panel code). Below is the installation of the api code.

**Downloading the code**

1. `$ sudo git clone https://github.com/Nudj/nudj-backend.git`
2. `$ cd nudj-api` 

**Composer install**

1. `$ sudo composer install`


**Folders configurations**

1. ( `$ sudo mkdir storage` )
2. In `storage`
    * ( `$ sudo mkdir app` )
    * ( `$ sudo mkdir logs` )
    * ( `$ sudo mkdir framework` )
    * `$ sudo chown -R www-data app`
    * `$ sudo chown -R www-data logs`
    * `$ sudo chown -R www-data framework`
3. In `storage/framework`
    * ( `$ sudo mkdir sessions` )     
    * ( `$ sudo mkdir views` )     
    * ( `$ sudo mkdir cache` )  
    * `$ sudo chown -R www-data sessions`
    * `$ sudo chown -R www-data views`
    * (`$ sudo chown -R www-data cache`

**Credentials**

1. Install the .env file
2. Create the folder resources/certificates and put in it the iOS push notification production.pem file.

[Original source of Wiki duplicate]

Break down of the installation of a new Laravel instance at a subdomain.

```
1. navigate to `/var/www/mobileweb`
2. `$ sudo mkdir certificates` for the certificate files. 
3. `$ sudo git clone https://github.com/Nudj/nudj-web-application.git`
4. `$ cd nudj-web-application`
5. `$ sudo composer install`
6. `$ sudo composer update`
7. ( `$ git branch --track development origin/development` )
8. ( `$ sudo mkdir storage` )
9. In `storage`
    * ( `$ sudo mkdir app` )
    * ( `$ sudo mkdir logs` )
    * ( `$ sudo mkdir framework` )
    * `$ sudo chown -R www-data app`
    * `$ sudo chown -R www-data logs`
    * `$ sudo chown -R www-data framework`
11. In `storage/framework`
    * ( `$ sudo mkdir sessions` )     
    * ( `$ sudo mkdir views` )     
    * ( `$ sudo mkdir cache` )  
    * `$ sudo chown -R www-data sessions`
    * `$ sudo chown -R www-data views`
    * (`$ sudo chown -R www-data cache`)
12. Install the .env file
```
# payment-proceessor
Payment processor for Braintree
Should implement PaymentGatewayInterface interface and extend AbstractGateway abstract class

## SYSTEM REQUIREMENTS
- PHP >= 7.1.3
- Laravel 5.6

## INSTALLATION / SETUP

This installation guide is for Windows using Xampp.
```
1. Go to Xampp htdocs folder and git clone the repository: 
git clone https://github.com/sirish-shrestha/payment-processor.git

2. Set Up Virtual Hosts in the httpd-vhosts.conf file as below:
<VirtualHost payment-processor.demo:80>
	ServerName payment-processor.demo
	ServerAlias payment-processor.demo
	DocumentRoot E:/xamppLatest/htdocs/payment-processor.demo/public
	<Directory  "E:/xamppLatest/htdocs/payment-processor.demo/public">
		Order allow,deny
        Allow from all
		Require all granted
	</Directory>
</VirtualHost>
Note: Make sure the path is correct in document root and directory above.

3. Add the below code in Window HOST file (i.e. C:\Windows\System32\drivers\etc\hosts):
127.0.0.1   payment-processor.demo

4. COPY ".env.example" file to ".env" in root folder of the laravel project.
Configure database settings as per your local settings.

5. Run command in the root project folder:
composer install

6. Run Migrations and Seeders:
- php artisan migrate
- php artisan db:seed

7. Generate Key:
php artisan key:generate

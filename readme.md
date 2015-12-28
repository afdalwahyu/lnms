## lnms - Laravel NMS

Network Management System based on Laravel web application framework.

## System Requirements

Tested on CentOS 6
* MySQL 5.5 (rpm from dev.mysql.com)
* PHP 5.5 (yum from webtatic.com)
* composer (from https://getcomposer.org/)
* fping (need turn off SELinux)
* net-snmp 5.5

## Installation Instruction
### Clone this repository
```bash
$ git clone https://github.com/afdalwahyu/lnms.git
```

### Run composer install
Clone this repository
```bash
$ composer install
```

### open .env file and change your database, username & password variable

### Run php artisan migrate
```bash
$ php artisan migrate
```

### open localhost/lol/ in browser to create a username, or you can edit in routes.php in line 16 to 23
```php
Route::get('lol',function(){
  $user = new User;
  $user->name = 'afdal';
  $user->email = 'afdalwahyu@gmail.com';
  $user->username = 'afdalwahyu';
  $user->password = bcrypt('test');
  $user->save();
});
```


## License

lnms is open-sourced software licensed under the
[MIT license](http://opensource.org/licenses/MIT)

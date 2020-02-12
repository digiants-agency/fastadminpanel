### About
Inspired by serverless and quickadmin. you can use it at your own risk

DOESNT WORK CORRECTLY: get_standart_val, check_type + check errors on photo field, column type change, remove/change type relationship

TODO: required_once field, show in list: editable, soft delete, fields (date, datetime, file, password, select, repeat)

### Install
                
1. Configure DB and APP_URL file .env
2. composer require sv-digiants/fastadminpanel
3. Publish the packages config and assets: `php artisan vendor:publish --tag=fap_public` and `php artisan vendor:publish --tag=fap_view`
4. php artisan fastadminpanel:install
5. And add class aliases:
```php
'Image' => Intervention\Image\Facades\Image::class,
```
6. Publish the packages config and assets: `php artisan vendor:publish --tag=lfm_config` and `php artisan vendor:publish --tag=lfm_public`
7. Run commands to clear cache: `php artisan route:clear` and `php artisan config:clear`
8. In "config/lfm.php":
```php
add line: 'middlewares' => ['admin'],
change line: ('disk' => 'public',) to ('disk' => 'lfm',)
```
9. Add disk "config/filesystems.php":
```php
'lfm' => [
    'driver' => 'local',
    'root' => public_path(),
    'url' => env('APP_URL'),
    'visibility' => 'public',
],
```
10. /vendor/unisharp/laravel-filemanager/src/Lfm.php

```php
// Change first function:
public function getNameFromPath($path)
{
    return Lfm::mb_pathinfo($path, PATHINFO_BASENAME);
}
// Add function
public static function mb_pathinfo($path, $options = null)
{
    $ret = array('dirname' => '', 'basename' => '', 'extension' => '', 'filename' => '');
    $pathinfo = array();
    if (preg_match('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', $path, $pathinfo)) {
        if (array_key_exists(1, $pathinfo)) {
            $ret['dirname'] = $pathinfo[1];
        }
        if (array_key_exists(2, $pathinfo)) {
            $ret['basename'] = $pathinfo[2];
        }
        if (array_key_exists(5, $pathinfo)) {
            $ret['extension'] = $pathinfo[5];
        }
        if (array_key_exists(3, $pathinfo)) {
            $ret['filename'] = $pathinfo[3];
        }
    }
    switch ($options) {
        case PATHINFO_DIRNAME:
        case 'dirname':
            return $ret['dirname'];
        case PATHINFO_BASENAME:
        case 'basename':
            return $ret['basename'];
        case PATHINFO_EXTENSION:
        case 'extension':
            return $ret['extension'];
        case PATHINFO_FILENAME:
        case 'filename':
            return $ret['filename'];
        default:
            return $ret;
    }
}
```
11. /vendor/unisharp/laravel-filemanager/src/Controllers/UploadController.php:

```php
// change line 46:
$response = count($error_bag) > 0 ? $error_bag : parent::$success_response;
// to:
$response = count($error_bag) > 0 ? $error_bag : array(parent::$success_response);
```
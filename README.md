<h3 align="center">Open-source FastAdminPanel CMS</h3>
<p align="center">The open-source headless CMS made with Laravel and Vue.js, flexible and fully customizable.</p>

<br />

<p align="center">
	<a href="https://packagist.org/packages/digiants-agency/fastadminpanel"><img src="https://img.shields.io/packagist/v/digiants-agency/fastadminpanel" alt="Latest Stable Version"></a>
</p>

<br>

FastAdminPanel is a free and open-source headless CMS enabling you to manage any content, anywhere.

- **Modern Admin Pane**: Elegant, entirely customizable and a fully extensible admin panel.
- **Customizable**: You can quickly build your logic by fully customizing APIs, routes, or plugins to fit your needs perfectly.
- **Blazing Fast and Robust**: Built on top of Laravel and Vue.js, FastAdminPanel delivers reliable and solid performance.
- **Front-end Agnostic**: Use any front-end framework (React, Next.js, Vue, Angular, etc.), mobile apps or even IoT.

## Getting Started

### ⏳ Installation

Install Laravel first


```bash
composer create-project laravel/laravel="11.*" PROJECT_NAME
cd PROJECT_NAME
```

- (Use composer to install the FastAdminPanel project)

```bash
composer require digiants-agency/fastadminpanel
```

- Configure DB and APP_URL file in .env

- Run install command

```bash
php artisan fastadminpanel:install
```

- Publish the packages config and assets (laravel filemanager)
```bash
composer require intervention/image-laravel
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
```

- In "config/lfm.php"
```bash
change line: ('disk' => 'public',) to ('disk' => 'lfm',)

// add category of folder in folder_categories (48 line)
'admin' => [
    'folder_name'  => 'vendor/fastadminpanel/icons',
    'startup_view' => 'list',
    'max_size'     => 50000, // size in KB
    'valid_mime'   => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
        'application/pdf',
        'text/plain',
    ],
],
```

- Add disk "config/filesystems.php"
```bash
// add like line 44 from:
'lfm' => [
    'driver' => 'local',
    'root' => public_path(),
    'url' => env('APP_URL'),
    'visibility' => 'public',
],
```


Enjoy 🎉

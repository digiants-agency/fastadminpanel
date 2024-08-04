# Contents

- [Intro](#intro)
- [Getting started](#getting-started)
- [Concept](#concept)
- [Usage CRUD](#usage-crud-generator)
- [Usage Static content generator](#usage-static-content-generator)
- [Auto documentation](#auto-documentation)
- [Dropdown menu](#dropdown-menu)
- [Multilanguage](#multilanguage)
- [How to](#how-to)
  - [Open dev menu](#open-dev-menu)
  - [Change permissions](#change-permissions)
  - [Add custom page](#add-custom-page)
  - [Override field template](#override-field-template)
  - [Override CRUD service](#override-crud-service)

# Intro

<h3 align="center">Open-source free FastAdminPanel CRUD generator</h3>
<p align="center">The open-source headless CMS made with Laravel and Vue.js, flexible and fully customizable.</p>

<br />

<p align="center">
	<a href="https://packagist.org/packages/digiants-agency/fastadminpanel"><img src="https://img.shields.io/packagist/v/digiants-agency/fastadminpanel" alt="Latest Stable Version"></a>
</p>

<br>

FastAdminPanel is a free and open-source headless multilangual CMS enabling you to manage any content.

### Multilanguage CRUD generator with relations (15 field types) + models + migrations + documented api, static content generator

- **Modern Admin Panel**: Elegant, entirely customizable and a fully extensible admin panel.
- **Customizable**: You can quickly build your logic by fully customizing APIs, routes, or plugins to fit your needs perfectly.
- **Blazing Fast and Robust**: Built on top of Laravel and Vue.js, FastAdminPanel delivers reliable and solid performance.
- **Front-end Agnostic**: Use any front-end framework (React, Next.js, Vue, Angular, etc.), mobile apps or even IoT.

You can find some screenshots below.

Feel free to contact me: sv@digiants.com.ua

# Getting Started

### ⏳ Installation

 - Install Laravel first

```bash
composer create-project laravel/laravel="11.*" PROJECT_NAME
```

 - Go inside the folder

```bash
cd PROJECT_NAME
```

- Use the composer to install the FastAdminPanel project

```bash
composer require digiants-agency/fastadminpanel
```

- Configure DB and APP_URL in the .env file

- Run the install command

```bash
php artisan fastadminpanel:install
```

- Publish the packages config and assets (below [laravel filemanager](https://github.com/UniSharp/laravel-filemanager) installation)

```bash
composer require intervention/image-laravel
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
```

- In "config/lfm.php"
```
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
```
// add this config beginning from the line 44:
'lfm' => [
    'driver' => 'local',
    'root' => public_path(),
    'url' => env('APP_URL'),
    'visibility' => 'public',
],
```

Enjoy 🎉

# Concept

- You can generate CRUDs with this package. The package also automatically creates model files with relations and migrations (they are also added when updating or deleting CRUDs).
- Data about dropdown list, permissions and CRUDs are stored in json files, path = "/storage/app/ENTITY.json" (so this information will end up on the git). 
- You have the ability to create “single” entities to manage static content.
- The admin panel is fully multi-lingual. CRUD multilingualism is represented as identical tables in different languages, e.g. post_en, post_de. This approach [denormalizes](https://en.wikipedia.org/wiki/Denormalization) the database (increasing the amount of space occupied), but makes a very simple approach to manage it. The multilanguage model is very simple and is represented by the MultilanguageModel class.
- The admin panel is written without using npm or other such technologies, allowing it to be edited without reassembling.

# Usage of CRUD generator

- Go to https://yourdomain.com/admin/cruds
- Fill the fields:
  - **CRUD name** - the table name for the DB
  - **CRUD title** - the title for the menu
  - **Is dev** - the option to hide CRUD from menu (see more [Open dev menu](#open-dev-menu))
  - **Multilanguage** - the option to enable multilanguage (see more [Multilanguage](multilanguage))
  - **Is docs** - the option to show this CRUD in the auto generated documentation (see more [Documentation](#documentation))
  - **Show statistics** - the option to show this CRUD in the dashboard
  - **Model** - auto generated (there is no need to fill on creation) path to model. If you change path to generated model, you must change this field
  - **Default order** - field database title to set default sort order in the list of the entities
  - **Sort** - sort order in the menu
  - **Dropdown** - set parent menu item (see more [Dropdown menu](dropdown-menu))
  - **Icon** - set icon for the menu
  - **Fields** - set of fields that appear in your CRUD (15 types of the fields)
- Press the button "Create"
- Now you can create Controller and use generated Model in it. Or you can go to /fapi/{crud_slug}

Notes:
- All the data about CRUDs is stored in /storage/app/cruds.json (so this information will end up on the git)
- If you want to move the generated model from the default folder - you need to edit the **Model field** in the model in CRUD properly.
- If you **DON'T** want to edit the model automatically when you change the CRUD - you just need to remove the **Model field** in the CRUD (but this will break /fapi/{model}/{id}).
- To add [permissions](#change-permissions) for the automatic API, you need to go to /admin/settings

You can see the examples below:

- Creation:

![crudEditImage](https://digiants.com.ua/fastadminpanel/crud.png)

- List:

![crudListImage](https://digiants.com.ua/fastadminpanel/crud-list.png)

- Edit:

![crudEntityImage](https://digiants.com.ua/fastadminpanel/crud-edit.png)

# Usage of Static content generator

- Go to https://yourdomain.com/admin/singles
- Fill the fields:
  - **Single name** - inner ID for the API and usage in the code
  - **Single title** - title for the menu
  - **Sort** - sort order
  - **Dropdown** - parent menu item (see more [Dropdown menu](#dropdown-menu))
  - **Icon** - icon for the menu
- Press the button "Create"
- Now you can use it in the code like that: 
```php
use Single;

Single::get('your_slug_here');
```
- Or you can go to /fapi/singles/{your_slug_here}. Do not forget about [permissions](#change-permissions)

You can see the examples below:

- Creation:

![singleCreateImage](https://digiants.com.ua/fastadminpanel/singles-create.png)

- Edit:

![singleEditImage](https://digiants.com.ua/fastadminpanel/singles-edit.png)

# Auto documentation

Every CRUD created that has “Is docs” = Yes is displayed in the documentation. Also all static content “single” is displayed in the documentation.

- Documentation can be viewed at https://yourdomain.com/admin/docs.

- If you want to add your own documentation, go to /app/FastAdminPanel/Controllers/DocsController.php. There's already an example of how to write it

You can see the example of the documentation below:

![imageDocs](https://digiants.com.ua/fastadminpanel/docs.png)

# Dropdown menu

You can add a parent menu item for the singles and CRUDs you create.

- Go to: https://yourdomain.com/admin/dropdowns

- Add dropdowns

- Go to CRUD or single (static content generator) and add parent

You can see the example of the dropdown below:

![imageDropdown](https://digiants.com.ua/fastadminpanel/dropdown.png)

# Multilanguage

- The admin panel is fully multi-lingual. CRUD multilingualism is represented as identical tables in different languages, e.g. post_en, post_de. This approach [denormalizes](https://en.wikipedia.org/wiki/Denormalization) the database (increasing the amount of space occupied), but makes a very simple approach to manage it. The multilanguage model is very simple and is represented by the MultilanguageModel class.

- To make the custom model multilingual - just inherit the App\FastAdminPanel\Models\MultilanguageModel class.

- There is "Multilanguage" select in CRUD to make it multilangual.

- Each field has a Lang column to make it multi-lingual. If Lang == “common”, then when saving the field - the value will be updated in all the tables (for example posts_en, posts_de, posts_fr). If Lang == “separate”, then when saving the field - the value will be updated in the current language table only (for example posts_en).

- You can edit languages at https://yourdomain.com/admin/settings.

- The language of the admin panel is represented in the “admin_lang_tag” column of the User.

- There is a class Lang. It has several useful methods:

```
use Lang;

Lang::count(); // languages count
Lang::all(); // get all languages
Lang::get(); // get current language tag
Lang::is($langTag); // check language tag
Lang::main(); // get main language tag
...
```

# How to

## Open dev menu

- By default, internal settings for permissions, languages, crud, single and dropdown are hidden.

- All hidden menu items are displayed if APP_DEBUG=true in the .env file.

- You can also hide CRUDs ("Is dev" option).

- To show hidden menu items, you need to add "?dev=" to your address, for example: https://yourdomain.com/admin?dev=.

- To change query parameter, go to: /config/fap.php

## Change permissions

- Go to https://yourdomain.com/admin/cruds/roles to add roles.

- Each role has the “Is admin” option that allows the role to log into the admin panel.

- Go to https://yourdomain.com/admin/settings to change role permissions.

- Warning: be careful with relations. Someone can use a GET method with a relation (and the relation will not be checked for permission).

- Superadmin role is: Entities = all, All = true.

## Add custom page

- The example below exists, but it is commented out (https://github.com/digiants-agency/fastadminpanel/commit/5d6f2eb4bab58cebe1ddfc9a4a66f7e18e95a51b).

- Create Vue component. For example: 

```
/views/fastadminpanel/pages/admin/pages/custom.blade.php
```

- Include your page in the app. The app is here:

```
/views/fastadminpanel/layouts/app.blade.php
```

- Place your include after the dashboard: 

```
@include('fastadminpanel.pages.admin.pages.dashboard')
@include('fastadminpanel.pages.admin.pages.custom')
```

- Add Vue route in the app after the dashboard:

```
{
  path: '',
  name: 'home',
  component: dashboardPage,
},
{
  path: 'custom',
  name: 'custom',
  component: customPage,
},
```

- Add menu item to the sidebar (after menu v-for). The sidebar is here:

```
/views/fastadminpanel/pages/admin/parts/sidebar.blade.php
```

## Override field template

- Create your field by this rule and it will be applied accordingly:

```
/views/fastadminpanel/pages/admin/fields/custom/FIELD_TYPE-TABLE_NAME-DB_TITLE.blade.php
```

- FIELD_TYPE - the type of the field, for example: ckeditor, date etc.

- TABLE_NAME - the name of the CRUD table (place the word "all" for all tables)

- DB_TITLE - the title in the database of the field (place the word "all" for all fields)

Some examples already exist in the "custom" folder.

## Override CRUD service

- Add your own CRUD service to override some methods: index, show, store, update, copy, destroy.

- One such service already exists as example.

- Create your service here:

```
/app/FastAdminPanel/Services/Crud/Entity/Custom/YOUR_SERVICE_NAME.php
```

- Add your service to the provider:

```
/app/FastAdminPanel/Providers/FastAdminPanelServiceProvider.php
```

- Here:

```
protected $crudCustomServices = [
  // example
  'products'	=> [
    // methods: index, show, store, update, copy, destroy
    'show'	=> \App\FastAdminPanel\Services\Crud\Entity\Custom\ShowProductsService::class,
  ],
];
```

- The example above shows an override of the “show” method of the “products” table.
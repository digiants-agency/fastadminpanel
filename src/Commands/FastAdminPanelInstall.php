<?php

namespace Digiants\FastAdminPanel\Commands;

use App\User;
use Illuminate\Console\Command;
use Schema;
use DB;

class FastAdminPanelInstall extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fastadminpanel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run installation of FastAdminPanel.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() {
        $this->info('Please note: FastAdminPanel requires fresh Laravel installation!');
        $this->create_db();
        $this->add_roles();
        $this->add_user();
        $this->add_menu();
        $this->add_languages();
    }

    private function create_db() {
        
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->integer('role_id')->default(1);
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->timestamp('deleted_at')->nullable();
            });
        } else {
            $this->info('Users table has already exist!');
        }

        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        } else {
            $this->info('Roles table has already exist!');
        }

        if (!Schema::hasTable('menu')) {
            Schema::create('menu', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('table_name');
                $table->text('fields');
                $table->integer('is_dev');
                $table->integer('multilanguage');
                $table->integer('is_soft_delete');
                $table->integer('sort');
                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        } else {
            $this->info('Menu table has already exist!');
        }
        
        if (!Schema::hasTable('languages')) {
            Schema::create('languages', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->increments('id');
                $table->string('tag');
                $table->string('title');
                $table->integer('main_lang');
            });
        } else {
            $this->info('Languages table has already exist!');
        }

        $this->info('DB creation complete!');
    }

    private function add_roles() {

        DB::table('roles')->insert([
            'title' => 'Administrator'
        ]);
        DB::table('roles')->insert([
            'title' => 'User'
        ]);
    }

    private function add_languages() {

        DB::table('languages')->insert([
            'tag' => 'en',
            'title' => 'English',
            'main_lang' => 1,
        ]);
    }

    private function add_user() {

        $data = [];
        $data['name']     = $this->ask('Administrator name');
        $data['email']    = $this->ask('Administrator email');
        $data['password'] = bcrypt($this->secret('Administrator password'));
        $data['role_id']  = 1;
        User::create($data);
        $this->info('User has been created');
    }

    private function add_menu() {

        DB::table('menu')->insert([
            'title'             => 'Menu',
            'table_name'        => 'menu',
            'fields'            => '[]',
            'is_dev'            => '1',
            'multilanguage'     => '0',
            'is_soft_delete'    => '0',
            'sort'              => '0',
        ]);
        DB::table('menu')->insert([
            'title'             => 'Roles',
            'table_name'        => 'roles',
            'fields'            => '[{"id":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"title","title":"Title"}]',
            'is_dev'            => '1',
            'multilanguage'     => '0',
            'is_soft_delete'    => '0',
            'sort'              => '1',
        ]);
        DB::table('menu')->insert([
            'title'             => 'Users',
            'table_name'        => 'users',
            'fields'            => '[{"id":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"name","title":"Name"},{"id":1,"required":"optional","is_visible":true,"show_in_list":"no","type":"number","db_title":"role_id","title":"Role id"},{"id":2,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"email","title":"Email"}]',
            'is_dev'            => '0',
            'multilanguage'     => '0',
            'is_soft_delete'    => '0',
            'sort'              => '2',
        ]);
        $this->info('Menu has been created');
    }
}
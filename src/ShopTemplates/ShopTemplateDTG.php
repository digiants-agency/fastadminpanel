<?php

namespace Digiants\FastAdminPanel\ShopTemplates;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShopTemplateDTG extends ShopTemplate{

    private function shop_path_package ($path) {

		return base_path("/vendor/sv-digiants/fastadminpanel/templates/shop/DTG" . $path);
	}

    public function import_default_shop(){

        $this->import_public();

        // $views = [
        //     'layouts/app.blade.php',
        //     'inc/footer.blade.php',
        //     'inc/header.blade.php',
        //     'inc/horizontal.blade.php',
        //     'inc/salebanner.blade.php',
        //     'pages/about.blade.php',
        //     'pages/article.blade.php',
        //     'pages/blog.blade.php',
        //     'pages/catalog.blade.php',
        //     'pages/contact.blade.php',
        //     'pages/delandpay.blade.php',
        //     'pages/index.blade.php',
        //     'pages/order.blade.php',
        //     'pages/product.blade.php',
        //     'pages/search.blade.php',
        //     'pages/successorder.blade.php',
        //     'pages/userinfo.blade.php',
        //     'fastadminpanel/components/custom/vigruzka.php',
        // ];

        // foreach ($views as $path) {
        //     if (file_exists(base_path("/views/$path")))
        //         unlink(base_path("/views/$path"));

        //     copy(
        //         $this->shop_path_package("/views/$path"),
        //         base_path("/resources/views/$path")
        //     );
        // }

        // $shop = [
        //     'Shop/Cart.php',
        //     'Shop/CartDB.php',
        //     'Shop/CartSession.php',
        //     'Shop/Saved.php',
        //     'CartHandler.php',
        //     'SavedHandler.php',
        // ];

        // mkdir(base_path("/app/Shop"));
        // foreach ($shop as $path) {
        //     if (file_exists(base_path("/app/$path")))
        //         unlink(base_path("/app/$path"));

        //     copy(
        //         $this->shop_path_package("/$path"),
        //         base_path("/app/$path")
        //     );
        // }
        // // routes
        // if (file_exists(base_path("/routes/web.php")))
        //     unlink(base_path("/routes/web.php"));
            
        // copy(
        //     $this->shop_path_package("/web.php"),
        //     base_path("/routes/web.php")
        // );

        // $controllers = [
        //     'BlogController.php',
        //     'CartController.php',
        //     'CatalogController.php',
        //     'Controller.php',
        //     'PageController.php',
        //     'ProductController.php',
        //     'SearchController.php',
        //     'SitemapController.php',
        //     'UserController.php',
        // ];

        // foreach ($controllers as $path) {
        //     if (file_exists(base_path("/Controllers/$path")))
        //         unlink(base_path("/app/Http/Controllers/$path"));

        //     copy(
        //         $this->shop_path_package("/Controllers/$path"),
        //         base_path("/app/Http/Controllers/$path")
        //     );
        // }

        // if (file_exists(base_path("/app/Providers/AppServiceProvider.php")))
        //     unlink(base_path("/app/Providers/AppServiceProvider.php"));

        // copy(
        //     $this->shop_path_package("/AppServiceProvider.php"),
        //     base_path("/app/Providers/AppServiceProvider.php")
        // );

        // $this->template_add_folder(public_path('/images'));

        // $images = [
        //     'about.png',
        //     'aboutbanner.jpg',
        //     'abouticon.svg',
        //     'arrow.svg',
        //     'banner.jpg',
        //     'category.jpg',
        //     'history.jpg',
        //     'logo.svg',
        //     'lupa.png',
        //     'news.jpg',
        //     'producslider.jpg',
        //     'product.jpg',
        //     'sale.png',
        // ];

        // foreach ($images as $path) {
        //     copy(
        //         $this->shop_path_package("/images/$path"),
        //         public_path("/images/$path")
        //     );
        // }

        // $this->create_db_shop();
        // $this->copyshopdata();

        return 'Success';
	}

	private function import_public(){

		//copy and change styles

        if (file_exists(public_path("/css/desktop-src.css")))
            unlink(public_path("/css/desktop-src.css"));
        if (file_exists(public_path("/css/mobile-src.css")))
            unlink(public_path("/css/mobile-src.css"));

        // copy(
        //     $this->shop_path_package("/public/css/desktop-src.css"),
        //     public_path("/css/desktop-src.css"));

        // copy(
        //     $this->shop_path_package("/public/css/mobile-src.css"),
        //     public_path("/css/mobile-src.css"));

		// $css_files = $this->folder_files($this->shop_path_package('/public/css/cache'));

		// $this->template_add_folder(public_path('/css/cache'));

		// foreach ($css_files as $css_file) {
		// 	copy(
		// 		$this->shop_path_package("/public/css/cache/".$css_file),
		// 		public_path("/css/cache/".$css_file));
		// }

		$this->copy_files($this->shop_path_package("/public/css/"), public_path('/css/'));


		//copy and change js

		// $this->template_add_folder(public_path('/js'));
		// $this->template_add_folder(public_path('/js/cache'));

		// copy(
        //     $this->shop_path_package("/public/js/priceslider.js"),
        //     public_path("/js/priceslider.js"));

        // copy(
        //     $this->shop_path_package("/public/js/slider.js"),
        //     public_path("/js/slider.js"));

		// $js_files = $this->folder_files($this->shop_path_package('/public/js/cache'));
		// foreach ($js_files as $js_file) {
		// 	copy(
		// 		$this->shop_path_package("/public/js/cache/".$js_file),
		// 		public_path("/js/cache/".$js_file));
		// }

		$this->copy_files($this->shop_path_package("/public/js/"), public_path('/js/'));

		//copy fonts

		// $this->template_add_folder(public_path('/fonts'));
		
		// $fonts_files = $this->folder_files($this->shop_path_package('/public/fonts'));

		// foreach ($fonts_files as $fonts_file) {
		// 	copy(
		// 		$this->shop_path_package('/public/fonts/'.$fonts_file),
		// 		public_path('/fonts/'.$js_file));
		// }

		$this->copy_files($this->shop_path_package('/public/fonts/'), public_path('/fonts/'));


	}

	public function copy_files($from, $to) {

		if ($from[strlen($from) - 1] != '/')
			$from .= '/';
		
		if ($to[strlen($to) - 1] != '/')
			$to .= '/';

		$this->template_add_folder($to);

		$files = $this->folder_files($from);

		foreach ($files as $file) {

			if (is_dir($from.$file)) {
				$this->copy_files($from.$file, $to.$file);
			}

			copy(
				$from.$file,
				$to.$file
			);
		}

	}

	private function create_db_shop(){
		//create single language tables

        if (!Schema::hasTable('cart')) {
            Schema::create('cart', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('id_users');
                $table->integer('id_product');
                $table->integer('count');
                $table->string('meta')->default('');
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        } else {
            return 'callback table has already exist!';
        }

		if (!Schema::hasTable('callback')) {
			Schema::create('callback', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->datetime('data');
				$table->string('title')->default('');
				$table->string('tel')->default('');
				$table->string('link')->default('');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			return 'callback table has already exist!';
		}

		if (!Schema::hasTable('custom_user')) {
			Schema::create('custom_user', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('id_users');
				$table->string('last_name')->default('');
				$table->string('tel')->default('');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			return 'custom_user table has already exist!';
		}


		if (!Schema::hasTable('orders')) {
			Schema::create('orders', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->datetime('data');
				$table->text('name');
				$table->text('tel');
				$table->text('email');
				$table->text('country');
				$table->text('region');
				$table->text('city');
				$table->text('adress');
				$table->text('deltype');
				$table->text('paytype');
				$table->integer('paystatus')->default(0);
				$table->string('status');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			return 'orders table has already exist!';
		}


		if (!Schema::hasTable('orders_product')) {
			Schema::create('orders_product', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('id_orders');
				$table->text('title');
				$table->text('attributes');
				$table->integer('price');
				$table->integer('count');
				$table->text('img');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			return 'orders_product table has already exist!';
		}


		if (!Schema::hasTable('product_filter_fields')) {
			Schema::create('product_filter_fields', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('id_product');
				$table->integer('id_filter_fields');
			});
		} else {
			return 'product_filter_fields table has already exist!';
		}


		if (!Schema::hasTable('product_mods')) {
			Schema::create('product_mods', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('id_product');
				$table->integer('id_mods');
			});
		} else {
			return 'product_mods table has already exist!';
		}


		if (!Schema::hasTable('wishlist')) {
			Schema::create('wishlist', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('id_users');
				$table->string('slug');
				$table->text('img');
				$table->string('attr');
				$table->decimal('price',15,2);
				$table->decimal('sale_price',15,2);
				$table->string('title');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			});
		} else {
			return 'wishlist table has already exist!';
		}

		if (!Schema::hasTable('reviews')) {
			Schema::create('reviews', function (\Illuminate\Database\Schema\Blueprint $table) {
				$table->bigIncrements('id');
				$table->integer('id_product');
				$table->string('name');
				$table->string('tel');
				$table->string('email');
				$table->text('note');
				$table->integer('status');
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				$table->text('answer');
				$table->date('date');
			});
		} else {
			return 'reviews table has already exist!';
		}

		$langs = DB::table('languages')->get();
		foreach($langs as $l){
			//blog
			$tablename = "blog_".$l->tag;
			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
					$table->bigIncrements('id');
					$table->text('title');
					$table->string('img');
					$table->text('preview');
					$table->string('preview_img');
					$table->string('slug');
					$table->text('content');
					$table->text('meta_title');
					$table->text('meda_descr');
					$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
					$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				});
			} else {
				return $tablename.' table has already exist!';
			}

            //blog
            $tablename = "page_".$l->tag;
            if (!Schema::hasTable($tablename)) {
                Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('title');
                    $table->string('slug');
                    $table->text('content');
                    $table->text('meta_title');
                    $table->text('meda_description');
                    $table->text('meta_keywords');
                    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                });
            } else {
                return $tablename.' table has already exist!';
            }

			//category
			$tablename = "category_".$l->tag;
			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
					$table->bigIncrements('id');
					$table->string('title');
					$table->string('slug');
					$table->string('img');
					$table->text('meta_title');
					$table->text('meta_descr');
					$table->text('h1');
					$table->text('seo_text');
					$table->integer('sort');
					$table->integer('id_category');
					$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
					$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				});
			} else {
				return $tablename.' table has already exist!';
			}
			//filters

			$tablename = "filters_".$l->tag;
			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
					$table->bigIncrements('id');
					$table->string('title');
					$table->string('slug');
					$table->integer('is_attribute');
					$table->integer('is_filter');
					$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
					$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				});
			} else {
				return $tablename.' table has already exist!';
			}
			//filter_fields

			$tablename = "filter_fields_".$l->tag;
			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
					$table->bigIncrements('id');
					$table->string('title');
					$table->string('slug');
					$table->integer('id_filters');
					$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
					$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				});
			} else {
				return $tablename.' table has already exist!';
			}
			//mods

			$tablename = "mods_".$l->tag;
			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
					$table->bigIncrements('id');
					$table->string('title_mod');
					$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
					$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				});
			} else {
				return $tablename.' table has already exist!';
			}
			//product
			$tablename = "product_".$l->tag;
			if (!Schema::hasTable($tablename)) {
				Schema::create($tablename, function (\Illuminate\Database\Schema\Blueprint $table) {
					$table->bigIncrements('id');
					$table->text('title');
					$table->text('slug');
					$table->decimal('price',15,2);
					$table->decimal('sale_price',15,2);
					$table->integer('available');
					$table->string('title_short_descr');
					$table->text('short_descr');
					$table->string('image');
					$table->text('gallery');
					$table->text('description');
					$table->text('meta_title');
					$table->text('meta_descr');
					$table->integer('id_category');
					$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
					$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
				});
			} else {
				return $tablename.' table has already exist!';
			}
		}
	}

	private function copyshopdata(){

		//dropdown
		DB::table('dropdown')->insert([
			'id'             => '1',
			'title'        => 'Настройки',
			'sort'            => '1',
		]);
		DB::table('dropdown')->insert([
			'id'             => '2',
			'title'        => 'Страницы',
			'sort'            => '2',
		]);


		//single_page
		DB::table('single_page')->insert([
			'id'             => '1',
			'title'        => 'Шапка',
			'sort'            => '10',
			'parent'            => '1',
		]);
		DB::table('single_page')->insert([
			'id'             => '2',
			'title'        => 'Главная',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '3',
			'title'        => 'О нас',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '4',
			'title'        => 'Новости',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '5',
			'title'        => 'Контакты',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '6',
			'title'        => 'Статья',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '7',
			'title'        => 'Доставка и оплата',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '8',
			'title'        => 'Оформление заказа',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '9',
			'title'        => 'Заказ успешно оформлен',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '10',
			'title'        => 'Модальные окна',
			'sort'            => '10',
			'parent'            => '2',
		]);
		DB::table('single_page')->insert([
			'id'             => '11',
			'title'        => 'Футер',
			'sort'            => '10',
			'parent'            => '1',
		]);
		DB::table('single_page')->insert([
			'id'             => '12',
			'title'        => 'Баннер со скидкой',
			'sort'            => '10',
			'parent'            => '1',
		]);
		DB::table('single_page')->insert([
			'id'             => '13',
			'title'        => 'Горизонтальная форма',
			'sort'            => '10',
			'parent'            => '1',
		]);


		//menu
		DB::table('menu')->insert([
			'title'             => 'Категории',
			'table_name'        => 'category',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"title","title":"Название"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"slug","title":"Ccылка"},{"id":8,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_table_name":"category","relationship_count":"single","title":"Родительская категория","relationship_view_field":"title"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"photo","db_title":"img","title":"Изображение"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_title","title":"Meta Title"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_descr","title":"Meta Descr"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"h1","title":"h1 заголовок"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"ckeditor","db_title":"seo_text","title":"SEO текст"},{"id":7,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"number","db_title":"sort","title":"Номер сортировки"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Страницы',
			'table_name'        => 'page',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"title","title":"Название"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"slug","title":"Ccылка"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_title","title":"Meta Title"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_description","title":"Meta Descr"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_keywords","title":"Meta keys"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"ckeditor","db_title":"seo_text","content":"Контент"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Товары',
			'table_name'        => 'product',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"textarea","db_title":"title","title":"Название"},{"id":14,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"slug","title":"Ссылка"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"money","db_title":"price","title":"Цена"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"money","db_title":"sale_price","title":"Цена со скидкой"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"checkbox","db_title":"available","title":"Наличие"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"title_short_descr","title":"Заголовок краткого описания"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"short_descr","title":"Краткое описание"},{"id":6,"required":"optional","is_visible":true,"lang":"0","show_in_list":"no","type":"photo","db_title":"image","title":"Изображение"},{"id":7,"required":"optional","is_visible":true,"lang":"0","show_in_list":"no","type":"gallery","db_title":"gallery","title":"Галерея"},{"id":8,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"ckeditor","db_title":"description","title":"Описание"},{"id":9,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_title","title":"Meta title"},{"id":10,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_descr","title":"Meta descr"},{"id":11,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"many","relationship_table_name":"filter_fields","relationship_view_field":"title","title":"Фильтр или аттрибут"},{"id":12,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"category","relationship_view_field":"title","title":"Категория"},{"id":13,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"many","relationship_table_name":"mods","relationship_view_field":"title_mod","title":"Модификации (размеры)"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Фильтры',
			'table_name'        => 'filters',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","db_title":"title","title":"Заголовок","type":"text"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"slug","title":"Ссылка","type":"text"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"is_attribute","title":"Это атрибут?","type":"checkbox"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"is_filter","title":"Присутствует в фильтре?","type":"checkbox"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"editable","relationship_table_name":"filter_fields","title":"Поля"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Поля фильтров',
			'table_name'        => 'filter_fields',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"title","title":"Название"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"slug","title":"Ссылка"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"filters","relationship_view_field":"title","title":"Фильтр"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Модификации',
			'table_name'        => 'mods',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"title_mod","title":"Название"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Заказы',
			'table_name'        => 'orders',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"textarea","db_title":"name","title":"Имя"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"tel","title":"Телефон"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"email","title":"email"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"country","title":"Страна"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"region","title":"Область"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"city","title":"Город"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"adress","title":"Адрес","type":"textarea"},{"id":7,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"deltype","title":"Способ доставки","type":"textarea"},{"id":8,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"paytype","title":"Тип оплаты","type":"textarea"},{"id":9,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"paystatus","title":"Статус оплаты","type":"checkbox"},{"id":11,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"enum","enum":["Новый","В дороге","В ожидании","Отменен"],"db_title":"status","title":"Статус"},{"id":12,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"editable","relationship_table_name":"orders_product","title":"Товары"},{"id":13,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"data","title":"Дата"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Заказанные товары',
			'table_name'        => 'orders_product',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"orders","relationship_view_field":"name","title":"Заказ"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","title":"Название","db_title":"title","type":"textarea"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","title":"Атрибуты","db_title":"attributes","type":"textarea"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","title":"Цена","db_title":"price","type":"number"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","title":"Количество","db_title":"count","type":"number"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","title":"Ссылка в магазине","db_title":"link","type":"textarea"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"img","type":"photo","title":"Изображение"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Заявки с сайта',
			'table_name'        => 'callback',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"title","title":"Имя"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"tel","title":"Номер телефона"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"link","title":"Ссылка заказа"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"data","title":"Дата"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Блог \ новости',
			'table_name'        => 'blog',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"textarea","db_title":"title","title":"Заголовок"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"slug","type":"text","title":"Ссылка"},{"id":2,"required":"optional","is_visible":true,"lang":"0","show_in_list":"no","type":"photo","db_title":"img","title":"Главное изображение"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"preview","title":"Превью (текст)"},{"id":3,"required":"optional","is_visible":true,"lang":"0","show_in_list":"no","db_title":"preview_img","type":"photo","title":"Превью (изображение"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"content","type":"ckeditor","title":"Контент"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meta_title","title":"Meta title"},{"id":7,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"textarea","db_title":"meda_descr","title":"Meta descr"}]',
			'is_dev'            => '0',
			'multilanguage'     => '1',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Поля пользователей',
			'table_name'        => 'custom_user',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"users","relationship_view_field":"email","title":"Email"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"last_name","title":"Фамилия"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"tel","type":"text","title":"Телефон"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'wishlist',
			'table_name'        => 'wishlist',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"relationship","relationship_count":"single","relationship_table_name":"users","relationship_view_field":"email","title":"user"},{"id":7,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"title","title":"Товар"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"slug","title":"Ссылка"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"photo","db_title":"img","title":"Изображение"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"attr","title":"Атрибут"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"money","db_title":"price","title":"Цена"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","db_title":"sale_price","type":"money","title":"Цена со скидкой"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		DB::table('menu')->insert([
			'title'             => 'Отзывы',
			'table_name'        => 'reviews',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"product","relationship_view_field":"title","title":"Товар"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"name","title":"ФИО"},{"id":2,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"text","db_title":"tel","title":"Телефон"},{"id":3,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"text","db_title":"email","title":"email"},{"id":4,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"textarea","db_title":"note","title":"Текст"},{"id":5,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"checkbox","db_title":"status","title":"status"},{"id":6,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"textarea","db_title":"answer","title":"Ответ на отзыв"},{"id":7,"required":"optional","is_visible":true,"lang":1,"show_in_list":"yes","type":"date","db_title":"date","title":"Дата"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '10',
		]);

		//single_field

		DB::statement("INSERT INTO `single_field` (`id`, `is_multilanguage`, `type`, `title`, `block_title`, `single_page_id`, `sort`) VALUES
		(2, 1, 'repeat', 'Пункт меню', 'Меню', 1, 1),
		(3, 1, 'text', 'Каталог', 'Шапка', 1, 1),
		(4, 1, 'text', 'Введите свой запрос', 'Шапка', 1, 2),
		(5, 1, 'text', 'Поиск показать все', 'Шапка', 1, 3),
		(6, 1, 'text', 'Пн-Вс: 09:00-21:00', 'Шапка', 1, 4),
		(7, 1, 'text', '(067)-777-77-77', 'Шапка', 1, 5),
		(8, 1, 'text', 'Обратный звонок', 'Шапка', 1, 6),
		(9, 1, 'photo', 'Изображение', 'Баннер', 2, 1),
		(10, 1, 'text', 'Заголовок', 'Баннер', 2, 2),
		(11, 1, 'text', 'Ссылка кнопки', 'Баннер', 2, 3),
		(12, 1, 'text', 'Текст кнопки', 'Баннер', 2, 4),
		(13, 1, 'text', 'Хиты продаж текст', 'Хиты продаж', 2, 1),
		(14, 1, 'text', 'Заголовок', 'О нас', 2, 1),
		(15, 1, 'textarea', 'Контент', 'О нас', 2, 2),
		(16, 1, 'text', 'Ссылка кнопки', 'О нас', 2, 3),
		(17, 1, 'text', 'Текст кнопки', 'О нас', 2, 4),
		(18, 1, 'photo', 'Изображение', 'О нас', 2, 5),
		(19, 1, 'text', 'Заголовок', 'Новости и статьи', 2, 1),
		(20, 1, 'textarea', 'Title', 'Meta', 2, 1),
		(21, 1, 'textarea', 'Description', 'Meta', 2, 2),
		(22, 1, 'textarea', 'Keywords', 'Meta', 2, 3),
		(23, 1, 'text', 'Заголовок', 'Первый блок', 3, 1),
		(24, 1, 'photo', 'Изображение', 'Первый блок', 3, 2),
		(25, 1, 'textarea', 'Описание', 'Первый блок', 3, 3),
		(26, 1, 'text', 'Наши преимущества', 'Преимущества', 3, 1),
		(27, 1, 'repeat', 'Преимущества', 'Преимущества', 3, 2),
		(28, 1, 'text', 'Заголовок', 'Наша история', 3, 1),
		(29, 1, 'ckeditor', 'Контент', 'Наша история', 3, 2),
		(30, 1, 'photo', 'Изображение', 'Наша история', 3, 3),
		(31, 1, 'textarea', 'Title', 'Meta', 3, 1),
		(32, 1, 'textarea', 'Description', 'Meta', 3, 2),
		(33, 1, 'textarea', 'Keywords', 'Meta', 3, 3),
		(34, 1, 'text', 'Новости и статьи', 'Новости и статьи', 4, 1),
		(35, 1, 'textarea', 'Title', 'Meta', 4, 1),
		(36, 1, 'textarea', 'Description', 'Meta', 4, 2),
		(37, 1, 'textarea', 'Keywords', 'Meta', 4, 3),
		(38, 1, 'text', 'Заголовок', 'Контакты', 5, 1),
		(39, 1, 'text', 'Номер телефона 1', 'Контакты', 5, 2),
		(40, 1, 'text', 'Номер телефона 2', 'Контакты', 5, 3),
		(41, 1, 'text', 'Время работы', 'Контакты', 5, 4),
		(42, 1, 'text', 'email', 'Контакты', 5, 5),
		(43, 1, 'text', 'Место', 'Контакты', 5, 6),
		(44, 1, 'text', 'Заголовок', 'Форма обратной связи', 5, 1),
		(45, 1, 'text', 'Ваше имя', 'Форма обратной связи', 5, 2),
		(46, 1, 'text', 'Ваш номер телефона', 'Форма обратной связи', 5, 3),
		(47, 1, 'text', 'Ваш email', 'Форма обратной связи', 5, 4),
		(48, 1, 'text', 'Сообщение', 'Форма обратной связи', 5, 5),
		(49, 1, 'text', 'Отправить', 'Форма обратной связи', 5, 6),
		(50, 1, 'textarea', 'Title', 'Meta', 5, 1),
		(51, 1, 'textarea', 'Description', 'Meta', 5, 2),
		(52, 1, 'textarea', 'Keywords', 'Meta', 5, 3),
		(53, 1, 'text', 'Читайте также', 'Читайте также', 6, 1),
		(54, 1, 'text', 'Заголовок', 'Доставка и оплата', 7, 1),
		(55, 1, 'ckeditor', 'Контент', 'Доставка и оплата', 7, 2),
		(56, 1, 'textarea', 'Title', 'Meta', 7, 1),
		(57, 1, 'textarea', 'Description', 'Meta', 7, 2),
		(58, 1, 'textarea', 'Keywords', 'Meta', 7, 3),
		(59, 1, 'text', 'Заголовок', 'Оформление заказа', 8, 1),
		(60, 1, 'repeat', 'Методы доставки', 'Доставка', 8, 1),
		(62, 1, 'textarea', 'Title', 'Meta', 8, 1),
		(63, 1, 'textarea', 'Description', 'Meta', 8, 2),
		(64, 1, 'textarea', 'Keywords', 'Meta', 8, 3),
		(65, 1, 'text', 'Заголовок', 'Оформление заказа', 9, 1),
		(66, 1, 'textarea', 'Заголовок', 'Заказ оформлен', 9, 1),
		(67, 1, 'textarea', 'Заголовок', 'Мы свяжемся с вами', 9, 1),
		(68, 1, 'textarea', 'Title', 'Meta', 9, 1),
		(69, 1, 'textarea', 'Description', 'Meta', 9, 2),
		(70, 1, 'textarea', 'Keywords', 'Meta', 9, 3),
		(71, 1, 'text', 'Заголовок', 'Обратный звонок', 10, 1),
		(72, 1, 'text', 'Имя', 'Обратный звонок', 10, 2),
		(73, 1, 'text', 'Телефон', 'Обратный звонок', 10, 3),
		(74, 1, 'text', 'Отправить', 'Обратный звонок', 10, 4),
		(75, 1, 'text', 'Заголовок', 'Модальная коризна', 10, 1),
		(76, 1, 'text', 'Продолжить покупки', 'Модальная коризна', 10, 2),
		(77, 1, 'text', 'Оформить заказ', 'Модальная коризна', 10, 3),
		(78, 1, 'text', 'Заголовок', 'Футер меню 1', 11, 1),
		(79, 1, 'repeat', 'Меню 1', 'Футер', 11, 2),
		(80, 1, 'text', 'Заголовок', 'Футер меню 2', 11, 1),
		(81, 1, 'repeat', 'Меню 2', 'Футер', 11, 3),
		(82, 1, 'text', 'Заголовок', 'Футер меню 3', 11, 1),
		(83, 1, 'repeat', 'Меню 3', 'Футер', 11, 4),
		(84, 1, 'text', 'Заголовок', 'Футер меню 4', 11, 1),
		(85, 1, 'repeat', 'Меню 4', 'Футер', 11, 5),
		(86, 1, 'text', 'Войти', 'Авторизация', 10, 8),
		(87, 1, 'text', 'E-mail', 'Авторизация', 10, 2),
		(88, 1, 'text', 'Пароль', 'Авторизация', 10, 3),
		(89, 1, 'text', 'Авторизоватся', 'Авторизация', 10, 4),
		(90, 1, 'text', 'Ошибка', 'Авторизация', 10, 5),
		(91, 1, 'text', 'Забыли пароль', 'Авторизация', 10, 6),
		(92, 1, 'text', 'Регистрация', 'Авторизация', 10, 9),
		(93, 1, 'repeat', 'Методы оплаты', 'Оплата', 8, 1),
		(94, 1, 'repeat', 'Преимущества2', 'Преимущества', 3, 2),
		(95, 1, 'text', 'Восстановить пароль', 'Восстановить пароль', 10, 1),
		(96, 1, 'text', 'E-mail', 'Восстановить пароль', 10, 2),
		(97, 1, 'text', 'Восстановить', 'Восстановить пароль', 10, 3),
		(98, 1, 'repeat', 'Обратный звонок', 'Футер', 11, 1),
		(99, 1, 'text', 'Ссылка', 'Акция', 2, 2),
		(100, 1, 'text', 'Кнопка', 'Акция', 2, 3),
		(101, 1, 'photo', 'Картинка', 'Акция', 2, 1),
		(102, 1, 'photo', 'Картинка', 'Акция', 13, 1),
		(103, 1, 'photo', 'Картинка моб', 'Акция', 13, 2),
		(104, 1, 'text', 'Ссылка', 'Акция', 13, 3),
		(105, 1, 'text', 'Кнопка', 'Акция', 13, 4),
		(106, 1, 'photo', 'Картинка', 'Акция', 12, 1),
		(107, 1, 'photo', 'Картинка моб', 'Акция', 12, 2),
		(108, 1, 'text', 'Ссылка', 'Акция', 12, 3),
		(109, 1, 'text', 'Кнопка', 'Акция', 12, 4);");

		//single_text WITH LANGUAGES

		$langs = DB::table('languages')->get();
		foreach($langs as $l){
			$tablename = 'single_text_'.$l->tag;
			DB::statement("INSERT INTO `{$tablename}` (`field_id`, `value`) VALUES
			(2, '[{\"title\":\"Ссылка\",\"type\":\"text\",\"default\":null,\"values\":[\"about\",\"delandpay\",\"blog\",\"contact\"]},{\"title\":\"Заголовок\",\"type\":\"text\",\"default\":null,\"values\":[\"О компании\",\"Оплата и доставка\",\"Новости\",\"Контакты\"]}]'),
			(60, '[{\"title\":\"Заголовок\",\"type\":\"text\",\"default\":null,\"values\":[\"Стандартная доставка\",\"УкрПошта\"]},{\"title\":\"Сроки\",\"type\":\"text\",\"default\":\"5-7 рабочих дней\",\"values\":[\"Доставим сегодня\",\"Не доставим\"]},{\"title\":\"Цена\",\"type\":\"text\",\"default\":\"300 грн\",\"values\":[\"300\",\"200\"]}]'),
			(61, 'null'),
			(62, ''),
			(63, ''),
			(64, ''),
			(79, '[{\"title\":\"Ссылка\",\"type\":\"text\",\"default\":\"\",\"values\":[]},{\"title\":\"Название\",\"type\":\"text\",\"default\":\"\",\"values\":[]}]'),
			(81, '[{\"title\":\"Ссылка\",\"type\":\"text\",\"default\":\"\",\"values\":[]},{\"title\":\"Название\",\"type\":\"text\",\"default\":\"\",\"values\":[]}]'),
			(83, '[{\"title\":\"Ссылка\",\"type\":\"text\",\"default\":\"\",\"values\":[]},{\"title\":\"Название\",\"type\":\"text\",\"default\":\"\",\"values\":[]}]'),
			(85, '[{\"title\":\"Ссылка\",\"type\":\"text\",\"default\":\"\",\"values\":[]},{\"title\":\"Название\",\"type\":\"text\",\"default\":\"\",\"values\":[]}]'),
			(93, '[{\"title\":\"Заголовок\",\"type\":\"text\",\"default\":null,\"values\":[\"Оплата\",\"Приват\"]}]'),
			(98, '[{\"title\":\"Ссылка\",\"type\":\"text\",\"default\":\"\",\"values\":[]},{\"title\":\"Изображение\",\"type\":\"photo\",\"default\":\"\",\"values\":[]},{\"title\":\"Название\",\"type\":\"text\",\"default\":\"\",\"values\":[]}]');");
		}

		return 'All data copied.';
	}


}
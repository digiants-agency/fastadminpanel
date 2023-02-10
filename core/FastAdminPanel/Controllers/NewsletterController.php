<?php 

namespace App\FastAdminPanel\Controllers;

use App\User;
use DB;
use Schema;
use Validator;
use Lang;

class NewsletterController extends \App\Http\Controllers\Controller {

	public function get () {

		$data = [];

		$user_count = DB::selectOne('SELECT SUM(send_count) AS sum FROM newsletter_users')->sum;
		$hits_count = DB::selectOne('SELECT SUM(hits) AS sum FROM newsletter_users')->sum;

		$data['statistics'] = [
			[
				'title' => 'Number of clients',
				'value' => DB::table('newsletter_users')->count(),
			],
			[
				'title' => 'Letters sent',
				'value' => $user_count,
			],
			[
				'title' => 'Letters read',
				'value' => $hits_count,
			],
			[
				'title' => 'Unsubscriptions',
				'value' => DB::selectOne('SELECT SUM(is_unsubscribe) AS sum FROM newsletter_users')->sum,
			],
			[
				'title' => 'Conversion',
				'value' => round(100 * $hits_count / (($user_count == 0) ? 1 : $user_count), 2),
			],
		];

		$data['most_active'] = DB::table('newsletter_users')
		->select('id', 'email', 'hits')
		->where('hits', '>', 5)
		->orderBy('hits', 'DESC')
		->limit(25)
		->get();

		$bases = DB::table('newsletter_bases')->get();
		foreach ($bases as &$base) {
			$base->is_mark = false;
		}
		$data['bases'] = $bases;

		$data['letters'] = DB::table('newsletter_templates')->get();

		$data['queue'] = DB::table('newsletter_queue')->count();

		return response()->json($data);
	}

	public function add () {

		$ids = request()->get('ids');
		$letter = request()->get('letter');
		if (empty($ids) || empty($letter))
			return 0;

		$users = DB::table('newsletter_users')
		->select('id')
		->whereIn('id_newsletter_bases', $ids)
		->where('is_unsubscribe', '0')
		->orderBy('id', 'ASC')
		->get();

		$template = DB::table('newsletter_templates')
		->where('id', $letter)
		->first();

		if (empty($template))
			return 0;

		$query = [];

		foreach ($users as $user) {
			$query[] = [
				'id_newsletter_users'		=> $user->id,
				'id_newsletter_templates'	=> $template->id,
			];
		}

		DB::table('newsletter_queue')->insert($query);

		return DB::table('newsletter_queue')->count();
	}

	public function rm () {

		DB::table('newsletter_queue')->truncate();

		return DB::table('newsletter_queue')->count();
	}

	public function letter_save () {

		$letter = request()->get('letter');

		DB::table('newsletter_templates')
		->where('id', $letter['id'])
		->update([
			'template'	=> $letter['template'],
		]);
	}

	public function letter_rm () {

		DB::table('newsletter_templates')
		->where('id', request()->get('id'))
		->delete();

		return DB::table('newsletter_templates')->get();
	}

	public function letter_add () {
		
		$subject = request()->get('subject');
		$date = request()->get('date');
		// $template = request()->get('template');

		DB::table('newsletter_templates')
		->insert([
			// 'template'	=> $template,
			'template'	=> '<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Letter</title>
</head>
<body style="font-family: Arial;">
  <div style="max-width: 700px; width: 100%; margin: 0 auto; padding: 35px 25px;">
  </div>
</body>
</html>',
			'subject'	=> $subject,
			'date'		=> $date,
		]);

		return DB::table('newsletter_templates')->get();
	}

	public function base_add () {

		$title = request()->get('title');
		$date = request()->get('date');
		$file = request()->file('file');

		if ($file->getClientOriginalExtension() != 'xlsx')
			return response('Error: incorrect extension. Only ".xlsx" aviable', 418);

		$last_base = DB::table('newsletter_bases')->select('id')->orderBy('id', 'DESC')->first();
		$id = 1;
		if (!empty($last_base))
			$id = $last_base->id + 1;

		DB::table('newsletter_bases')
		->insert([
			'id'	=> $id,
			'title'	=> $title,
			'date'	=> $date,
		]);

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($file);
		$sheet = $spreadsheet->getActiveSheet();

		$rows = $sheet->toArray();

		for ($i = 0, $count = count($rows); $i < $count; $i++) {

			if (!empty($rows[$i][0])) {
				
				$user = DB::table('newsletter_users')
				->select('id')
				->where('email', $rows[$i][0])
				->first();

				if (empty($user)) {

					DB::table('newsletter_users')
					->insert([
						'email'					=> $rows[$i][0],
						'is_unsubscribe'		=> 0,
						'data'					=> '',
						'hits'					=> 0,
						'send_count'			=> 0,
						'errors_count'			=> 0,
						'id_newsletter_bases'	=> $id,
					]);
				}
			}
		}

		return DB::table('newsletter_bases')->get();
	}

	public function base_rm () {

		$id = request()->get('id');

		DB::table('newsletter_users')
		->where('id_newsletter_bases', $id)
		->delete();

		DB::table('newsletter_bases')
		->where('id', $id)
		->delete();

		return DB::table('newsletter_bases')->get();
	}

	public function base_download () {

		$id = request()->get('id');
		$password = request()->get('password');
		$secret = \App\FastAdminPanel\Helpers\FAPOptions::$secret_phrase;
		$filename = md5($secret);

		if (\App\FastAdminPanel\Helpers\FAPOptions::$password != $password)
			return response('Error: invalid password', 418);

		$users = DB::table('newsletter_users')
		->select('email')
		->where('id_newsletter_bases', $id)
		->get();

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load(
			public_path('vendor/fastadminpanel/example.xlsx')
		);
		$sheet = $spreadsheet->getActiveSheet();

		for ($i = 0, $count = count($users); $i < $count; $i++) { 
			$sheet->setCellValue('A'.($i + 1), $users[$i]->email);
		}

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save(public_path('vendor/fastadminpanel/'.$filename.'.xlsx'));

		return '/vendor/fastadminpanel/'.$filename.'.xlsx';
	}

	public function unsubscribe () {

		if (!isset($_GET['id']) && !isset($_GET['_id']))
			die();

		$secret = \App\FastAdminPanel\Helpers\FAPOptions::$secret_phrase;

		if (md5($_GET['id'].$secret.$_GET['id']) == $_GET['_id']) {

			DB::statement("UPDATE `newsletter_users` SET `is_unsubscribe`=1 WHERE id=".intval($_GET['id']));

			echo 'Вы успешно отписались от email рассылки! Если у вас есть предложения или вопросы - звоните по номеру +380953308060 (viber, whatsapp, telegram).<br>You have been successfully unsubscribed! If you have any questions, please contacts us: +380953308060 (viber, whatsapp, telegram).';
		}
	}

	public function hit () {

		if (!isset($_GET['id']) && !isset($_GET['_id']))
			die();

		$secret = \App\FastAdminPanel\Helpers\FAPOptions::$secret_phrase;

		if (md5($_GET['id'].$secret.$_GET['id']) == $_GET['_id']) {

			$user = DB::selectOne("SELECT * FROM `newsletter_users` WHERE id=".intval($_GET['id']));
			$user->hits++;

			DB::statement("UPDATE `newsletter_users` SET `hits`={$user->hits} WHERE id=".intval($_GET['id']));
		}
	}
}
<?php

namespace Digiants\FastAdminPanel\Commands;

use Digiants\FastAdminPanel\Helpers\Single;
use App\User;
use Illuminate\Console\Command;
use Schema;
use DB;

class NewsletterSend extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'newsletter:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send one letter from queue (table: newsletter_queue).';

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
		
		$curr = DB::table('newsletter_queue')
		->select(
			'newsletter_queue.id',
			'newsletter_templates.template',
			'newsletter_templates.subject',
			'newsletter_users.id AS user_id',
			'newsletter_users.email',
			'newsletter_users.data',
			'newsletter_users.hits',
			'newsletter_users.send_count',
			'newsletter_users.errors_count'
		)->join('newsletter_users', 'newsletter_queue.id_newsletter_users', 'newsletter_users.id')
		->join('newsletter_templates', 'newsletter_queue.id_newsletter_templates', 'newsletter_templates.id')
		->limit(1)
		->first();

		if (empty($curr))
			return;

		DB::statement("DELETE FROM newsletter_queue WHERE id={$curr->id}");

		if (mail(
			$curr->email,
			(empty($curr->subject)) ? '' : $curr->subject,
			$this->handle_template($curr->template, $curr->data, $curr->user_id),
			'From: Eva Miller <hello@digiants.agency>' . "\r\n" .
			"Content-type: text/html; charset=\"utf-8\""
		)) {

			$curr->send_count++;
			DB::statement("UPDATE `newsletter_users` SET `send_count`={$curr->send_count} WHERE id={$curr->user_id}");

		} else {

			$curr->errors_count++;
			DB::statement("UPDATE `newsletter_users` SET `errors_count`={$curr->errors_count} WHERE id={$curr->user_id}");
		}
	}

	private function get_variables ($data) {

		if (empty($data))
			return (object)[];

		$vals = [];

		$val_pairs = explode('
', $data);

		foreach ($val_pairs as $val_pair) {
			$temp = explode(': ', $val_pair);
			$vals[$temp[0]] = $temp[1];
		}

		return (object)$vals;
	}

	private function handle_template ($template, $data, $user_id) {

		$variables = $this->get_variables($data);

		foreach ($variables as $key => $val) {

			// remove new line
			$symbol = substr($val, strlen($val) - 1, strlen($val));
			if (ord($symbol) == 13) {
				$val = substr($val, 0, strlen($val) - 1);
			}

			// set variables
			$template = str_replace("{{{$key}}}", $val, $template);
		}

		$secret = \Digiants\FastAdminPanel\Helpers\FAPOptions::$secret_phrase;

		$template = str_replace("{{unsubscribe}}", url('/')."/admin/newsletter/unsubscribe?id=$user_id&_id=".md5($user_id.$secret.$user_id), $template);

		$template = str_replace('</body>', '<img width="1" height="1" src="'.url('/').'/admin/newsletter/hit?id='.$user_id.'&_id='.md5($user_id.$secret.$user_id).'"></body>', $template);

		return $template;
	}
}
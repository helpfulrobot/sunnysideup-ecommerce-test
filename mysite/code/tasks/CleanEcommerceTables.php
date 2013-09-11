<?php


class CleanEcommerceTables extends BuildTask {

	protected $title = 'Delete Database';

	protected $description = "WARNING! Deletes ALL tables in the database";

	public function run($request) {
		if(!Permission::check("ADMIN") && ! Director::isDev()) {
			Security::permissionFailure($this, _t('Security.PERMFAILURE',' This page is secured and you need administrator rights to access it. Enter your credentials below and we will send you right along.'));
		}
		$rows = DB::query("SHOW TABLES");
		foreach($rows as $tableArray) {
			$table = array_shift($tableArray);
			DB::query("TRUNCATE TABLE \"".$table."\";");
			DB::alteration_message("deleting ".$table, "deleted");
		}
		echo "<hr /><hr /><hr /><hr /><hr /><a href=\"/dev/build\">build database</a>
		<script type=\"text/javascript\">window.location = \"/dev/build/?flush=1&returnURL=/dev/tasks/DefaultRecordsForEcommerce\";</script>"
		;
	}



}

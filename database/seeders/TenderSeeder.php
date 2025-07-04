<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Tender;
use Carbon\Carbon;

class TenderSeeder extends Seeder
{
	public function run(): void
	{
		$path = base_path('database/data/tenders.csv');
		if ( !file_exists($path) ) {
		   throw new \Exception('CSV file not found');
		}

		$file = fopen($path, 'r');
		$header = fgetcsv($file, null, ',');
		while ( true ) {
			$row = fgetcsv($file, null, ',');

			if ( !$row ) {
				break;
			}

			// В csv файле иногда встречаются лишние ковычки 
			$external_code = trim($row[0], '"');
			$number = trim($row[1], '"');
			$status = trim($row[2], '"');
			$name = trim($row[3], '"');
			$change_date = Carbon::createFromFormat('d.m.Y H:i:s', $row[4]);

			Tender::create([
				'external_code' => $row[0],
				'number' => $row[1],
				'status' => $row[2],
				'name' => $row[3],
				'change_date' => $change_date
			]);
		}

		fclose($file);
	}
}

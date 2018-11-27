# Data to Laravel seeders
This utility allows you to convert CSV and JSON files to Laravel seeders.

## Usage
Create ```./files``` and ```./output``` folders in project root.  
Put the files you want to convert in ```./files``` folder.  
Run ```convert.php``` script and follow the instructions.

### Usage example
```
$ php convert.php
$ Enter the laravel version (5.7): 5.6
$
$ Create seeder for the file lello_fresh.csv
$ Enter the seeder class name: LelloFreshSeeder
$ Enter the connection name (default) :
$ Enter the seeder table name: lello_fresh
$ ./output/LelloFreshSeeder.php file created

```

Input file:
```
id,name,parent_id,created_at,updated_at
1,lello,1,2018-10-02 10:15:02,2018-10-02 10:15:02
1,fresh,1,2018-10-03 08:11:45,2018-10-03 08:11:45
```

Output file:
```
<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LelloFreshSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('lello_fresh')->insert([
			'id' => '1',
			'name' => 'stefano',
			'parent_id' => '1',
			'created_at' => '2018-10-02 10:15:02',
			'updated_at' => '2018-10-02 10:15:02',
		]);

		DB::table('lello_fresh')->insert([
			'id' => '1',
			'name' => 'marco',
			'parent_id' => '1',
			'created_at' => '2018-10-03 08:11:45',
			'updated_at' => '2018-10-03 08:11:45',
		]);

	}
}
```


## Supported Laravel versions 
From **5.1** to **5.7** 


###### Feel free to submit corrections or improvements.

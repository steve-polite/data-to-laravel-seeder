<?php

defined("TAB1") or define("TAB1", "\t");
defined("TAB2") or define("TAB2", "\t\t");
defined("TAB3") or define("TAB3", "\t\t\t");

/**
 * Convert CSV file to structured Array based on CSV header
 * @param $entry
 * @return array
 */
function csv_to_array($entry)
{
    $lines = file(FILES_DIRECTORY.$entry);
    $delimiter = null;
    $header = null;
    $parsed_csv_data = [];
    foreach ($lines as $line_num => $line) {

        // Define CSV header
        if($line_num === 0) {
            $header = explode(',', $line);
            $delimiter = ',';
            if(count($header) === 1) {
                $header = explode(';', $line);
                $delimiter = ';';
            }
        } else {
            // Create JSON structure
            if($delimiter !== null && $header !== null) {
                $parsed_csv_line = null;
                $fields = explode($delimiter, $line);
                foreach ($fields as $field_index => $field) {
                    foreach ($header as $header_index => $header_item) {
                        if($field_index == $header_index) {
                            $parsed_csv_line[trim($header_item)] = $field;
                            break;
                        }
                    }
                }
                if(!is_null($parsed_csv_line))
                    $parsed_csv_data[] = $parsed_csv_line;
            }
        }
    }

    return $parsed_csv_data;
}


/**
 * Create init seeder script based on supported Laravel version (v5.7 fallback)
 *
 * @param $class_name
 * @param string $laravel_version
 * @return string
 */
function init_seeder_script($class_name, $laravel_version = "5.7")
{
    $init_script = "";
    switch($laravel_version) {

        default:
            $init_script .= "<?php".PHP_EOL.PHP_EOL.PHP_EOL;
            $init_script .= "use Illuminate\Database\Seeder;".PHP_EOL;
            $init_script .= "use Illuminate\Support\Facades\DB;".PHP_EOL.PHP_EOL.PHP_EOL;
            $init_script .= "class {$class_name} extends Seeder".PHP_EOL;
            $init_script .= "{".PHP_EOL;
            $init_script .= TAB1."/**".PHP_EOL;
            $init_script .= TAB1." * Run the database seeds.".PHP_EOL;
            $init_script .= TAB1." *".PHP_EOL;
            $init_script .= TAB1." * @return void".PHP_EOL;
            $init_script .= TAB1." */".PHP_EOL;
            $init_script .= TAB1."public function run()".PHP_EOL;
            $init_script .= TAB1."{".PHP_EOL;
            break;

    }

    return $init_script;
}


/**
 * Create close seeder script based on supported Laravel version (v5.7 fallback)
 *
 * @param string $laravel_version
 * @return string
 */
function close_seeder_script($laravel_version = "5.7")
{
    $close_script = "";
    switch ($laravel_version) {

        default:
            $close_script .= TAB1."}".PHP_EOL; // Close run()
            $close_script .= "}".PHP_EOL; // Close seeder class
            break;

    }

    return $close_script;
}


/**
 * Create seeder snippet
 *
 * @param $data
 * @param $table_name
 * @param string $connection_name
 * @param string $laravel_version
 * @return string
 */
function create_seeder_entry($data, $table_name, $connection_name = "", $laravel_version = "5.7")
{
    $seed_script = "";
    switch($laravel_version) {

        default:

            if($connection_name !== "" && $connection_name !== "default") {
                $seed_script .= TAB2."DB::connection('{$connection_name}')->table('{$table_name}')->insert([".PHP_EOL;
            } else {
                $seed_script .= TAB2."DB::table('{$table_name}')->insert([".PHP_EOL;
            }

            foreach($data as $field_name => $field_value) {
                $seed_script .= TAB3."'{$field_name}' => '".addslashes(trim($field_value, PHP_EOL))."',".PHP_EOL;
            }

            $seed_script .= TAB2."]);".PHP_EOL.PHP_EOL;

            break;

    }

    return $seed_script;
}
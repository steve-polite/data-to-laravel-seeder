<?php

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
            $close_script .= "}".PHP_EOL;
            break;

    }

    return $close_script;
}
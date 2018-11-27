<?php

const DEFAULT_LARAVEL_VERSION = "5.7";
const FILES_DIRECTORY = './files/';
const OUTPUT_DIRECTORY = './output/';
const ALLOWED_FILES_EXTENSIONS = ['csv', 'json'];

include_once './functions.php';

if(!is_dir(FILES_DIRECTORY) || !is_dir(OUTPUT_DIRECTORY))
    die("Check if folders ./files and ./output exists in your project root.".PHP_EOL);

$laravel_version = readline('Enter the laravel version (5.7): ');
$laravel_version = trim($laravel_version) === "" ? DEFAULT_LARAVEL_VERSION : $laravel_version;

if($handle = opendir(FILES_DIRECTORY)) {
    while(($entry = readdir($handle)) !== false) {
        $parsed_data = null;
        if($entry != "." && $entry != ".." && $entry != ".DS_Store") {

            // Check file extension and parse data
            $file_extension = pathinfo($entry, PATHINFO_EXTENSION);
            if(in_array($file_extension, ALLOWED_FILES_EXTENSIONS)) {

                switch($file_extension) {
                    case "csv":
                        try {
                            $parsed_data = csv_to_array($entry);
                        } catch(Exception $e) {
                            $parsed_data = null;
                            echo "Error while parsing CSV file (".FILES_DIRECTORY.$entry.").".PHP_EOL;
                            echo "Error: ".$e->getMessage().PHP_EOL;
                            echo "-------------------------------------".PHP_EOL;
                        }
                        break;

                    case "json":
                        try {
                            $file_content = file_get_contents(FILES_DIRECTORY . $entry);
                            $parsed_data = json_decode($file_content, true);
                        } catch (Exception $e) {
                            $parsed_data = null;
                            echo "Error while parsing JSON file (".FILES_DIRECTORY.$entry.").".PHP_EOL;
                            echo "-------------------------------------".PHP_EOL;
                        }
                        break;
                }

                // Start to create seeder
                if($parsed_data !== null) {

                    echo PHP_EOL."Create seeder for the file ".$entry.PHP_EOL;
                    // Get seeder info
                    $class_name = "";
                    $connection_name = "";
                    $table_name = "";

                    while(trim($class_name) == "")
                        $class_name = readline("Enter the seeder class name: ");

                    $connection_name = readline("Enter the connection name (default) : ");
                    $connection_name = trim($connection_name) === "" ? "default" : $connection_name;

                    while(trim($table_name) == "")
                        $table_name = readline("Enter the seeder table name: ");

                    $script = init_seeder_script($class_name, $laravel_version);

                    foreach($parsed_data as $seeder_row) {
                        $script .= create_seeder_entry($seeder_row, $table_name, $connection_name, $laravel_version);
                    }

                    $script .= close_seeder_script($laravel_version);

                    file_put_contents(OUTPUT_DIRECTORY.$class_name.".php", $script);

                    echo OUTPUT_DIRECTORY.$class_name.".php file created".PHP_EOL;

                }

            } else {
                echo "The file $entry does not have an allowed extension.".PHP_EOL;
            }
        }
    }
} else {
    echo "Can not open the ./files dir".PHP_EOL;
}






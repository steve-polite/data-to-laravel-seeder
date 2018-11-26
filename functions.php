<?php

function csv_to_array($entry) {
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
<?php

return [
    'description' => 'Encrypt one or more columns in a database table and export the encrypted data to a CSV file.',
    'q_table_name' => 'What is the name of the table?',
    'q_columns' => 'Which columns would you like to encrypt? (separate multiple columns with a comma or space)',
    'column_list' => 'The columns in the :table table are: ',
    'invalid_column' => 'You have enetered one or more invalid column index.',
    'q_export_path' => 'Where would you like to export the encrypted data? (leave blank for the proejct root directory)',
    'not_valid_dir' => 'The export path :path is not a valid directory.',
    'not_writable' => 'The export path :path is not writable.',
    'exported' => 'The encrypted data has been exported to :path',
];

<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once 'vendor/autoload.php';

use Flask\Flask;
use Flask\Request;
use Flask\Response;
use Flask\render_template;

$app = new Flask(__name__);

// Function to calculate last column average from Excel file using Pandas
function calculate_last_column_average($excel_file) {
    // Read Excel file
    $reader = IOFactory::createReader('Xlsx');
    $spreadsheet = $reader->load($excel_file);
    $sheet = $spreadsheet->getActiveSheet();
    
    $lastColumn = $sheet->getHighestColumn();
    $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
    
    $last_column_data = $sheet->rangeToArray('A2:' . $lastColumn . '2')[0];
    $total = 0;
    $count = 0;
    foreach ($last_column_data as $value) {
        $total += intval($value);
        $count++;
    }
    if ($count > 0) {
        $average = $total / $count;
    } else {
        $average = 0;
    }
    return $average;
}

// Function to convert average rating to stars
function convert_to_stars($average_rating) {
    $num_stars = round($average_rating);
    $stars = str_repeat('⭐', $num_stars);
    return $stars;
}

$app->route('/', function () {
    return render_template('index2.html');
});

$app->route('/execute_code', function (Request $request) {
    $python_path = 'python3';
    $python_script_path = 'patient\cl.py';

    $output = shell_exec("$python_path $python_script_path");

    return display_last_column_average();
})->method('POST');

$app->route('/average_last_column', function () use ($app) {
    // Paths to the Excel files for each doctor
    $doctor1_excel_file_path = "dry/Doc1.xlsx";
    $doctor2_excel_file_path = "dry/Doc2.xlsx";
    $doctor3_excel_file_path = "dry/Doc3.xlsx";
    $doctor4_excel_file_path = "dry/Doc4.xlsx";
    $doctor5_excel_file_path = "dry/Doc5.xlsx";
    $doctor6_excel_file_path = "dry/Doc6.xlsx";
    $doctor7_excel_file_path = "dry/Doc7.xlsx";
    $doctor8_excel_file_path = "dry/Doc8.xlsx";
    $doctor9_excel_file_path = "dry/Doc9.xlsx";

    // Calculate average of last column for each doctor
    $last_column_average_1 = calculate_last_column_average($doctor1_excel_file_path);
    $stars_1 = convert_to_stars($last_column_average_1);

    $last_column_average_2 = calculate_last_column_average($doctor2_excel_file_path);
    $stars_2 = convert_to_stars($last_column_average_2);

    $last_column_average_3 = calculate_last_column_average($doctor3_excel_file_path);
    $stars_3 = convert_to_stars($last_column_average_3);

    $last_column_average_4 = calculate_last_column_average($doctor4_excel_file_path);
    $stars_4 = convert_to_stars($last_column_average_4);

    $last_column_average_5 = calculate_last_column_average($doctor5_excel_file_path);
    $stars_5 = convert_to_stars($last_column_average_5);

    $last_column_average_6 = calculate_last_column_average($doctor6_excel_file_path);
    $stars_6 = convert_to_stars($last_column_average_6);

    $last_column_average_7 = calculate_last_column_average($doctor7_excel_file_path);
    $stars_7 = convert_to_stars($last_column_average_7);

    $last_column_average_8 = calculate_last_column_average($doctor8_excel_file_path);
    $stars_8 = convert_to_stars($last_column_average_8);

    $last_column_average_9 = calculate_last_column_average($doctor9_excel_file_path);
    $stars_9 = convert_to_stars($last_column_average_9);

    return render_template('index2.html', [
        'last_column_average_1' => $last_column_average_1,
        'display_star_1' => $stars_1,
        'last_column_average_2' => $last_column_average_2,
        'display_star_2' => $stars_2,
        'last_column_average_3' => $last_column_average_3,
        'display_star_3' => $stars_3,
        'last_column_average_4' => $last_column_average_4,
        'display_star_4' => $stars_4,
        'last_column_average_5' => $last_column_average_5,
        'display_star_5' => $stars_5,
        'last_column_average_6' => $last_column_average_6,
        'display_star_6' => $stars_6,
        'last_column_average_7' => $last_column_average_7,
        'display_star_7' => $stars_7,
        'last_column_average_8' => $last_column_average_8,
        'display_star_8' => $stars_8,
        'last_column_average_9' => $last_column_average_9,
        'display_star_9' => $stars_9
    ]);
});


$app->run();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Directory</title>
    <style>
        /* Basic CSS for layout and styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eff2f7;
            font-family: Verdana, Helvetica, sans-serif;
        }
        .container {
            max-width: 1350px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .doctor {
            width: calc(45.33% - 5px); /* Adjusted width to accommodate margin */
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            display: flex; /* Display as flex container */
        }
        .doctor:nth-child(3n) {
            margin-right: 0; /* No margin for every third doctor */
        }
        .doctor img {
            max-width: 40%;
            border-radius: 8px;
            margin-right: 20px;
            
        }
        .doctor-details {
            flex-grow: 1;
            color: #333;
        }
        .doctor-details p {
            margin: 5px 0;
        }
        .book-button, .rating-button {
            background-color: #3f5981;
            color: #fff;
            border: none;
            padding: 10px 10px;
            border-radius: 5px;
            cursor: pointer;
            align-self: flex-end; /* Align button to the bottom of the container */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Doctor 1 -->
        <div class="doctor">
            <img src="doctor1.jpg" alt="Doctor 1">
            <div class="doctor-details">
                <h2>Doctor 1</h2>
                <p>Average Rating: <?php echo $last_column_average_1; ?></p>
                <p>Rating: <?php echo $display_star_1; ?></p>
                <button class="book-button">Book Appointment</button>
                <button class="rating-button">Rate Doctor</button>
            </div>
        </div>
        <!-- Doctor 2 -->
        <div class="doctor">
            <img src="doctor2.jpg" alt="Doctor 2">
            <div class="doctor-details">
                <h2>Doctor 2</h2>
                <p>Average Rating: <?php echo $last_column_average_2; ?></p>
                <p>Rating: <?php echo $display_star_2; ?></p>
                <button class="book-button">Book Appointment</button>
                <button class="rating-button">Rate Doctor</button>
            </div>
        </div>
        <!-- Repeat the above structure for other doctors -->
        <!-- Doctor 3 -->
        <div class="doctor">
            <img src="doctor3.jpg" alt="Doctor 3">
            <div class="doctor-details">
                <h2>Doctor 3</h2>
                <p>Average Rating: <?php echo $last_column_average_3; ?></p>
                <p>Rating: <?php echo $display_star_3; ?></p>
                <button class="book-button">Book Appointment</button>
                <button class="rating-button">Rate Doctor</button>
            </div>
        </div>
        <!-- Doctor 4 -->
        <div class="doctor">
            <img src="doctor4.jpg" alt="Doctor 4">
            <div class="doctor-details">
                <h2>Doctor 4</h2>
                <p>Average Rating: <?php echo $last_column_average_4; ?></p>
                <p>Rating: <?php echo $display_star_4; ?></p>
                <button class="book-button">Book Appointment</button>
                <button class="rating-button">Rate Doctor</button>
            </div>
        </div>
        <!-- Repeat the above structure for other doctors -->
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Display and Upload CSV to OpenEMR</title>
</head>
<body>
    <h1>Display and Upload CSV File to OpenEMR</h1>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <input type="submit" name="display" value="Display CSV Data">
    </form>

    <?php
    if (isset($_POST['display'])) {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $file_name = $_FILES['csv_file']['name'];
            $file_tmp = $_FILES['csv_file']['tmp_name'];

            if (strtolower(pathinfo($file_name, PATHINFO_EXTENSION)) == 'csv') {
                $file = fopen($file_tmp, 'r');

                echo '<h2>CSV Data:</h2>';
                echo '<div style="height:40vh;overflow:scroll"><table border="1">';
                while (($data = fgetcsv($file)) !== false) {
                    echo '<tr>';
                    foreach ($data as $cell) {
                        echo '<td>' . htmlspecialchars($cell) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table></div>';

                fclose($file);

                echo '<form action="upload-csv.php" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" name="csv_data" value="' . base64_encode(file_get_contents($file_tmp)) . '">';
                echo '<input type="submit" name="upload" value="Upload to OpenEMR">';
                echo '</form>';
            } else {
                echo '<p>Error: The uploaded file is not a CSV.</p>';
            }
        } else {
            echo '<p>Error: Please upload a CSV file.</p>';
        }
    }
    ?>
</body>
</html>

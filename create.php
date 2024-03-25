<?php
// Include config file (assuming you have already done this)
require_once "config.php";

// Define variables and initialize with empty values
$name = $date = $location = "";
$name_err = $date_err = $location_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $input_name)) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate date
    $input_date = trim($_POST["date"]);
    if (empty($input_date)) {
        $date_err = "Please enter a date.";
    } else {
        $date = $input_date;
    }

    // Validate location
    $input_location = trim($_POST["location"]);
    if (empty($input_location)) {
        $location_err = "Please enter the location of the event.";
    } else {
        $location = $input_location;
    }

    // Check input errors before inserting into the database
    if (empty($name_err) && empty($date_err) && empty($location_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO events (name, date, location) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_date, $param_location);

            // Set parameters
            $param_name = $name;
            $param_date = $date;
            $param_location = $location;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to the landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                // You can also log the error for debugging purposes
                // error_log(mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link); // Close the database connection
}
?>
<!-- Your HTML form goes here -->

Bincom PHP Test Project

A PHP and MySQL implementation of the Bincom technical test.

Features

This project implements the following:

1. Polling Unit Results

Allows a user to enter a polling unit number and view the election results for that polling unit.

File: polling_unit_result.php

2. LGA Results

Allows a user to enter an LGA ID and view the total result for each political party across all polling units within that LGA.

File: lga_results.php

3. Add New Polling Unit

Allows a user to add a new polling unit and enter its party results.

File: add_polling_unit.php

Technologies Used
PHP
MySQL
HTML
CSS
XAMPP
phpMyAdmin
Database Setup
Create a MySQL database named bincomphptest.
Import the provided SQL file bincom_test.sql.
Make sure XAMPP Apache and MySQL are running.
Database Connection

The database connection is configured in backend/database.php.

Example local configuration:

$conn = new mysqli("localhost", "root", "", "bincomphptest");

Update the database credentials if necessary.

Running the Project

Place the project folder inside the XAMPP htdocs directory.

Example:

C:\xampp\htdocs\bincom-test

Then open the following pages in your browser:

Polling Unit Results

http://localhost/bincom-test/polling_unit_result.php

LGA Results

http://localhost/bincom-test/lga_results.php

Add Polling Unit

http://localhost/bincom-test/add_polling_unit.php

Database Relationships

The project uses the relationship between:

polling_unit
announced_pu_results

The uniqueid column in polling_unit is linked to polling_unit_uniqueid in announced_pu_results.

This relationship is used to retrieve the election results belonging to a specific polling unit.

Author

Chiemeka Evans

GitHub: https://github.com/SwitzerEvans

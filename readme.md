# Introduction
A Book Library JSON API with which a librarian can manage the record of books in a library.
A librarian can by use of this API lend out books to Students/Teachers, Receive Books back that where giving out.
A librarian can also see a list of available books along with their current stock quantity.
He can add new books to the library as well

# Overview
The API was built using PHP, and Composer is needed for dependency management. So it requires you to have composer installed on your machine.
To set up the project
Copy the project to a location on your machine accessible by your local server.
Create a database, and edit the Database Configuration located in api/configs/Database.php
Next create the tables and populate it with some dummy values, the queries can be found in setup/raw_queries.sql
Next install composer from withinn the api directory by running
```
composer install
```


# Authentication
No Authentication mechanism was built for this project

# Error Codes
Expected error codes include 404 and 503

# Rate limit
There is no rate limmiting employed in use of this API

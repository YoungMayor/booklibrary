# Introduction
A Book Library JSON API with which a librarian can manage the record of books in a library.
A librarian can by use of this API lend out books to Students/Teachers, Receive Books back that where giving out.
A librarian can also see a list of available books along with their current stock quantity.
He can add new books to the library as well

# Overview
The API was built using PHP, and Composer is needed for dependency management. So it requires you to have composer installed on your machine.


# Setup
To set up the project
Copy the project to a location on your machine accessible by your local server.
Edit your configurations located in api/config/configs.php
If you cant find the configs file, copy and rename api/config/configs.example.php to api/config/configs.php
On windows you can easily do this by running
```
composer set_winfig
```
Create a database
Next create the tables and populate it with some dummy values, the queries can be found in setup/raw_queries.sql
Then install composer from withinn the api directory by running
```
composer install
```


# Authentication
No Authentication mechanism was built for this project

# Error Codes
Expected error codes include 404 and 503
The following error codes would be returned dependant on the service failure received;

LND-102 - A book could not be lended out (it exists and is in stock) or it was lent out but the stock failed to be reduced.

LND-103 - Lending process could not be started, the book exist, the user exist as well, and there is another error.

RET-102 - A book could not be returned or it was returned but the stock for that book did not increase

RET-103 - Return of a book failed to execute and the reason is unknown


NB: These errors are not ever supposed to occur. And it never occurred in production and testing, so debugging could not be made on them. However, it was neccessary to make appropriate preparations for them to avoid a system collapse

# Testing
To run tests on the project, navigate to the api folder where composer was installed.
Run
```
composer run_tests
```
The Tests require you to have accurately editted your configs.php as well as create the database and tables.
Refer to Setup section above.


# Rate limit
There is no rate limmiting employed in use of this API

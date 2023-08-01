# Structure
This document details the file structure of the website.

## Main Folders
- app => The actual code for the website
- config (excluded) => Any config files, for example, connecting to the database.
- tests 
    cypress => Frontend tests using [Cypress](https://www.cypress.io/), written using JS.
    unittests
- docs => Documentation for the website

## /app
The website uses MVC architecture.

### Controllers
Each file's job relates to a single page or action on the website. For example, [fullStatement.php](../app/controllers/fullStatement.php) is for the full page of a statement. Here users can see the text content of the statement, comments, votes ratio, etc. Another example is [logout.php](../app/controllers/logout.php) whose only job is to destroy the user's session.

### Models
Each file relates to a table in the MySQL database or ways to check/change data. For example [accounts.php](../app/models/accounts.php) has methods related to the users table. Another example is [signUpChecks.php](../app/models/signupChecks.php) that contains methods for ensuring the sign up info inputted by the user follows certain rules.

### Views
Each .pug file is a single page, except for [base.pug](../app/views/base.pug) which is the "base" file for all views. All other .pug files extend off of this layout. The [base.pug](../app/views/base.pug) file contains stylesheets required, scripts, fonts, etc.

### Scripts
Contains all .js files.

### Assets
Contains images for the website.

### [index.php](../app/index.php)
All requests are sent to this file which are handled using the [PHRoute](https://github.com/mrjgreen/phroute) library.

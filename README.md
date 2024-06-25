# General

This project is a comprehensive web application designed to manage and share recipes among a group of users. The application offers secure user authentication, a dynamic interface for recipe management, and various functionalities to enhance user interaction. It allows users to register, log in, create, view, and share recipes with other users.
- The code assumes that the app runs in the "/" root (or change it in config.php)


# Technologies
- PHP: Backend scripting language used for server-side logic.
- HTML/CSS: Frontend technologies for structuring and styling the web pages.
- MySQL: Database management system used to store user and recipe information.
- JavaScript: For adding interactivity and enhancing user experience.
- Apache/Nginx: Web server to serve the application.
- Bootstrap: CSS framework for responsive design and UI components.

## Features
- User Registration and Authentication:
  Secure registration with email verification.
  Login with "remember me" functionality using cookies.
  Password reset feature via email.
- Recipe Management:
  Create, read, update, and delete recipes.
  View recipes in a structured table format.
  Search and sort recipes by name or date.
- Recipe Sharing:
  Share recipes with other registered users.
  Manage shared recipes and permissions.
- Responsive Design:
  Fully responsive interface for optimal viewing on different devices.
- Interactive Features:
  Mark ingredients and steps as completed.
  Modal pop-ups for sharing recipes and other interactions.
- Admin Panel:
  Manage users and their access to recipes.
  View and control shared recipes.


# Setup

Change the config in includes/config.php

```

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'phpproject01');

define('BASE_URL', '/'); //Change this to point at the root URL path

```

# User

email: test@test.com
password: 123

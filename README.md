# eTasksDemo

A small web application which allows the end-user to do the following:
•	Display a list of tasks
•	Allow the user to create new task items
•	Allow users to edit task details
•	Allow the user to remove task items
•	Allow the user to mark a task as completed
•	Store data as JSON
•	Load JSON data upon initialization

# Implementation
The main technologies used for implementing this application included the PHP framework Codeigniter, Javascript/JQuery, HTML and CSS. 

The UI Design was implemented using Bootstrap and starts with a home/landing page. The structure is simple with a navigational menu with “HOME” and “TASKS” links. 

Clicking on the “TASKS” link takes you to the Tasks Page displaying a list of available tasks. 

To add tasks, simply click on the “Add Task” button on the top left of the page and a pop-up box / modal comes up with an entry form. To view, edit, remove or mark as completed, simply click on the corresponding button on the item row you want to view or modify.
New entries and modifications are updated in the back-end json file using PHP and AJAX.

# Data Management
The data is currently stored in a json file located in the uploads folder. 

Storing the data via server-side technologies can easily be implemented by creating a mysql database and creating a table to store the data. By default this application has a Tasks model already setup with a “tasks” table.

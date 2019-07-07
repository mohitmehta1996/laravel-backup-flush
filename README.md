# laravel-backup-flush

Note*: Please don't use this code to harm any people/project.

This code will help you to take backup of Laravel files/database very easily without FTP/Database access. You just need to upload this files once in a project.

This code will also help you to delete/flush whole project with database incase if client refuses to pay for your work.

# How to create backup of Database and Files

1. Upload this file to public folder of Laravel. Now you can run this file directly from URl. For example, www.your-domain.com/lara-enc.php

2. When you run this file, first it will create database backup as "GZ" file and place it in public folder.

3. Then it will create "ZIP" file of enitre project (which also includes database backup file) in public directory.

4. It will also force download the final ZIP file of backup otherwise you can get it from www.your-domain.com/project.zip

# How to flush entire project

Note*: Make sure you have backup of your database/files before running below steps.

1. Run below URL "www.your-domain.com/lara-enc.php?key=123456". Here we are running same file with additional URL parameter "key". 

2. After running above URL, this code will delete entire Laravel projects and also will delete all tables from database. It will also delete "lara-enc.php" file.
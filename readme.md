<h2>Test Driven Development</h2>

1. Let's begin by writing a test in terminal:

```php artisan make:test ProjectsTest```
<p>There will be a ProjectsTest.php will be created in tests > Feature dir </p>
2. Write some code in the file to test.<br />
3. Run the following command in the terminal:

```vendor/bin/phpunit tests/Feature/ProjectsTest.php```

It should be fail mentioning that base table doesn't exist


<h3>Configuration of sqlite db so that we do not write data into the actual db</h3>

1. Open the phpunit.xml file and inside the ```<php>``` tag add the following:
```
<server name="DB_CONNECTION" value="sqlite"/>
<server name="DB_DATABASE" value=":memory:"/>
```
2. Run the test again, it will be same error but not in the mysql we are writing into the sqlite DB
3. Let's create a migration now to get rid off the error
```php artisan make:migration create_projects_table```
4. If we run the test again, this time the error woll be different
5. Let's fix the migration to get rid off this error

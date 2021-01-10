<h2>Test Driven Development</h2>

<h3>Part 1</h3>

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


<h3>Part 2 (Request Validation)</h3>

We will do some input validation here

add a function a_project_requires_a_title in the test file and add the following:
```php
    public function a_project_requires_a_title()
    {
        $this->post('/projects', [])->assertSessionHasErrors('title');
    }
```

which tells that if we post a request without a title field it should fail

To test a particular function we can use the following command:

```
vendor/bin/phpunit --filter a_project_requires_a_title
```
where a_project_requres_a_title is a user defined function and we can use it for input validation
 
Instead of typing the whole thing we can do some aliasing like:
```
alias pf="vendor/bin/phpunit --filter"
```
And then we can run our test like:
```bash
pf a_project_requires_a_title
```
This will fail as there is no validation in our store function. Let's add following code in the store function in the ProjectsController
```php
request()->validate(['title' => 'required']);
```
If we run the test it will pass. Let's replicate this for the rescription field.

Usually instead of using empty [] array we should use all the required field except the one we are testing

```$this->post('/projects', [])->assertSessionHasErrors('title') ```

Let's create the factory:

```
php artisan meke:factory ProjectFactory --model="App\Project"
```
then go to: database > factories > ProjectFactory.php and create the blue print and add the blue print for the project
```php
$factory->define(Project::class, function (Faker $faker) {
    return [
          'title' => $faker->sentence,
          'description' => $faker->paragraph
    ];
});
```
Fire up the tinker
```
php artisan tinker
```
The following command will create a Project and it will not persist in the database
```php
factory('App\Project')->make()
```
To persist in the database
```php
factory('App\Project')->create()
```
Not to persist in the database and get the project as array
```php
factory('App\Project')->raw()
```
No we will use this faker in our test as follows:
```php
public function a_project_requires_a_description()
{
    $attributes = factory('App\Project')->raw(['description' => '']);
    $this->post('/projects', $attributes)->assertSessionHasErrors('description');
}
```
Let's run the test
```pf  ProjectsTest```
It should be all green now!

<h3>Model Test</h3>

Let's say, we want to have a test for viewing a project
```php
/** @test */
public function a_user_can_view_a_project()
{
    $this->withoutExceptionHandling();
    $project = factory('App\Project')->create();
    $this->get('/projects/'.$project->id)->assertSee($project->title)->assertSee($project->description);
}
```
rerun the test and it should fail

Let's take care off the error message and create route.
In the above code we did string concatenation for the url which is bad practise.
So Let's create a unit test for the Project to test what it can do and also sort out the path problem.
```
php artisan make:test ProjectTest --unit
```
Write the first test case to see if the project has a path
```php
/** @test */
public function it_has_a_path()
{
    $project = factory('App\Project')->create();
    $this->assertEquals('/projects/' . $project->id, $project->path());

}
```
Run the test and it will fail. So on the Project model let's add the function path()
```php
public function path()
{
    return "/projects/$this->id";
}
```
also change the a_user_can_view_a_projct() like following:
```php
/** @test */
public function a_user_can_view_a_project()
{
    $this->withoutExceptionHandling();
    $project = factory('App\Project')->create();
    $this->get($project->path())
        ->assertSee($project->title)
        ->assertSee($project->description);
}
```

Let's add some dummy data
```
php artisan tinker
factory('App\Project', 5)->create();
```



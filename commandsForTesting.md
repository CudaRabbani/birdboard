Basic Test

```
$this->post('/projects', $attributes)->assertRedirect('/projects');
$this->assertDatabaseHas('projects', $attributes);
$this->get('/projects')->assertSee($attributes['title']);

$this->post('/projects', [])->assertSessionHasErrors();
```
Input Validation Test
```php
$attributes = factory('App\Project')->raw(['description' => '']);
$this->post('/projects', $attributes)->assertSessionHasErrors('description');
```
Model / Unit Testing
1. test a path:
```php
/** @test */
public function it_has_a_path()
{
    $project = factory('App\Project')->create();
    $this->assertEquals('/projects/' . $project->id, $project->path());
}
```
Create a user and logged in as
```php
$this->actingAs(factory('App\User')->create());
$this->post('/projects', $attributes)->assertRedirect('login');
```

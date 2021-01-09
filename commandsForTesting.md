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

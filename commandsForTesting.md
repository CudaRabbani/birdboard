```
$this->post('/projects', $attributes)->assertRedirect('/projects');
$this->assertDatabaseHas('projects', $attributes);
$this->get('/projects')->assertSee($attributes['title']);
```

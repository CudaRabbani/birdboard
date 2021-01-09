<!DOCTYPE html>
<html>
<head>
    <title>Testing</title>
</head>
<body>
    <h1>BirdBoard</h1>
    <ul>
        @foreach($projects as $project)
            <li>{{ $project->title  }}</li>
        @endforeach
    </ul>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Football Leagues</title>
</head>
<body>
<h1>Football Leagues</h1>
<ul>
    @foreach ($leagues['competitions'] as $league)
        <li>{{ $league['name'] }}</li>
    @endforeach
</ul>
</body>
</html>

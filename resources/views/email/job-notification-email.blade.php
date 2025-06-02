<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Notification Email</title>
</head>
<body>

<h1>Hello {{ $mailData['employer']->name }}</h1>
<p>Job Title: {{ $mailData['job']->title }}</p>

<p>Employee Details:</p>

<!-- kis emplyoee ne kis job par apply kiya hai vo notification se pata chalega and vo email through detail le sakta hai -->
<p>Name: {{ $mailData['user']->name }}</p>
<p>Email: {{ $mailData['user']->email }}</p>
<p>Mobile No: {{ $mailData['user']->mobile }}</p>
    
</body>
</html>
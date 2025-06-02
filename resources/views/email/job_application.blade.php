<!DOCTYPE html>
<html>

<head>
    <title>New Job Application</title>
</head>

<body>
    <h2>Hello {{ $employer->name }},</h2>
    <p>{{ $user->name }} has applied for the job: <strong>{{ $job->title }}</strong>.</p>
    <p>You can download the resume from the link below:</p>
    <a href="{{ asset('storage/' . $resumePath) }}" download>Download Resume</a>

    <p>Best Regards,</p>
    <p>{{ config('app.name') }}</p>
</body>

</html>

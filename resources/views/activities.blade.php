<!DOCTYPE html>
<html>
<head>
    <title>Extracted Activities</title>
</head>
<body>
    <h1>Extracted Activities</h1>
    <table>
        <thead>
            <tr>
                <th>Activity Type</th>
                <th>Flight Number</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
            <tr>
                <td>{{ $activity->activity_type }}</td>
                <td>{{ $activity->flight_number }}</td>
                <td>{{ $activity->start_time }}</td>
                <td>{{ $activity->end_time }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
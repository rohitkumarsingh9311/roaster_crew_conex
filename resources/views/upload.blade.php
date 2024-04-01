<!DOCTYPE html>
<html>
<head>
    <title>Upload Roster File</title>
</head>
<body>
    <h1>Upload Roster File</h1>
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="roster_file" accept=".pdf, .xlsx, .txt, .html, .ics">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
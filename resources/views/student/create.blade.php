<!DOCTYPE html>
<html>
<head>
    <title>Student Information Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-button:hover {
            background-color: #45a049;
        }
        .show-lists-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .show-lists-button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<a href="{{ route('student.index') }}" class="btn btn-primary show-lists-button">Show Student Information Lists</a>


<div class="container">

    <h2>Student Information</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('student.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" id="first_name" name="first_name" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" id="last_name" name="last_name" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="middle_name" class="form-label">Middle Name:</label>
            <input type="text" id="middle_name" name="middle_name" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="id_number" class="form-label">ID Number:</label>
            <input type="text" id="id_number" name="id_number" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="section" class="form-label">Section:</label>
            <input type="text" id="section" name="section" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="year_level" class="form-label">Year Level:</label>
            <input type="text" id="year_level" name="year_level" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Address:</label>
            <textarea id="address" name="address" class="form-input" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="student_image" class="form-label">Student Image:</label>
            <input type="file" id="student_image" name="student_image" class="form-input" accept="image/*">
        </div>

        <input type="submit" name="submit" value="Submit" class="form-button">
    </form>
</div>
</body>
</html>

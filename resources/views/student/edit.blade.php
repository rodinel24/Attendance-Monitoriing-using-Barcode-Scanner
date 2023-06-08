<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Student</h2>

        <form action="{{ route('student.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $student->first_name }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $student->last_name }}" required>
            </div>

            <div class="mb-3">
                <label for="middle_name" class="form-label">Middle Name:</label>
                <input type="text" id="middle_name" name="middle_name" class="form-control" value="{{ $student->middle_name }}" required>
            </div>

            <div class="mb-3">
                <label for="id_number" class="form-label">ID Number:</label>
                <input type="text" id="id_number" name="id_number" class="form-control" value="{{ $student->id_number }}" required>
            </div>

            <div class="mb-3">
                <label for="section" class="form-label">Section:</label>
                <input type="text" id="section" name="section" class="form-control" value="{{ $student->section }}" required>
            </div>

            <div class="mb-3">
                <label for="year_level" class="form-label">Year Level:</label>
                <input type="text" id="year_level" name="year_level" class="form-control" value="{{ $student->year_level }}" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ $student->address }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.5.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/FileSaver.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@5.2.0/dist/js/tableexport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/jsbarcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <style>
        /* Add your CSS styles here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .edit-btn, .delete-btn {
            display: inline-block;
            padding: 6px 10px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .edit-btn:hover, .delete-btn:hover {
            background-color: #45a049;
        }

        .create-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .create-button:hover {
            background-color: #0056b3;
        }

        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .search-input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
        }

        .search-button {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        #export-btn {
            margin-bottom: 10px;
        }

        .student-image {
            max-width: 100px;
            max-height: 100px;
        }
           .btn_home {
            display: inline-block;
            padding: 10px 20px;
            background-color: red;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            }

            .btn_home:hover {
            background-color: orange;
            }
    </style>
</head>
<body>
    @if(Auth::user()->role == 0)
    <h2>Student Information</h2>
    <a class="btn_home" href="{{url ('/')}}">Back To Home</a>

    <a href="{{ route('student.create') }}" class="create-button">Create</a>

    <form action="{{ route('student.index') }}" method="GET" class="search-form">
        <div class="search-container">
            <input type="text" name="search" placeholder="Search by ID number" class="search-input">
            <button type="submit" class="search-button">Search</button>
        </div>
    </form>

    <button id="export-btn" onclick="exportTableToExcel()">Export to Excel</button>

    <table id="student">
        <thead>
            <tr>
                 <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Middle Name</th>
                <th>ID Number</th>
                <th>Section</th>
                <th>Year Level</th>
                <th>Address</th>
                <th>Actions</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                 <td>
                     <img src="{{ asset('images/' . $student->student_image) }}" alt="Student Image" style="width: 100px; height: 100px;">
                </td>
                <td>{{ ucwords(strtolower($student->first_name)) }}</td>
                <td>{{ ucwords(strtolower($student->last_name)) }}</td>
                <td>{{ ucwords(strtolower($student->middle_name)) }}</td>
                <td>{{ strtoupper($student->id_number) }}</td>
                <td>{{ ucwords(strtolower($student->section)) }}</td>
                <td>{{ ucwords(strtolower($student->year_level)) }}</td>
                <td>{{ ucwords(strtolower($student->address)) }}</td>
                <td>
                    <a href="{{ route('student.update', $student->id) }}" class="edit-btn">Edit</a>

                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                    </form>
                </td>
                <td>
                    <button class="downloadButton" onclick="downloadBarcode({{ $student->id }}, '{{ $student->id_number }}')">Download</button>
                    <div class="barcodeImage" id="barcodeImage-{{ $student->id }}">
                        {!! $barcodeGenerator->getBarcode($student->id_number, $barcodeGenerator::TYPE_CODE_128) !!}
                    </div>
                </td>
               

            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <h2>Accumulated Data from Main Entrance</h2>
    <div class="scan-results">
    </div>

    <script>
        function exportTableToExcel() {
            // Get HTML table data
            var table = document.getElementById("student");
            var wb = XLSX.utils.table_to_book(table);

            // Save data to Excel file
            XLSX.writeFile(wb, "students_list.xlsx");
        };

        function downloadBarcode(studentId, idNumber) {
            // Get the barcode data based on the student's ID
            var barcodeData = document.getElementById("barcodeImage-" + studentId).innerHTML;

            // Create a temporary canvas element
            var canvas = document.createElement("canvas");
            canvas.width = 500; // Set the desired width of the barcode image
            canvas.height = 100; // Set the desired height of the barcode image

            // Convert SVG to PNG
            var image = new Image();
            image.onload = function() {
                canvas.getContext("2d").drawImage(image, 0, 0, canvas.width, canvas.height);

                // Create a temporary link element
                var link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = idNumber + ".png"; // Set the desired file name and extension

                // Programmatically trigger the download
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
            image.src = "data:image/svg+xml;charset=utf-8," + encodeURIComponent(barcodeData);
        }
    </script>
    @endif
</body>
</html>

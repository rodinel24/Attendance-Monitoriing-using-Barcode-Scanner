<!DOCTYPE html>
<html>
<head>
    <title>Scan Form</title>
    <style>
        .scan-form {
            width: 400px;
            margin: 0 auto;
        }

        .scan-form label {
            display: block;
            margin-bottom: 10px;
        }

        .scan-form input[type="text"] {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .scan-form button {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .scan-results {
            width: 100%;
            margin-top: 20px;
        }

        .scan-results table {
            width: 100%;
            border-collapse: collapse;
        }

        .scan-results table th,
        .scan-results table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .scan-results table th {
            background-color: #f2f2f2;
        }

        .scan-results table td.barcode {
            font-weight: bold;
        }

        .scan-results table td.date,
        .scan-results table td.time {
            font-style: italic;
            color: #777;
        }

        .scan-results table td.student-info {
            font-weight: bold;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    
@if(Auth::user()->role == 0)

    <div class="scan-form">
        <h1>Scan Form</h1>

        <form method="POST" action="/scan">
            @csrf

            <table>
                <thead>
                    <tr>
                        <th>Barcode</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="barcode" id="barcodeInput" placeholder="Scan barcode" autofocus>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit">Submit</button>
        </form>

        @if ($errors->any())
            <div class="error-message">{{ $errors->first('barcode') }}</div>
        @elseif (session('scan_success'))
            <div class="success-message">{{ session('scan_success') }}</div>
        @endif
    </div>

    <div class="scan-results">
<button onclick="printScanResults()">Print Scan Results</button>

    @include('scan-result', ['scans' => $scans])
    </div>

    <script>
    function printScanResults() {
        // Open a new window for printing
        var printWindow = window.open('', '_blank');

        // Build the HTML content to be printed
        var content = document.getElementById('scan-results').innerHTML;

        // Set the content of the new window
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print Scan Results</title></head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Print the new window
        printWindow.print();
    }
</script>
@endif
</body>
</html>

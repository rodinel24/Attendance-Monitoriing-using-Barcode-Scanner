<!DOCTYPE html>
<html>
<head>
    <title>Scan Form</title>
    <head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/FileSaver.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@5.2.0/dist/js/tableexport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/jsbarcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    </head>
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
        .btn_home {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            }

            .btn_home:hover {
            background-color: #0056b3;
            }
            .container {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.image-container img {
  width: 300px;
  height: 300px;
  margin-right:20px;
}

.text-container table {
  border-collapse: collapse;
}

.text-container th,
.text-container td {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: left;
}

.text-container th {
  font-weight: bold;
}

.text-container th:first-child,
.text-container td:first-child {
  width: 150px;
}
#current-date {
      font-size: 3em;
      font-weight: bold;
      text-align: center;
    }
#current-time {
      font-size: 3em;
      font-weight: bold;
      text-align: center;
    }
    


    </style>
</head>
<body>
<a class="btn_home" href="{{url ('/')}}">Back To Home</a>
    
<div id="current-date"></div>
<div id="current-time"></div>



    <div class="scan-form">
        <h2>Mindanao State University - Maigo School of Arts and Trades</h2>

        @if(Auth::user()->role==1)
        
        @foreach ($scans->reverse() as $scan)
    @if ($loop->first)
        <div class="container">
            <div class="image-container">
                <img src="{{ asset('images/' . $scan['studentImage']) }}" alt="Student Image">
            </div>
            <div class="text-container">
                <table>
                    <tr>
                        <th>ID NUMBER:</th>
                        <td>{{ strtoupper($scan['barcode']) }}</td>
                    </tr>
                    <tr>
                        <th>STUDENT NAME:</th>
                        <td>{{ strtoupper($scan['firstName'] . ' ' . $scan['lastName']) }}</td>
                    </tr>
                    <tr>
                        <th>SECTION:</th>
                        <td>{{ strtoupper($scan['section']) }}</td>
                    </tr>
                    <tr>
                        <th>YEAR LEVEL:</th>
                        <td>{{ strtoupper($scan['yearLevel']) }}</td>
                    </tr>
                    <tr>
                        <th>ADDRESS:</th>
                        <td>{{ strtoupper($scan['address']) }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $scan['date'] }}</td>

                    </tr>
                    <tr>
                        <th>Time:</th>
                    <td>{{ $scan['time'] }}</td>
                    </tr>

                </table>
            </div>
        </div>
    @endif
@endforeach
@endif







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
@if(Auth::user()->role == 0)
<button onclick="printScanResults()">Print Scan Results</button>

    @include('scan-result', ['scans' => $scans])
    @endif

    </div>

    <script>
     $(document).ready(function() {
      function updateTime() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var ampm = hours >= 12 ? "PM" : "AM";

        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        var date = currentTime.toDateString();
        var timeString = hours + ":" + minutes + ":" + seconds + " " + ampm;

        // Update the current date and time elements
        $("#current-date").html(date);
        $("#current-time").html(timeString);
      }

      // Update the time every second
      setInterval(updateTime, 1000);
    });
       
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
</body>
</html>

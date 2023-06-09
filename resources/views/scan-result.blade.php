<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/FileSaver.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@5.2.0/dist/js/tableexport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/jsbarcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


    <style>
          /* Button styles */
    #export-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
        float:left;
        margin-bottom: 10px;
    }

   /* Search input styles */
   #search-input {
        padding: 8px;
        border-radius: 4px;
        float: right;
        border: 1px solid #ccc;
        font-size: 14px;
        background-color: #f8f8f8;
        transition: box-shadow 0.3s ease;
    }

    #search-input:focus {
        outline: none;
        border-color: #aaa;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
    }

    /* Clear fix for the container */
    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }
   
    </style>
</head>

@if (!empty($scans))

    <h2>Scanned Barcodes</h2>

    <input type="text" id="search-input" placeholder="Search">

    <table id="scan-results">
    <button onclick="printScanResults()">Print Scan Results</button>

    <button id="export-btn" onclick="exportTableToExcel()">Export to Excel</button>
    <button id="pdf-btn" onclick="exportTableToPDF()">Export to PDF</button>


        <thead>
            <tr>
                <th>Image</th>
                <th>Barcode</th>
                <th>Date</th>
                <th>Time</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Section</th>
                <th>Year Level</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($scans->reverse() as $index => $scan)
                <tr>
                    <td>
                        <img src="{{ asset('images/' . $scan['studentImage']) }}" alt="Student Image" width="100" height="100">
                    </td>
                    <td>{{ $scan['barcode'] }}</td>
                    <td>{{ $scan['date'] }}</td>
                    <td> {{ $index % 2 === 0 ? 'OUT' : 'IN' }}: {{ $scan['time'] }}</td>
                    <td>{{ strtoupper($scan['firstName']) }}</td>
                    <td>{{ strtoupper($scan['lastName']) }}</td>
                    <td>{{ strtoupper($scan['section']) }}</td>
                    <td>{{ strtoupper($scan['yearLevel']) }}</td>
                    <td>{{ strtoupper($scan['address']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No scans available.</p>
@endif



<script>
    
    $(document).ready(function() {
        // Search functionality
        $('#search-input').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#scan-results tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
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

       
    });
     function exportTableToPDF() {
        // Create a new PDF document
        var doc = new jspdf.jsPDF();

        // Get the table element
        var table = document.getElementById("scan-results");

        // Get the table HTML content
        var tableHTML = table.outerHTML;

        // Convert the table HTML to canvas
        html2canvas(table).then(function (canvas) {
            // Get the canvas image data
            var imgData = canvas.toDataURL("image/jpeg", 1.0);

            // Add the image to the PDF document
            doc.addImage(imgData, "JPEG", 10, 10, 190, 0);

            // Save the PDF document
            doc.save("scan_results.pdf");
        });
    }


    function exportTableToExcel() {
            // Get HTML table data
            var table = document.getElementById("scan-results");
            var wb = XLSX.utils.table_to_book(table);

            // Save data to Excel file
            XLSX.writeFile(wb, "attendance_list.xlsx");
        };
        function printScanResults() {
  // Open a new window for printing
  var printWindow = window.open('', '_blank');

  // Build the HTML content to be printed
  var content = document.getElementById('scan-results').outerHTML;

  // Set the content of the new window
  printWindow.document.open();
  printWindow.document.write('<html><head><title>Attendance Lists</title></head><body>');
  printWindow.document.write(content);
  printWindow.document.write('</body></html>');
  printWindow.document.close();

  // Print the new window
  printWindow.print();
}
</script>



@if (!empty($scans))
            <h2>Scanned Barcodes</h2>
            <table  id="scan-results">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Image</th>
                        <th>Section</th>
                        <th>Year Level</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scans->reverse() as $scan)
                        <tr>
                            <td>{{ $scan['barcode'] }}</td>
                            <td>{{ $scan['date'] }}</td>
                            <td>{{ $scan['time'] }}</td>
                            <td>{{ strtoupper($scan['firstName']) }}</td>
                            <td>{{ strtoupper($scan['lastName']) }}</td>
                            <td>
                                 <img src="{{ asset('images/' . $scan['studentImage']) }}" alt="Student Image" width="100" height="100">

                            </td>
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

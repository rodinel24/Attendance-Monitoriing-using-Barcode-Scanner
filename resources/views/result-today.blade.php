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
            float: left;
            margin: 10px;
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
        #pdf-btn{
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            float: left;
            margin: 10px;
        }
        #print{
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            float: left;
            margin: 10px;
        }
    </style>
</head>

@if (!empty($scans))
    <input type="text" id="search-input" placeholder="Search">

    <table id="scan-results">
        

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
                @php
                    $today = date('Y-m-d');
                    $scanDate = date('Y-m-d', strtotime($scan['date']));
                @endphp
                @if ($scanDate == $today)
                    <tr>
                        <td>
                            <img src="{{ asset('images/' . $scan['studentImage']) }}" alt="Student Image" width="100"
                                height="100">
                        </td>
                        <td>{{ $scan['barcode'] }}</td>
                        <td>{{ $scan['date'] }}</td>
                        <td>{{ $index % 2 === 0 ? 'OUT' : 'IN' }}: {{ $scan['time'] }}</td>
                        <td>{{ strtoupper($scan['firstName']) }}</td>
                        <td>{{ strtoupper($scan['lastName']) }}</td>
                        <td>{{ strtoupper($scan['section']) }}</td>
                        <td>{{ strtoupper($scan['yearLevel']) }}</td>
                        <td>{{ strtoupper($scan['address']) }}</td>
                    </tr>
                @endif
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
});

      

    
</script>

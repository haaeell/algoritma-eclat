<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .page-break {
            page-break-after: always;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .list-group-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Hasil Aturan Asosiasi</h1>
    <div>
        @if (empty($rules))
            <div>
                Tidak ada data yang sesuai dengan nilai support dan confidence yang diberikan. Silakan coba lagi dengan nilai yang lebih rendah.
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Rule</th>
                        <th>Support</th>
                        <th>Confidence</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rules as $rule)
                        <tr>
                            <td>{{ $rule['rule'] }}</td>
                            <td>{{ $rule['support'] }}%</td>
                            <td>{{ $rule['confidence'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="page-break"></div>

    <h2>Pola yang Terbentuk</h2>
    <div class="list-group">
        @foreach ($patterns as $pattern)
            <div class="list-group-item">
                <p>{{ $pattern }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>

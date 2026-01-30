<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pam-Inventory</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #166534; /* green-800 */
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10pt;
            color: #666;
        }
        .meta {
            margin-bottom: 20px;
        }
        .meta table {
            width: 100%;
        }
        .meta td {
            padding: 2px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data th, table.data td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table.data th {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: bold;
        }
        table.data tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-red { background-color: #fee2e2; color: #991b1b; } /* Damaged */
        .badge-gray { background-color: #f3f4f6; color: #1f2937; } /* Lost */
        .badge-green { background-color: #dcfce7; color: #166534; } /* Check In */
        .badge-blue { background-color: #dbeafe; color: #1e40af; } /* Check Out */
    </style>
</head>
<body>
    <div class="header">
        <h1>Pam-Inventory Report</h1>
        <p>Sistem Pengelolaan Inventaris Pam-Techno</p>
    </div>

    @yield('content')

    <div class="footer">
        Dicetak pada: {{ date('d F Y H:i') }} | Halaman <span class="page-number"></span>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar SPT</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Daftar Semua SPT</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomor Surat</th>
                <th>Tanggal</th>
                <th>Kepada</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spts as $index => $spt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $spt->nomor_surat }}</td>
                    <td>{{ $spt->tanggal }}</td>
                    <td>
                        <ul style="list-style:none; padding:0; margin:0;">
                            @foreach ($spt->pegawais as $p)
                                <li>{{ $p->pivot->nama }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ ucfirst($spt->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

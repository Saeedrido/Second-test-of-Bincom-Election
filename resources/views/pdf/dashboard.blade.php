<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INEC Election Dashboard Summary</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 14px;
            color: #1a1a1a;
            line-height: 1.6;
            padding: 40px;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }
        .header h1 { font-size: 32px; color: #1e40af; margin-bottom: 4px; }
        .header h2 { font-size: 18px; color: #4b5563; font-weight: normal; }
        .header p { font-size: 12px; color: #6b7280; margin-top: 8px; }
        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .summary-card {
            text-align: center;
            padding: 28px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            border: 1px solid #bae6fd;
        }
        .summary-value { font-size: 36px; font-weight: bold; color: #1e40af; }
        .summary-label { font-size: 12px; color: #4b5563; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin: 32px 0 16px 0;
            padding-bottom: 12px;
            border-bottom: 2px solid #e5e7eb;
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #1e40af; color: white; font-weight: 600; font-size: 12px; text-transform: uppercase; }
        tr:nth-child(even) { background: #f9fafb; }
        td.number { text-align: right; font-weight: 600; }
        tfoot td { font-weight: bold; background: #f3f4f6; }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        .print-btn:hover { background: #1d4ed8; }
        @media print {
            .print-btn { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print / Save as PDF</button>

    <div class="header">
        <h1>INEC Election Dashboard</h1>
        <h2>Comprehensive Election Results Summary</h2>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="summary-value">{{ number_format($stats['total_polling_units']) }}</div>
            <div class="summary-label">Polling Units</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ number_format($stats['total_lgas']) }}</div>
            <div class="summary-label">Local Government Areas</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ number_format($stats['total_wards']) }}</div>
            <div class="summary-label">Wards</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ number_format($stats['total_parties']) }}</div>
            <div class="summary-label">Political Parties</div>
        </div>
    </div>

    @if(!empty($stats['top_parties']) && $stats['top_parties']->count())
    <h3 class="section-title">Top Performing Parties</h3>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Party</th>
                <th style="text-align: right">Total Votes</th>
                <th style="text-align: right">Percentage</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = $stats['top_parties']->sum('total_score');
            @endphp
            @foreach($stats['top_parties'] as $index => $party)
                @php
                    $pct = $grandTotal > 0 ? round(($party->total_score / $grandTotal) * 100, 1) : 0;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $party->party_name }}</td>
                    <td class="number">{{ number_format($party->total_score) }}</td>
                    <td class="number">{{ $pct }}%</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAL</td>
                <td class="number">{{ number_format($grandTotal) }}</td>
                <td class="number">100%</td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(!empty($stats['recent_results']) && $stats['recent_results']->count())
    <h3 class="section-title">Recent Polling Unit Submissions</h3>
    <table>
        <thead>
            <tr>
                <th>Polling Unit</th>
                <th>Ward</th>
                <th>LGA</th>
                <th style="text-align: right">Total Votes</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['recent_results'] as $entry)
                @php
                    $pu = $entry->polling_unit;
                    $totalVotes = $entry->results->sum('party_score');
                @endphp
                @if($pu)
                <tr>
                    <td>{{ $pu->polling_unit_name }}</td>
                    <td>{{ $pu->ward?->ward_name ?? 'N/A' }}</td>
                    <td>{{ $pu->lga?->lga_name ?? 'N/A' }}</td>
                    <td class="number">{{ number_format($totalVotes) }}</td>
                    <td>{{ $entry->latest_entry ? \Carbon\Carbon::parse($entry->latest_entry)->format('M d, Y') : 'N/A' }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p><strong>INEC Election Dashboard</strong> — Official Summary Report</p>
        <p>This document was automatically generated by the INEC Election Management System</p>
        <p style="margin-top: 8px; font-size: 10px; color: #9ca3af;">Bincom PHP/MySQL Developer Technical Interview Assessment</p>
    </div>
</body>
</html>
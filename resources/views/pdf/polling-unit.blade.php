<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polling Unit Results - {{ $polling_unit->polling_unit_name }}</title>
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
        .header h1 { font-size: 28px; color: #1e40af; margin-bottom: 4px; }
        .header h2 { font-size: 18px; color: #4b5563; font-weight: normal; }
        .header p { font-size: 12px; color: #6b7280; margin-top: 8px; }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .info-label { font-size: 11px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { font-size: 16px; font-weight: 600; color: #111827; margin-top: 2px; }
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        .summary-card {
            text-align: center;
            padding: 24px;
            background: #f0f9ff;
            border-radius: 8px;
            border: 1px solid #bae6fd;
        }
        .summary-value { font-size: 32px; font-weight: bold; color: #1e40af; }
        .summary-label { font-size: 12px; color: #4b5563; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #1e40af; color: white; font-weight: 600; font-size: 12px; text-transform: uppercase; }
        tr:nth-child(even) { background: #f9fafb; }
        tr.winner { background: #ecfdf5; }
        td.number { text-align: right; font-weight: 600; }
        .winner-box {
            background: #ecfdf5;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 32px;
        }
        .winner-box h3 { color: #047857; font-size: 14px; margin-bottom: 8px; }
        .winner-party { font-size: 24px; font-weight: bold; color: #065f46; }
        .winner-stats { font-size: 14px; color: #059669; margin-top: 4px; }
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
        <h1>INEC Election Results</h1>
        <h2>{{ $polling_unit->polling_unit_name }}</h2>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="info-grid">
        <div>
            <p class="info-label">Polling Unit Number</p>
            <p class="info-value">{{ $polling_unit->polling_unit_number }}</p>
        </div>
        <div>
            <p class="info-label">Ward</p>
            <p class="info-value">{{ $polling_unit->ward?->ward_name ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="info-label">LGA</p>
            <p class="info-value">{{ $polling_unit->lga?->lga_name ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="info-label">State</p>
            <p class="info-value">{{ $polling_unit->lga?->state?->state_name ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="info-label">Description</p>
            <p class="info-value">{{ $polling_unit->polling_unit_description ?? 'N/A' }}</p>
        </div>
        @if($polling_unit->lat && $polling_unit->long)
        <div>
            <p class="info-label">Coordinates</p>
            <p class="info-value">{{ $polling_unit->lat }}, {{ $polling_unit->long }}</p>
        </div>
        @endif
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="summary-value">{{ number_format($total_votes) }}</div>
            <div class="summary-label">Total Votes Cast</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $winner ? $winner['party_name'] : 'N/A' }}</div>
            <div class="summary-label">Winning Party</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ count($results) }}</div>
            <div class="summary-label">Parties Reporting</div>
        </div>
    </div>

    @if($winner)
    <div class="winner-box">
        <h3>DECLARED WINNER</h3>
        <p class="winner-party">{{ $winner['party_name'] }}</p>
        <p class="winner-stats">
            {{ number_format($winner['party_score']) }} votes 
            ({{ $total_votes > 0 ? round(($winner['party_score'] / $total_votes) * 100, 1) : 0 }}% of total)
        </p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Party Code</th>
                <th>Party Name</th>
                <th style="text-align: right">Votes</th>
                <th style="text-align: right">Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $result)
                @php
                    $pct = $total_votes > 0 ? round(($result['party_score'] / $total_votes) * 100, 1) : 0;
                @endphp
                <tr class="{{ $index === 0 ? 'winner' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result['party_abbreviation'] }}</td>
                    <td>{{ $result['party_name'] }}</td>
                    <td class="number">{{ number_format($result['party_score']) }}</td>
                    <td class="number">{{ $pct }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>INEC Election Dashboard</strong> — Official Results Report</p>
        <p>This document was automatically generated by the INEC Election Management System</p>
        <p style="margin-top: 8px; font-size: 10px; color: #9ca3af;">Bincom PHP/MySQL Developer Technical Interview Assessment</p>
    </div>
</body>
</html>
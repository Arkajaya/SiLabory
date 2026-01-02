<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activities Summary</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; font-size: 12px; }
        th { background: #f4f4f4; }
        .header { text-align: center; margin-bottom: 12px; }
        .small { font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Activities Summary</h2>
        <div class="small">Period: {{ $start->format('Y-m-d') }} — {{ $end->format('Y-m-d') }}</div>
    </div>

    <div class="small">
        <strong>Total loans:</strong> {{ $summary['total_loans'] }}<br>
        <strong>Total items moved:</strong> {{ $summary['total_items'] }}<br>
        <strong>By status:</strong>
        <ul>
            @foreach($summary['by_status'] as $k => $v)
                <li>{{ $k }}: {{ $v }}</li>
            @endforeach
        </ul>
    </div>

    <table class="mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Loan ID</th>
                <th>Items</th>
                <th>Loan Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $i => $loan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $loan->user?->name ?? '—' }}</td>
                    <td>{{ $loan->id }}</td>
                    <td>
                        @foreach($loan->loanDetails as $d)
                            {{ $d->item?->name ?? ('Item #' . $d->item_id) }} × {{ $d->quantity }}<br>
                        @endforeach
                    </td>
                    <td>{{ $loan->loan_date?->format('Y-m-d') }}</td>
                    <td>{{ $loan->return_date?->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $loan->status }}</td>
                    <td>{{ $loan->updated_at?->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
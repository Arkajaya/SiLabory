@foreach ($loans as $loan)
    <tr class="bg-neutral-primary border-b border-default">
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $loans->firstItem() + $loop->index }}</th>
        <td class="px-6 py-4">{{ $loan->user?->name }}</td>
        <td class="px-6 py-4">{{ $loan->id }}</td>
        <td class="px-6 py-4">{{ $loan->loanDetails->map(fn($d) => ($d->item?->name ?? '—') . (isset($d->quantity) ? ' (x'.$d->quantity.')' : ''))->join(', ') }}</td>
        <td class="px-6 py-4">{{ $loan->loan_date?->format('Y-m-d') ?? '-' }}</td>
        <td class="px-6 py-4">{{ $loan->return_date?->format('Y-m-d') ?? '-' }}</td>
        <td class="px-6 py-4">{{ $loan->status }}</td>
        <td class="px-6 py-4">{{ $loan->updated_at?->diffForHumans() ?? $loan->updated_at?->format('Y-m-d H:i') }}</td>
    </tr>
@endforeach

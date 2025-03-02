@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Transactions</h3>
    <div class="table-responsive"> <!-- Tambahkan ini -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Money Type</th>
                    <th>Date</th>
                    <th>Action</th> <!-- Tambahkan kolom untuk tombol hapus -->
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->description }}</td>
                    <td>Rp {{ number_format($transaction->amount, 0) }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ $transaction->money_type }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <p>Total Income: Rp {{ number_format($totalIncome, 0) }}</p>
    <p>Total Expense: Rp {{ number_format($totalExpense, 0) }}</p>

    <div class="row">
        <!-- Pie Chart di Kiri -->
        <div class="col-lg-6 col-md-12 mb-3">
            <canvas id="pieChart"></canvas>
        </div>

        <!-- Bar Chart di Kanan -->
        <div class="col-lg-6 col-md-12">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Data dari Laravel ke JavaScript
        var weeks = @json($weeks);
        var incomeData = @json($incomePerWeek);
        var expenseData = @json($expensePerWeek);

        // PIE CHART
        var ctx1 = document.getElementById('pieChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Income', 'Expense'],
                datasets: [{
                    data: [{{ $totalIncome }}, {{ $totalExpense }}],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // BAR CHART AUTO-GENERATE
        var ctx2 = document.getElementById('barChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: weeks.map(w => `Week ${w}`), // Label Minggu
                datasets: [{
                    label: 'Total Income',
                    data: incomeData,
                    backgroundColor: '#28a745'
                }, {
                    label: 'Total Expense',
                    data: expenseData,
                    backgroundColor: '#dc3545'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
@endsection

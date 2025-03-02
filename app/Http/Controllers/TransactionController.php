<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 🏠 Tampilkan Dashboard
    public function index()
    {
        // Hitung total income & expense
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        // Ambil data transaksi per minggu untuk bar chart
        $weeklyData = Transaction::select(
            DB::raw("WEEK(date) as week"),
            DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
            DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
        )
        ->groupBy('week')
        ->orderBy('week')
        ->get();

        // Konversi data untuk Chart.js
        $weeks = $weeklyData->pluck('week')->toArray();
        $incomePerWeek = $weeklyData->pluck('total_income')->toArray();
        $expensePerWeek = $weeklyData->pluck('total_expense')->toArray();

        return view('dashboard', compact('totalIncome', 'totalExpense', 'weeks', 'incomePerWeek', 'expensePerWeek'));
    }

    // 📌 Tampilkan Form Tambah Transaksi
    public function create()
    {
        return view('transactions.create');
    }

    // ✅ Simpan Transaksi Baru
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'money_type' => 'required|string',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'type' => $request->type,
            'money_type' => $request->money_type,
            'date' => $request->date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    // 📋 Tampilkan Semua Transaksi
    public function show()
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    // 🗑️ Hapus Transaksi
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}

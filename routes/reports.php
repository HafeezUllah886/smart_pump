<?php

use App\Http\Controllers\dailycashbookController;
use App\Http\Controllers\ledgerReportController;
use App\Http\Controllers\profitController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/reports/profit', [profitController::class, 'index'])->name('reports.profit_loss');
    Route::get('/reports/profit-details', [profitController::class, 'details'])->name('reportProfitDetails');

    Route::get('/reports/dailycashbook', [dailycashbookController::class, 'index'])->name('reportCashbook');
    Route::get('/reports/dailycashbook-data', [dailycashbookController::class, 'details'])->name('reportCashbookData');

    Route::get('/reports/ledger', [ledgerReportController::class, 'index'])->name('reportLedger');
    Route::get('/reports/ledger/{from}/{to}/{type}', [ledgerReportController::class, 'data'])->name('reportLedgerData');

});

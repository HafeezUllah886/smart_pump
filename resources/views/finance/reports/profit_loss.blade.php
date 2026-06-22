@extends('layout.app')

@section('content')
    <div class="row">
        <!-- Date Range Filter Start -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3 f-w-600"><i class="ti ti-filter me-2 text-primary"></i>Filter Report Period</h5>
                    <form action="{{ route('reports.profit_loss') }}" method="GET" id="filterForm">
                        <div class="row align-items-end g-3">
                            <div class="col-md-3">
                                <label for="from" class="form-label text-secondary f-w-500">From Date</label>
                                <input type="date" name="from" id="from" value="{{ $from }}" class="form-control border-light-subtle rounded-3">
                            </div>
                            <div class="col-md-3">
                                <label for="to" class="form-label text-secondary f-w-500">To Date</label>
                                <input type="date" name="to" id="to" value="{{ $to }}" class="form-control border-light-subtle rounded-3">
                            </div>
                            <div class="col-md-6 d-flex flex-wrap gap-2 justify-content-md-end mt-3 mt-md-0">
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 border-light-subtle rounded-3" id="presetToday">Today</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 border-light-subtle rounded-3" id="presetYesterday">Yesterday</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 border-light-subtle rounded-3" id="presetThisMonth">This Month</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 border-light-subtle rounded-3" id="presetLastMonth">Last Month</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 border-light-subtle rounded-3" id="presetThisYear">This Year</button>
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 text-white" id="submitFilter"><i class="ti ti-search me-1"></i>Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Date Range Filter End -->

        <!-- KPI Cards Start -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 bg-gradient-info text-white h-100 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <span class="d-block text-white-50 f-s-14 f-w-500 mb-1">Total Sales (Revenue)</span>
                        <h3 class="f-w-700 mb-0">Rs. {{ number_format($totalSales, 2) }}</h3>
                    </div>
                    <div class="h-50 w-50 bg-white-10 b-r-50 d-flex-center">
                        <i class="ti ti-trending-up f-s-24"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 bg-gradient-warning text-white h-100 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <span class="d-block text-white-50 f-s-14 f-w-500 mb-1">Cost of Goods Sold (COGS)</span>
                        <h3 class="f-w-700 mb-0">Rs. {{ number_format($totalCogs, 2) }}</h3>
                    </div>
                    <div class="h-50 w-50 bg-white-10 b-r-50 d-flex-center">
                        <i class="ti ti-package f-s-24"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 bg-gradient-danger text-white h-100 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <span class="d-block text-white-50 f-s-14 f-w-500 mb-1">Operating Expenses</span>
                        <h3 class="f-w-700 mb-0">Rs. {{ number_format($totalExpenses, 2) }}</h3>
                    </div>
                    <div class="h-50 w-50 bg-white-10 b-r-50 d-flex-center">
                        <i class="ti ti-wallet f-s-24"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 {{ $netProfit >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }} text-white h-100 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <span class="d-block text-white-50 f-s-14 f-w-500 mb-1">Net Profit / (Loss)</span>
                        <h3 class="f-w-700 mb-0">Rs. {{ number_format($netProfit, 2) }}</h3>
                    </div>
                    <div class="h-50 w-50 bg-white-10 b-r-50 d-flex-center">
                        <i class="ti {{ $netProfit >= 0 ? 'ti-mood-happy' : 'ti-mood-sad' }} f-s-24"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- KPI Cards End -->

        <!-- Financial Statement Start -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="f-w-600 mb-0 text-dark"><i class="ti ti-file-text me-2 text-primary"></i>Income Statement</h5>
                    <span class="badge bg-light text-secondary rounded-pill px-3 py-2 border">Summary View</span>
                </div>
                <div class="card-body px-4 py-3">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                <!-- Sales -->
                                <tr class="border-0">
                                    <td class="f-w-600 text-dark py-3" style="width: 60%;">Sales Revenue (Gross)</td>
                                    <td class="text-end text-success f-w-600 py-3">Rs. {{ number_format($totalSales, 2) }}</td>
                                </tr>
                                <!-- COGS Heading -->
                                <tr class="bg-light-subtle">
                                    <td colspan="2" class="f-w-600 text-secondary py-2 ps-2">Cost of Goods Sold (COGS)</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-2 ps-3">Opening Stock Value</td>
                                    <td class="text-end text-muted py-2">Rs. {{ number_format($totalOpeningStockValue, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-2 ps-3">Add: Purchases during Period</td>
                                    <td class="text-end text-muted py-2">Rs. {{ number_format($totalPurchases, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-2 ps-3">Less: Closing Stock Value</td>
                                    <td class="text-end text-muted py-2">(Rs. {{ number_format($totalClosingStockValue, 2) }})</td>
                                </tr>
                                <tr class="table-group-divider">
                                    <td class="f-w-600 text-secondary py-3 ps-3">Total Cost of Goods Sold (COGS)</td>
                                    <td class="text-end text-dark f-w-600 py-3">(Rs. {{ number_format($totalCogs, 2) }})</td>
                                </tr>
                                <!-- Gross Profit -->
                                <tr class="table-active">
                                    <td class="f-w-700 text-dark py-3">Gross Profit</td>
                                    <td class="text-end text-dark f-w-700 py-3">Rs. {{ number_format($totalGrossProfit, 2) }}</td>
                                </tr>
                                <!-- Operating Expenses -->
                                <tr class="bg-light-subtle">
                                    <td colspan="2" class="f-w-600 text-secondary py-2 ps-2">Operating Expenses</td>
                                </tr>
                                @forelse($expensesByCategory as $exp)
                                    <tr>
                                        <td class="text-secondary py-2 ps-3">{{ $exp->category ? ucfirst($exp->category->name) : 'Uncategorized' }}</td>
                                        <td class="text-end text-muted py-2">(Rs. {{ number_format($exp->total_amount, 2) }})</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-muted py-2 ps-3 text-center">No operating expenses recorded.</td>
                                    </tr>
                                @endforelse
                                <tr class="table-group-divider">
                                    <td class="f-w-600 text-secondary py-3 ps-3">Total Operating Expenses</td>
                                    <td class="text-end text-dark f-w-600 py-3">(Rs. {{ number_format($totalExpenses, 2) }})</td>
                                </tr>
                                <!-- Net Profit -->
                                <tr class="{{ $netProfit >= 0 ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger' }}" style="border-top: 2px solid; border-bottom: 4px double;">
                                    <td class="f-w-700 text-dark py-3">NET PROFIT / (LOSS)</td>
                                    <td class="text-end {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }} f-w-700 py-3">Rs. {{ number_format($netProfit, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Financial Statement End -->

        <!-- Expenses Breakdown Start -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="f-w-600 mb-0 text-dark"><i class="ti ti-wallet me-2 text-primary"></i>Operating Expenses Breakdown</h5>
                </div>
                <div class="card-body px-4 py-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr class="table-light">
                                    <th>Expense Category</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-end">Share (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expensesByCategory as $exp)
                                    @php
                                        $percentage = $totalExpenses > 0 ? ($exp->total_amount / $totalExpenses) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td class="f-w-600 text-dark">{{ $exp->category ? ucfirst($exp->category->name) : 'Uncategorized' }}</td>
                                        <td class="text-end">Rs. {{ number_format($exp->total_amount, 2) }}</td>
                                        <td class="text-end">
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <span class="text-secondary f-s-13">{{ number_format($percentage, 1) }}%</span>
                                                <div class="progress" style="width: 60px; height: 6px;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No expenses recorded for this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($totalExpenses > 0)
                                <tfoot>
                                    <tr class="table-light f-w-600 text-dark">
                                        <td>Total Expenses</td>
                                        <td class="text-end">Rs. {{ number_format($totalExpenses, 2) }}</td>
                                        <td class="text-end">100.0%</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Expenses Breakdown End -->

        <!-- Product Inventory Breakdown Start -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="f-w-600 mb-0 text-dark"><i class="ti ti-box me-2 text-primary"></i>Product Inventory & Profit Contribution</h5>
                    <span class="badge bg-primary text-white rounded-pill px-3 py-2">Detailed Product Margins</span>
                </div>
                <div class="card-body px-4 py-3">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-hover align-middle border text-nowrap">
                            <thead>
                                <tr class="table-light">
                                    <th rowspan="2" class="align-middle">Product</th>
                                    <th colspan="3" class="text-center border-bottom border-light text-secondary">Opening Stock</th>
                                    <th colspan="2" class="text-center border-bottom border-light text-secondary">Purchases</th>
                                    <th colspan="2" class="text-center border-bottom border-light text-secondary">Sales</th>
                                    <th colspan="3" class="text-center border-bottom border-light text-secondary">Closing Stock</th>
                                    <th rowspan="2" class="text-end align-middle">COGS</th>
                                    <th rowspan="2" class="text-end align-middle">Gross Profit</th>
                                </tr>
                                <tr class="table-light f-s-12">
                                    <th class="text-end text-muted">Qty</th>
                                    <th class="text-end text-muted">Avg Price</th>
                                    <th class="text-end text-muted">Value</th>
                                    <th class="text-end text-muted">Qty</th>
                                    <th class="text-end text-muted">Value</th>
                                    <th class="text-end text-muted">Qty</th>
                                    <th class="text-end text-muted">Revenue</th>
                                    <th class="text-end text-muted">Qty</th>
                                    <th class="text-end text-muted">Avg Price</th>
                                    <th class="text-end text-muted">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productBreakdown as $row)
                                    <tr>
                                        <td class="f-w-600 text-dark">{{ $row['product']->name }}</td>
                                        <!-- Opening -->
                                        <td class="text-end">{{ number_format($row['opening_qty'], 2) }}</td>
                                        <td class="text-end">Rs. {{ number_format($row['opening_price'], 2) }}</td>
                                        <td class="text-end text-muted">Rs. {{ number_format($row['opening_value'], 2) }}</td>
                                        <!-- Purchases -->
                                        <td class="text-end">{{ number_format($row['qty_purchased'], 2) }}</td>
                                        <td class="text-end text-muted">Rs. {{ number_format($row['purchases_amount'], 2) }}</td>
                                        <!-- Sales -->
                                        <td class="text-end">{{ number_format($row['qty_sold'], 2) }}</td>
                                        <td class="text-end text-success f-w-600">Rs. {{ number_format($row['sales_amount'], 2) }}</td>
                                        <!-- Closing -->
                                        <td class="text-end">{{ number_format($row['closing_qty'], 2) }}</td>
                                        <td class="text-end">Rs. {{ number_format($row['closing_price'], 2) }}</td>
                                        <td class="text-end text-muted">Rs. {{ number_format($row['closing_value'], 2) }}</td>
                                        <!-- COGS & Profit -->
                                        <td class="text-end f-w-500">Rs. {{ number_format($row['cogs'], 2) }}</td>
                                        <td class="text-end f-w-600 {{ $row['gross_profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            Rs. {{ number_format($row['gross_profit'], 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-4">No product data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="table-light f-w-600 text-dark">
                                    <td>Totals</td>
                                    <td colspan="2"></td>
                                    <td class="text-end text-muted">Rs. {{ number_format($totalOpeningStockValue, 2) }}</td>
                                    <td></td>
                                    <td class="text-end text-muted">Rs. {{ number_format($totalPurchases, 2) }}</td>
                                    <td></td>
                                    <td class="text-end text-success">Rs. {{ number_format($totalSales, 2) }}</td>
                                    <td colspan="2"></td>
                                    <td class="text-end text-muted">Rs. {{ number_format($totalClosingStockValue, 2) }}</td>
                                    <td class="text-end">Rs. {{ number_format($totalCogs, 2) }}</td>
                                    <td class="text-end {{ $totalGrossProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                        Rs. {{ number_format($totalGrossProfit, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Inventory Breakdown End -->
    </div>
@endsection

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Helper to get formatted dates
            const getFormattedDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            const setDates = (fromStr, toStr) => {
                document.getElementById('from').value = fromStr;
                document.getElementById('to').value = toStr;
                document.getElementById('filterForm').submit();
            };

            // Preset Button Event Listeners
            document.getElementById('presetToday').addEventListener('click', function () {
                const todayStr = getFormattedDate(new Date());
                setDates(todayStr, todayStr);
            });

            document.getElementById('presetYesterday').addEventListener('click', function () {
                const yesterday = new Date();
                yesterday.setDate(yesterday.getDate() - 1);
                const yesterdayStr = getFormattedDate(yesterday);
                setDates(yesterdayStr, yesterdayStr);
            });

            document.getElementById('presetThisMonth').addEventListener('click', function () {
                const now = new Date();
                const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
                const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                setDates(getFormattedDate(firstDay), getFormattedDate(lastDay));
            });

            document.getElementById('presetLastMonth').addEventListener('click', function () {
                const now = new Date();
                const firstDay = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                const lastDay = new Date(now.getFullYear(), now.getMonth(), 0);
                setDates(getFormattedDate(firstDay), getFormattedDate(lastDay));
            });

            document.getElementById('presetThisYear').addEventListener('click', function () {
                const now = new Date();
                const firstDay = new Date(now.getFullYear(), 0, 1);
                const lastDay = new Date(now.getFullYear(), 11, 31);
                setDates(getFormattedDate(firstDay), getFormattedDate(lastDay));
            });
        });
    </script>
@endsection

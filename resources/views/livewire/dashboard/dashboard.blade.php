<div class="mb-5">

    <style>
        .hover-color:hover {
            background: black !important;
            color: white !important;
        }

        .card-style {
            border: 3px solid black;
        }

        .filter-bg {
            background: #7d4000 !important;
        }
    </style>

    {{-- <div class="btn-group mb-4" role="group" aria-label="Filter Options ">
        @foreach ($filter as $option)
            <button type="button" style="border:1px solid black;color:black"
                class="btn hover-color {{ $selectedFilter === $option ? 'btn-primary' : 'btn-outline-primary' }}"
                wire:click="setFilter('{{ $option }}')" onclick="window.scrollTo(0, 0)">
                {{ $option }}
            </button>
        @endforeach
    </div> --}}

    <div class="d-flex gap-4" wire:loading.remove>
        <x-dashboard-card title="Gross" :data="$gross->total" :percentage="$gross->percentage" />
        <x-dashboard-card title="POS Orders Count" :data="$psoOrders->total" :percentage="$psoOrders->percentage" />
        <x-dashboard-card title="Avg POS Sale" :data="$averageSale->total" :percentage="$averageSale->percentage" />
        {{-- <x-dashboard-card title="Expense" :data="$expense->total" :percentage="$expense->percentage" />
        <x-dashboard-card title="Net" :data="$net->total" :percentage="$net->percentage" /> --}}
    </div>

    {{-- <div class="d-flex gap-4 mt-4" wire:loading.remove>
        <x-dashboard-card title="Product Orders" :data="$psoOrders->total" :percentage="$psoOrders->percentage" />
        <x-dashboard-card title="Avg Sales" :data="$averageSale->total" :percentage="$averageSale->percentage" />
    </div> --}}

    <div class="d-flex gap-4 mt-4">

        <div style="max-width: 740px;height:400px" class="shadow w-100 p-3 rounded w-full card-style" wire:loading.remove>
            <h5 class="text-lg font-semibold">Monthly Gross </h5>
            <canvas id="monthlyNetChart"></canvas>
        </div>

        <div style="max-width: 740px;height:400px" class="shadow w-100 p-3 rounded w-full card-style"
            wire:loading.remove>

            <h5 class="text-lg font-semibold">Yearly Gross</h5>
            <canvas id="yearlyNetChart"></canvas>
        </div>
    </div>

    <div class="mt-5" wire:loading.remove>
        <div class="shadow p-3 rounded card-style">
            <h5>Best Selling Products Today</h5>

            @if ($bestSellingProducts->isEmpty())
                <p class="text-muted text-center">No data</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Quantity Sold</th>
                                <th class="text-end">Total Revenue</th>
                                <th class="text-end">Avg. Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bestSellingProducts as $product)
                                <tr>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td class="text-end">{{ number_format($product['total_quantity']) }}</td>
                                    <td class="text-end">₱{{ number_format($product['total_revenue'], 2) }}</td>
                                    <td class="text-end">₱{{ number_format($product['average_price'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @push('scripts')
            <script>
                const monthlyNetCtx = document.getElementById('monthlyNetChart').getContext('2d');
                const monthlyNetChart = new Chart(monthlyNetCtx, {
                    type: 'line',
                    data: {
                        labels: @json($monthlyNetChartData['labels'] ?? []),
                        datasets: [{
                            label: 'Gross',
                            data: @json($monthlyNetChartData['data'] ?? []),
                            backgroundColor: 'rgba(105, 221, 36, 0.2)',
                            borderColor: '#69dd24',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Net: ' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });

                const yearlyNetCtx = document.getElementById('yearlyNetChart').getContext('2d');
                const yearlyNetChart = new Chart(yearlyNetCtx, {
                    type: 'line',
                    data: {
                        labels: @json($yearlyNetChartData['labels'] ?? []),
                        datasets: [{
                            label: 'Gross',
                            data: @json($yearlyNetChartData['data'] ?? []),
                            backgroundColor: 'rgba(105, 221, 36, 0.2)',
                            borderColor: '#69dd24',
                            borderWidth: 2,
                            tension: 0.8,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Net: ' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        @endpush

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const monthlyChartData = @json($chartData);
                const weeklyChartData = @json($weeklyChartData);

                const ctxMonthly = document.getElementById('myChart').getContext('2d');
                new Chart(ctxMonthly, {
                    type: 'bar',
                    data: {
                        datasets: [{
                                type: 'bar',
                                label: 'POS Orders (Sales)',
                                data: monthlyChartData.pos_orders,
                                backgroundColor: 'black',
                                borderWidth: 1
                            },
                            {
                                type: 'bar',
                                label: 'Expenses',
                                data: monthlyChartData.expenses,
                                fill: false,
                                backgroundColor: '#9fa1ca',
                                tension: 0.5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                const ctxWeekly = document.getElementById('weeklyChart').getContext('2d');
                new Chart(ctxWeekly, {
                    type: 'bar',
                    data: {
                        labels: weeklyChartData.labels,
                        datasets: [{
                                type: 'bar',
                                label: 'POS Orders (Sales)',
                                data: weeklyChartData.pos_orders,
                                backgroundColor: 'black',
                                borderWidth: 1
                            },
                            {
                                type: 'bar',
                                label: 'Expenses',
                                data: weeklyChartData.expenses,
                                fill: false,
                                backgroundColor: '#9fa1ca',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: false,
                                    text: 'Amount'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            });
        </script>

    </div>

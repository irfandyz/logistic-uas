@extends('user.template')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title text-white"><i class="fas fa-users"></i> Suppliers</h5>
                                        <p class="card-text">{{ $suppliers->count() }} Data</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title text-white"><i class="fas fa-users"></i> Customers</h5>
                                        <p class="card-text">{{ $customers->count() }} Data</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark"><i class="fas fa-truck"></i> Shippings</h5>
                                        <p class="card-text">{{ $shippings->count() }} Data</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title text-white"><i class="fas fa-list"></i> Categories</h5>
                                        <p class="card-text">{{ $categories->count() }} Data</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Statistic Item</h5>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-5 text-white">Item Statistic</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Item Variants : {{ $items->count() }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Items : {{ $items->sum('quantity') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-5">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-dollar-sign fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Value : Rp. {{ number_format($totalValue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-5 text-white">Incoming Item Statistic</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Incoming Item : {{ $incomingItems }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Value : Rp. {{ number_format($incomingItemsValue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-5 text-white">Outgoing Item Statistic</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Outgoing Item : {{ $outgoingItems }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    <div>
                                        <p class="card-text">Total Value : Rp. {{ number_format($outgoingItemsValue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Incoming Item', 'Outgoing Item'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $incomingItems }}, {{ $outgoingItems }}],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  </script>

  @endsection

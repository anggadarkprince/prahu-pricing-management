<h4 class="mb-4 text-primary">Dashboard</h4>

<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="text-success card-title">
                    <i class="mdi mdi-anchor mr-2"></i>Ports
                </h5>
                <h6 class="card-subtitle mb-1 text-muted small">Port master data</h6>
                <h4 class="mb-3">345
                    <small>Port</small>
                </h4>
                <a href="<?= site_url('master/port') ?>" class="btn btn-sm btn-outline-success">
                    <i class="mdi mdi-chevron-right"></i> See in Details
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="text-danger card-title">
                    <i class="mdi mdi-factory mr-2"></i>Vendor
                </h5>
                <h6 class="card-subtitle mb-1 text-muted small">Partner and vendors</h6>
                <h4 class="mb-3">732
                    <small>Partners</small>
                </h4>
                <a href="<?= site_url('master/vendor') ?>" class="btn btn-sm btn-outline-danger">
                    See in Details <i class="mdi mdi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="text-info card-title">
                    <i class="mdi mdi-cube-outline mr-2"></i>Locations
                </h5>
                <h6 class="card-subtitle mb-1 text-muted small">Area pickup and destination</h6>
                <h4 class="mb-3">34
                    <small>Items</small>
                </h4>
                <a href="<?= site_url('report/stock-summary') ?>" class="btn btn-sm btn-outline-info">
                    See in Details <i class="mdi mdi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="text-warning card-title">
                    <i class="mdi mdi-checkbox-marked-circle-outline mr-2"></i>Quotation
                </h5>
                <h6 class="card-subtitle mb-1 text-muted small">Pricing offer histories</h6>
                <h4 class="mb-3">732
                    <small>SF</small>
                </h4>
                <a href="<?= site_url('inbound/notification') ?>" class="btn btn-sm btn-outline-warning">
                    See in Details <i class="mdi mdi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="mt-2" style="position: relative;">
    <canvas id="movement-chart" height="70">
        Your browser does not support the canvas element.
    </canvas>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('movement-chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [{
                label: "Inbound",
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                data: [0, 10, 5, 2, 20, 30, 45, 34, 14, 26, 43, 53],
                borderWidth: 3,
                fill: true
            }, {
                label: "Outbound",
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                data: [40, 50, 3, 2, 3, 34, 60, 23, 13, 64, 34, 64],
                borderWidth: 3,
                fill: true
            }]
        },
        options: {
            tooltips: {
                mode: 'index',
                intersect: false,
                titleFontSize: 14,
                xPadding: 10,
                yPadding: 10,
                cornerRadius: 3
            },
            legend: {
                display: false
            },
            elements: {
                line: {
                    tension: 0
                },
                point: {
                    radius: 6
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        stepSize: 15,
                        padding: 20,
                    },
                    gridLines: {
                        zeroLineColor: 'rgba(0, 0, 0, 0.05)',
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }],
                xAxes: [{
                    offset: true,
                    gridLines: {
                        zeroLineColor: 'rgba(0, 0, 0, 0.05)',
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }],
            }
        }
    });
</script>

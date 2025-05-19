{{-- @extends('layout')
@section('main')
<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container dashboard">
    <div class="row">
  <!-- New Users Today Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">المستخدمين <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $users }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Doctors Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">المستخدمين <span>| الغير مقبولين</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-x"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $unApprovedUsers }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Bills Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">المستخدمين <span>| المقبولين</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $approvedUsers }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Revenue Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">المستخدمين <span>| للشهر الحالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $currentMonthUsers }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Today Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">العملاء <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $customers }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Average Bills Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">القضايا <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="ps-3">
                    <h6>{{  $cases  }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">المستخدمين <span>| آخر 7 أيام</span></h5>
            <div id="usersChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const last7Days = @json(array_keys($last7DaysUsers));
                    const dailyUsers = @json(array_values($last7DaysUsers));
                    
                    new ApexCharts(document.querySelector("#usersChart"), {
                        series: [{
                            name: 'المستخدمين',
                            data: dailyUsers,
                        }],
                        chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#0e123e'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            type: 'datetime',
                            categories: last7Days,
                        },
                        yaxis: {
                            labels: {
                                formatter: function (val) {
                                    return Math.round(val);
                                }
                            },
                            min: 0,
                            forceNiceScale: true
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy'
                            },
                        }
                    }).render();
                });
            </script>
        </div>
    </div>
</div>

@endsection --}}



@extends('layout')

@section('main')
<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
<!-- ApexCharts for Heartbeat Effect (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

<style>
    .card-icon {
        width: 50px;
        height: 50px;
        background-color: #f8e1d9;
        border-radius: 50%;
        font-size: 24px;
        color: #d92362;
    }
    .info-card {
        margin-bottom: 20px;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
    }
    .card-title span {
        font-size: 14px;
        color: #888;
    }
    .heartbeat {
        width: 100%;
        height: 40px;
    }
    .clickable-card {
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .clickable-card:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="container dashboard">
    <div class="row">
        <!-- Customers Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">العملاء <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="customers-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cases Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">القضايا <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="cases-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessions Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">الجلسات <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="sessions-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contracts Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">العقود <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="contracts-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المدفوعات <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-cash"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="payments-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remaining Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المتبقي <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="remaining-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">المصروفات <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="expenses-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">الإيرادات <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="revenue-count">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">الجلسات <span>| الشهر الحالي</span></h5>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card info-card clickable-card" onclick="showDetails('customers')">
                <div class="card-body">
                    <h5 class="card-title">العملاء</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card info-card clickable-card" onclick="showDetails('cases')">
                <div class="card-body">
                    <h5 class="card-title">القضايا</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card info-card clickable-card" onclick="showDetails('payments')">
                <div class="card-body">
                    <h5 class="card-title">المدفوعات</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-cash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card info-card clickable-card" onclick="showDetails('contracts')">
                <div class="card-body">
                    <h5 class="card-title">العقود</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fetch summary data from index endpoint
    document.addEventListener("DOMContentLoaded", () => {
        fetch('/api/home')
            .then(response => response.json())
            .then(data => {
                document.getElementById('customers-count').innerText = data.customers;
                document.getElementById('cases-count').innerText = data.cases;
                document.getElementById('sessions-count').innerText = data.sessions;
                document.getElementById('contracts-count').innerText = data.contracts;
                document.getElementById('payments-count').innerText = data.payments;
                document.getElementById('remaining-count').innerText = data.remaining;
                document.getElementById('expenses-count').innerText = data.expenses;
                document.getElementById('revenue-count').innerText = data.revenue;
            })
            .catch(error => console.error('Error fetching summary data:', error));

        // Initialize Calendar
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based in JS

        fetch(`/api/session-dates/${year}/${month}`)
            .then(response => response.json())
            .then(data => {
                const events = Object.keys(data).map(date => {
                    const sessionCount = data[date];
                    return {
                        title: sessionCount.toString(),
                        start: date,
                        extendedProps: {
                            sessionCount: sessionCount
                        }
                    };
                });

                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: events,
                    eventContent: function(arg) {
                        const sessionCount = arg.event.extendedProps.sessionCount;
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <div>${sessionCount}</div>
                            <div id="heartbeat-${arg.event.startStr}" class="heartbeat"></div>
                        `;
                        if (sessionCount > 0) {
                            setTimeout(() => {
                                new ApexCharts(document.querySelector(`#heartbeat-${arg.event.startStr}`), {
                                    series: [{
                                        name: 'Heartbeat',
                                        data: [0, 2, 1, 3, 0, 2, 1, 0] // Simulated heartbeat effect
                                    }],
                                    chart: {
                                        height: 40,
                                        type: 'line',
                                        toolbar: { show: false },
                                        sparkline: { enabled: true }
                                    },
                                    stroke: { width: 2, colors: ['#d92362'] },
                                    tooltip: { enabled: false }
                                }).render();
                            }, 0);
                        }
                        return { domNodes: [div] };
                    },
                    locale: 'ar',
                    direction: 'rtl'
                });
                calendar.render();
            })
            .catch(error => console.error('Error fetching session dates:', error));
    });

    // Function to show details when clicking on interactive cards
    function showDetails(type) {
        let endpoint = '';
        if (type === 'payments') {
            endpoint = '/api/payment-details';
        } else if (type === 'contracts') {
            endpoint = '/api/contract-details';
        } else {
            alert('التفاصيل غير متوفرة حاليًا لهذا العنصر.');
            return;
        }

        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                let message = '';
                if (type === 'payments') {
                    message = 'تفاصيل المدفوعات:\n' + data.map(payment => 
                        `المبلغ: ${payment.amount} - التاريخ: ${payment.date} - رقم القضية: ${payment.case_id}`
                    ).join('\n');
                } else if (type === 'contracts') {
                    message = 'تفاصيل العقود:\n' + data.map(contract => 
                        `السعر: ${contract.contract_price} - رقم القضية: ${contract.case_id} - تاريخ الإنشاء: ${contract.created_at}`
                    ).join('\n');
                }
                alert(message);
            })
            .catch(error => console.error(`Error fetching ${type} details:`, error));
    }
</script>
@endsection
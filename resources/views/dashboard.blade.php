@extends('layout')

@section('main')

<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

<!-- ApexCharts for Heartbeat -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- أسلوب إضافي للتقويم -->
<style>
    #calendar {
        min-height: 600px;
        width: 100%;
        direction: rtl;
        font-family: 'Tajawal', sans-serif;
    }
    .fc-header-toolbar {
        direction: rtl;
    }
    .fc-toolbar-title {
        font-size: 1.5em;
        font-weight: bold;
    }
    .fc-daygrid-day {
        text-align: center;
    }
    .fc-event {
        cursor: pointer;
        padding: 3px;
        border-radius: 4px;
        margin-bottom: 2px;
        background: none !important;
        border: none !important;
    }
    .fc-daygrid-event-dot {
        display: none;
    }
    .heartbeat {
        width: 100%;
        height: 20px;
        margin-top: 5px;
    }
</style>

<div class="container dashboard">
    <div class="row">
        <!-- كروت الإحصائيات (محافظة على الأصلية دون تعديل) -->
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

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">القضايا <span>| الإجمالي</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $cases }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسم البياني للمستخدمين خلال 7 أيام (محافظة عليه كما هو) -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">المستخدمين <span>| آخر 7 أيام</span></h5>
                    <div id="usersChart"></div>
                </div>
            </div>
        </div>

        <!-- تقويم الأحداث -->
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">التقويم</h5>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- مكتبات JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/ar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // الرسم البياني (محافظة عليه كما هو)
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
                toolbar: { show: false },
            },
            markers: { size: 4 },
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
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
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

    // التقويم
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        if (!calendarEl) {
            console.error('عنصر التقويم غير موجود! تأكد من وجود div#calendar');
            return;
        }

        // إعداد التقويم على مايو 2025
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ar',
            direction: 'rtl',
            firstDay: 1, // الإثنين كأول يوم (كما في الصورة)
            initialDate: '2025-05-01', // بداية مايو 2025
            headerToolbar: {
                right: 'prev,next today',
                center: 'title',
                left: 'dayGridMonth'
            },
            buttonText: {
                today: 'اليوم',
                month: 'شهر'
            },
            dayMaxEvents: true, // عرض الحدث كاملاً
            events: function(fetchInfo, successCallback, failureCallback) {
                // جلب بيانات الجلسات من الـ API
                const year = fetchInfo.start.getFullYear();
                const month = String(fetchInfo.start.getMonth() + 1).padStart(2, '0');
                fetch(`/api/session-dates/${year}/${month}`)
                    .then(response => response.json())
                    .then(data => {
                        const events = Object.keys(data).map(date => {
                            const sessionCount = data[date];
                            return {
                                title: sessionCount.toString(),
                                start: date,
                                allDay: true,
                                extendedProps: {
                                    sessionCount: sessionCount
                                }
                            };
                        });
                        successCallback(events);
                    })
                    .catch(error => {
                        console.error('خطأ في جلب بيانات الجلسات:', error);
                        failureCallback(error);
                    });
            },
            eventContent: function(arg) {
                const sessionCount = arg.event.extendedProps.sessionCount;
                const div = document.createElement('div');
                div.innerHTML = `
                    <div style="font-size: 14px; font-weight: bold;">${sessionCount}</div>
                    <div id="heartbeat-${arg.event.startStr}" class="heartbeat"></div>
                `;
                if (sessionCount > 0) {
                    setTimeout(() => {
                        new ApexCharts(document.querySelector(`#heartbeat-${arg.event.startStr}`), {
                            series: [{
                                name: 'Heartbeat',
                                data: [0, 2, 1, 3, 0, 2, 1, 0] // محاكاة نبضة القلب
                            }],
                            chart: {
                                height: 20,
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
            eventDidMount: function(info) {
                // التأكد من أن الأحداث تظهر بشكل صحيح
                if (info.event.extendedProps.sessionCount === 0) {
                    info.el.style.display = 'none'; // إخفاء الأيام بدون جلسات إذا لزم الأمر
                }
            }
        });

        calendar.render();
    });
</script>

@endsection
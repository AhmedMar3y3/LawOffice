@extends('layout')
@section('main')

<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

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
    .fc-event {
        cursor: pointer;
        padding: 3px;
        border-radius: 4px;
        margin-bottom: 2px;
    }
    .fc-daygrid-event-dot {
        display: none;
    }
</style>

<div class="container dashboard">
    <div class="row">

        <!-- كروت الإحصائيات -->
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

        <!-- المستخدمين الغير مقبولين -->
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

        <!-- المستخدمين المقبولين -->
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

        <!-- المستخدمين الشهر الحالي -->
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

        <!-- العملاء -->
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

        <!-- القضايا -->
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

        <!-- الرسم البياني للمستخدمين خلال 7 أيام -->
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
    // الرسم البياني
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

        // إنشاء تواريخ للأحداث
        var today = new Date();
        var tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        
        var nextWeek = new Date(today);
        nextWeek.setDate(today.getDate() + 7);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ar',
            direction: 'rtl',
            firstDay: 6, // السبت كأول يوم في الأسبوع
            headerToolbar: {
                right: 'prev,next today',
                center: 'title',
                left: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'اليوم',
                month: 'شهر',
                week: 'أسبوع',
                day: 'يوم'
            },
            events: [
                {
                    title: 'جلسة استشارة',
                    start: today,
                    color: '#4154f1',
                    extendedProps: {
                        description: 'جلسة استشارة مع العميل أحمد'
                    }
                },
                {
                    title: 'اجتماع عميل',
                    start: tomorrow,
                    end: new Date(tomorrow.getTime() + 3600000), // +1 ساعة
                    color: '#2eca6a',
                    extendedProps: {
                        description: 'اجتماع متابعة المشروع'
                    }
                },
                {
                    title: 'موعد نهائي',
                    start: nextWeek,
                    color: '#ff771d',
                    extendedProps: {
                        description: 'آخر موعد لتسليم الملفات'
                    }
                }
            ],
            eventClick: function(info) {
                alert(
                    'الحدث: ' + info.event.title + '\n' +
                    'الوصف: ' + info.event.extendedProps.description + '\n' +
                    'الوقت: ' + info.event.start.toLocaleString('ar-EG')
                );
            },
            eventContent: function(arg) {
                return {
                    html: '<i class="bi bi-calendar-event me-1"></i>' + arg.event.title
                };
            },
            datesSet: function(info) {
                console.log('التاريخ المعروض:', info.view.title);
            }
        });

        calendar.render();
        
        // إضافة زر لتحديث التقويم (اختياري)
        var refreshBtn = document.createElement('button');
        refreshBtn.className = 'btn btn-sm btn-primary ms-2';
        refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> تحديث';
        refreshBtn.onclick = function() {
            calendar.refetchEvents();
        };
        
        var toolbar = calendarEl.querySelector('.fc-toolbar-chunk:last-child');
        if (toolbar) {
            toolbar.appendChild(refreshBtn);
        }
    });
</script>

@endsection
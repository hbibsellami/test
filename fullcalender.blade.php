<!DOCTYPE html>
<html>
<head>
    <title>Accepted Leaves</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Fullcalender Tutorial Tutorial - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>

<div class="container">
    <h1>Accepted Leaves</h1>
    <a href="{{ url('leaves') }}" class="btn btn-danger float-end">Back</a>
    <div id='calendar'></div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({

            editable: false,
            events: SITEURL + "/fullcalender",
            displayEventTime: false,
            eventRender: function (event) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                }
            },
            selectable: false,
            selectHelper: false,
        });

        });

    function displayMessage(message) {
        toastr.success(message, 'Event');
    }

</script>
</body>
</html>

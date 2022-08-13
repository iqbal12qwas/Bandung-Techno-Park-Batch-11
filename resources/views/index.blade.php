<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Activity</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-10"></div>
            <div class="col-lg-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onClick="showCreateForm()">
                    Add Activity
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div id="read" class="mt-3"></div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="modalForm" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Input Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="page" class="p-create-form"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
        read();
    });

    // Read Data
    function read() {
        $.get("{{ url('read') }}", {}, function(data, status) {
            $("#read").html(data);
            $('#table').DataTable();
        });
    }

    // View Create Data "Modal"
    function showCreateForm() {
        $.get("{{ url('create') }}", {}, function(data, status) {

            // Select Month
            $.ajax({
                type: "GET",
                url: "{{ url('month') }}",
                contentType: "application/json",
                dataType: 'json',
                success: function(response) {
                    var month = $('#month');
                    month.empty();
                    month.append('<option value="">Choose</option>');
                    for (var i = 0; i < response.length; i++) {
                        month.append('<option value=' + response[i].id + '>' + response[i].name +
                            '</option>');
                    }
                    month.change();
                }
            });

            // Select Method
            $.ajax({
                type: "GET",
                url: "{{ url('method') }}",
                contentType: "application/json",
                dataType: 'json',
                success: function(response) {
                    var method = $('#method');
                    method.empty();
                    method.append('<option value="">Choose</option>');
                    for (var i = 0; i < response.length; i++) {
                        method.append('<option value=' + response[i].id + '>' + response[i].name +
                            '</option>');
                    }
                    method.change();
                }
            });

            $("#modalLabel").html('Create Product')
            $("#page").html(data);
            $("#modalForm").modal('show');


        });
    }

    function changeDate() {
        var minToDate = document.getElementById("date_start").value;
        document.getElementById("date_end").setAttribute("min", minToDate);
    }

    // Save Data
    function storeData() {
        var formData = {
            month: $("#month").val(),
            method: $("#method").val(),
            activity: $("#activity").val(),
            date_start: $("#date_start").val(),
            date_end: $("#date_end").val(),
        };

        var v_date_start = document.getElementById('date_start').value;
        var v_date_end = document.getElementById('date_end').value;

        if (($(".form-activity").val() == '') || (!v_date_start || !v_date_end)) {
            alert('please fill the required field');
        } else {
            $.ajax({
                type: "post",
                url: "{{ url('store') }}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $(".btn-close").click();
                    read();
                }
            });
        }
    }

    // Find By Id
    function show(id) {
        $.get("{{ url('show') }}/" + id, {}, function(data, status) {
            $("#modalLabel").html('Edit Product')
            $("#page").html(data);
            $("#modalForm").modal('show');
        });
    }

    // Update Data
    function update(id) {
        var formData = {
            month: $("#month").val(),
            method: $("#method").val(),
            activity: $("#activity").val(),
            date_start: $("#date_start").val(),
            date_end: $("#date_end").val(),
        };

        var v_date_start = document.getElementById('date_start').value;
        var v_date_end = document.getElementById('date_end').value;

        if (($(".form-activity").val() == '') || (!v_date_start || !v_date_end)) {
            alert('please fill the required field');
        } else {
            $.ajax({
                type: "patch",
                url: "{{ url('update') }}/" + id,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $(".btn-close").click();
                    read()
                }
            });
        }
    }

    // Delete Data
    function destroy(id) {
        $.ajax({
            type: "delete",
            url: "{{ url('delete') }}/" + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $(".btn-close").click();
                read()
            }
        });
    }
    </script>
</body>

</html>
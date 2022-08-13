<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-3">
                <select type="text" class="form-control" id="status" onchange="filterActivity()">
                    <option value="">Choose</option>
                    <option value="Berlangsung">Berlangsung</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Akan Datang">Akan Datang</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>Metode</th>
                        <th>Januari</th>
                        <th>Febuari</th>
                        <th>Maret</th>
                        <th>April</th>
                        <th>Mei</th>
                        <th>Juni</th>
                        <!-- <th>Juli</th>
                        <th>Agustus</th>
                        <th>September</th>
                        <th>Oktober</th>
                        <th>November</th>
                        <th>Desember</th> -->
                    </tr>
                </thead>
                <tbody class="text-center" id="list-activity">
                    <!-- <tr>
                        <td>Workshop/ Self Learning</td>
                        <td>
                            <p>A1</p>
                            <p>A2</p>
                            <p>A3</p>
                            <p>A4</p>
                            <p>A5</p>
                        </td>
                        <td>
                            <p>B1</p>
                            <p>B2</p>
                            <p>B3</p>
                            <p>B4</p>
                            <p>B5</p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>B1</p>
                            <p>B2</p>
                            <p>B3</p>
                            <p>B4</p>
                            <p>B5</p>
                            <p>B6</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Sharing Practice/ Professional's Talk</td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>I1</p>
                        </td>
                        <td></td>
                        <td>
                            <p>K1</p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Discussion room</td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>O1</p>
                        </td>
                        <td>
                            <p>P1</p>
                        </td>
                        <td>
                            <p>Q1</p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Coaching</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>W1</p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Coaching</td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>ZA1</p>
                        </td>
                        <td>
                            <p>ZB1</p>
                        </td>
                        <td>
                            <p>ZC1</p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Job Assignment</td>
                        <td colspan="6">Sesuai Penugasan</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        filterActivity();
    });

    function filterActivity(){
        var total_month
        var total_method
        var formData = {
            status: $("#status").val(),
        };

        $.ajax({
            type: "GET",
            url: "{{ url('count_method') }}",
            contentType: "application/json",
            dataType: 'json',
            success: function(response) {
                total_method = response['data'].total_method;
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ url('count_month') }}",
            contentType: "application/json",
            dataType: 'json',
            success: function(response) {
                total_month = response['data'].total_month;
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ url('activity_list') }}",
            contentType: "application/json",
            dataType: 'json',
            data: formData,
            success: function(response) {
                $("#list-activity").html("")
                var html_list_activity = "";
                var loop_month = 1;
                var loop_method = 1;
                var z = 0;
                var total_data = response['data'].length - 1;
                total_month = (total_month-1) + 1;
                var show_method = true;
                var open_td = true;
                var close_tr = false;

                while (total_month != loop_month && total_method != loop_method && z != total_data){
                    if (show_method == true){
                        html_list_activity += "<tr><td>" + response['data'][z].name_methods + "</td>";
                        show_method = false;
                        close_tr = true;
                    }

                    if (loop_month == total_month){
                        loop_month = 1;
                    }
                    
                    if (response['data'][z].id_methods == loop_method) {
                        if (open_td == true){
                            html_list_activity += "<td>";
                            open_td = false;
                        }

                        if (response['data'][z].id_months == loop_month) {
                            html_list_activity += "<p>" + response['data'][z].activity + "</p><p>" + response['data'][z].date_start + " s/d " + response['data'][z].date_end + "</p>";
                            z++;
                        } else if (response['data'][z].id_months != loop_month){
                            if ((response['data'][z].id_months-loop_month) != 1){
                                loop_month++;
                                html_list_activity += "</td>";
                                open_td = true;
                            } else {
                                loop_month++;
                                html_list_activity += "</td>";
                                open_td = true;
                            }
                        } 
                        // else {
                        //     html_list_activity += "<p>" + response['data'][z].activity + " " + response['data'][z].date_start + "-" + response['data'][z].date_end + "</p></td>";
                        //     loop_month++;
                        //     z++;
                        // }
                        // show_method = true;
                        // html_list_activity += "<tr>";
                    } else if (response['data'][z].id_methods != loop_method) {
                        if ((response['data'][z].id_methods-loop_method) != 1){
                            loop_method++;
                        } else {
                            if (close_tr == true){
                                loop_method++;
                                html_list_activity += "</tr>";
                                show_method = true;
                                loop_month = 1;
                                close_tr = false;
                                open_td = true;
                            }
                            
                            
                            if (show_method == true){
                                html_list_activity += "<tr><td>" + response['data'][z].name_methods + "</td>";
                                show_method = false;
                            }

                            if (open_td == true){
                                html_list_activity += "<td>";
                                open_td = false;
                            }

                            if (response['data'][z].id_months == loop_month) {
                                html_list_activity += "<p>" + response['data'][z].activity + "</p><p>" + response['data'][z].date_start + " s/d " + response['data'][z].date_end + "</p>";
                                z++;
                            } else if (response['data'][z].id_months != loop_month){
                                if ((response['data'][z].id_months-loop_month) != 1){
                                    loop_month++;
                                    html_list_activity += "b</td>";
                                    open_td = true;
                                } else {
                                    loop_month++;
                                    html_list_activity += "a</td>";
                                    open_td = true;
                                }
                            } 
                        }
                    }
                }

                html_list_activity += '<tr><td>Job Assignment</td><td colspan="'+(total_month)+'">Sesuai Penugasan</td></tr>'
                $("#list-activity").append(html_list_activity);

                // for (var z = 0; z < response['data'].length; z++) {
                //     html_list_activity += "<tr><td>" + response['data'][z].name_methods + "</td>";
                //     if (response['data'][z].id_methods == response['data'][z + 1].id_methods) {
                //         html_list_activity += "<td>";
                //         if (response['data'][z].id_months == response['data'][z + 1].id_months) {
                //             html_list_activity += "<p>" + response['data'][z].activity + " " + response['data'][z].date_start + "-" + response['data'][z].date_end + "</p>";
                //         } else if (response['data'][z].id_months != response['data'][z + 1].id_months) {
                //             html_list_activity += "</td>";
                //         } else {
                //             html_list_activity += "<p>" + response['data'][z].activity + " " + response['data'][z].date_start + "-" + response['data'][z].date_end + "</p></td>";
                //         }
                //     } else if ((response['data'][z].id_methods == response['data'][z + 1].id_methods) && (response['data'][z].id_months != response['data'][z + 1].id_months)) {
                //         html_list_activity += "<td><p>" + response['data'][z].activity + "(" + response['data'][z].date_start + "-" + response['data'][z].date_end + ")</p></td>";
                //     }
                //     html_list_activity += "</tr>";
                // }
                
            }
        });
    }
    </script>
</body>

</html>
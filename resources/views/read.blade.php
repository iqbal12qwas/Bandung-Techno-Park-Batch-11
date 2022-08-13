<div class="table-responsive">
    <table class="table table-bordered" id="table">
        <thead class="text-center">
            <tr>
                <!-- <th>No</th> -->
                <th>Method</th>
                <th>Month</th>
                <th>Activity</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($data as $item => $key)
            <tr>
                <td>{{ $key->name_methods }}</td>
                <td>{{ $key->name_months }}</td>
                <td>{{ $key->activity }}</td>
                <td>{{ $key->date_start }}</td>
                <td>{{ $key->date_end }}</td>
                <td>
                    <button class="btn btn-warning" onClick="show({{ $key->id }})">Edit</button>
                    <button class="btn btn-danger" onClick="destroy({{ $key->id }})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
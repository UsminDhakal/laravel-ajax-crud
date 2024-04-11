@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Enter Your Information</h2>
        <form id="formSubmit">
            <input type="text" id="id" name="id" style="display: block">
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group mb-3">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" placeholder="Enter your address"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <br>
        <br>
        <br>
        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="dataOfTable">

            </tbody>
        </table>




    </div>

    <script>
        $(document).ready(function() {

            function getDataHai() {
                var content = $('#dataOfTable');
                content.empty();
                $.get("{{ route('data.get.getData') }}", function(data, status) {
                    console.log(data);
                    var content = $('#dataOfTable');
                    var row = '';
                    data.data.forEach((element, index) => {
                        row = '<tr>' +
                            '<td>' + ++index + '</td>' +
                            '<td>' + element.name + '</td>' +
                            '<td>' + element.address + '</td>' +
                            '<td>' + element.email + '</td>' +
                            '<td class="d-flex gap-3"> <button class="btn btn-danger deleteButton" data-id="' +
                            element
                            .id +
                            '">Delete</button> <button class="btn btn-primary editButton" data-id="' +
                            element
                            .id +
                            '">Edit</button></td>' +
                            '</tr>';
                        content.append(row);
                    });
                });
            }

            getDataHai();

            $('#formSubmit').submit(function(e) {
                e.preventDefault();

                var id = $('#id').val();
                var id = null;

                var data = $(this).serializeArray();

                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "{{ route('submit.form') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status) {
                            $('#formSubmit').trigger('reset');
                            console.log('Form Submitted');
                            getDataHai();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                    }
                });
            });



            $('#dataOfTable').on('click', '.editButton', function(e) {
                var id = $(this).data('id');
                var routeName = "{{ route('data.edit.data.data', ['__ID__']) }}".replace(
                    '__ID__', id);

                $.get(routeName, function(data, status) {
                    console.log(data);
                    $('#id').val(data.data.id);
                    $('#name').val(data.data.name);
                    $('#email').val(data.data.email);
                    $('#address').val(data.data.address);
                })
            })

            $('#dataOfTable').on('click', '.deleteButton', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var routeName = "{{ route('data.delete.data.data', ['__ID__']) }}".replace(
                    '__ID__', id);

                $.get(routeName, function(data, status) {
                    getDataHai();
                })
            })
        });
    </script>
@endsection

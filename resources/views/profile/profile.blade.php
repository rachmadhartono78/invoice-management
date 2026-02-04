@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Profile')
@section('content')
<div class="card mb-4">
    <h5 class="card-header">Profile Details</h5>
    <!-- Account -->
    <hr class="my-0">
    <div class="card-body">
        <form id="formAccountSettings" class="" novalidate>
            <input type="hidden" id="edit_id">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukan Nama" required>
                    <div class="invalid-feedback">Tidak boleh kosong</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukan Username" required>
                    <div class="invalid-feedback">Tidak boleh kosong</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukan Username" required>
                    <div class="invalid-feedback">Tidak boleh kosong</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="invalid-feedback">Tidak boleh kosong</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="department" class="form-label">Department</label>
                    <select id="department" name="department" class="form-control" required readonly>
                    </select>
                    <div class="invalid-feedback">Tidak boleh kosong</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="level" class="form-label">Level</label>
                    <select id="level" name="level" class="form-control" required readonly>
                    </select>
                    <div class="invalid-feedback">Tidak boleh kosong</div>
                </div>
            </div>
            <div class="mt-1">
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Save changes</button>
                <button type="reset" class="btn btn-label-secondary waves-effect">Cancel</button>
            </div>
            <input type="hidden">
        </form>
    </div>
    <!-- /Account -->
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script>
    var accountSetting = $("#formAccountSettings");
    let account = {!! json_encode(session('data')) !!}

    getDataUser(account.id);
    console.log(account);

    function getDepartement(element, id) {
        $.ajax({
            url: "{{url('api/department')}}/" + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                $(`#${element}`).prepend(tem);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function getLevel(element, id) {
        $.ajax({
            url: "{{url('api/level')}}/" + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                $(`#${element}`).prepend(tem);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function getDataUser(id) {
        $.ajax({
            url: "{{url('api/user')}}/" + id,
            type: "get",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                let data = response.data;
                $('#edit_id').val(data.id);
                $('#name').val(data.name)
                $('#username').val(data.username)
                $('#email').val(response.data.email)
                getDepartement('department', data.department.id)
                getLevel('level', data.level.id)
            },
            error: function(errors) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errors.responseJSON.message,
                })
            }
        });
    }
    

    Array.prototype.slice.call(accountSetting).forEach(function(form) {
        form.addEventListener(
            "submit",
            function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // Submit your form
                    event.preventDefault();
                    let id = $('#edit_id').val();
                    let name = $('#name').val();
                    let email = $('#email').val();
                    let password = $('#password').val();
                    let department = $('#department').val();
                    let level = $('#level').val();
                    let data = {};
                    data.name = name;
                    data.email = email;
                    data.password = password;
                    data.level_id = parseInt(level);
                    data.department_id = parseInt(department);
                    data.status = 'Active';
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" + '/api/user/' + id,
                        type: "PATCH",
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Memperbarui Profile',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            })
                            .then((result) => {
                                window.location.href = "/"
                            });

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr?.responseJSON?.message,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            })
                        }
                    });
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
</script>
@endsection
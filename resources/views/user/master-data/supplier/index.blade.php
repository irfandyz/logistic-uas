@extends('user.template')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Supplier Data</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addSupplierModal"
                                        class="btn btn-success"><i class="fas fa-plus"></i> &nbsp; Add Data</a>
                                    <form action="{{ asset('supplier') }}" method="get">
                                        <div class="input-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search" name="keyword"
                                                value="{{ request('keyword') }}">
                                            <button class="input-group-text" id="basic-addon1"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr class="mb-3">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier Name</th>
                                            <th>Phone No.</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ ($suppliers->currentpage()-1) * $suppliers->perpage() + $loop->iteration }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                <td>{{ $supplier->phone }}</td>
                                                <td>{{ $supplier->email }}</td>
                                                <td>{{ $supplier->address }}</td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editSupplierModal"
                                                        onclick="editSupplier('{{ $supplier->id }}')"
                                                        class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="#" onclick="deleteSupplier('{{ $supplier->id }}')"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($suppliers->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $suppliers->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('supplier') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone No.</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('supplier') }}" id="editSupplierForm" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone No.</label>
                        <input type="text" class="form-control" id="phone_edit" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_edit" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address_edit" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editSupplier(id) {
        $.ajax({
            url: '{{ asset('supplier/find') }}' + '/' + id,
            type: 'GET',
            success: function(response) {
                $('#name_edit').val(response.name);
                $('#phone_edit').val(response.phone);
                $('#email_edit').val(response.email);
                $('#address_edit').val(response.address);
                $('#editSupplierForm').attr('action', '{{ asset('supplier') }}' + '/' + id);
                $('#editSupplierModal').modal('show');
            }
        });
    }

    function deleteSupplier(id) {
        swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ asset('supplier') }}' + '/' + id;
            }
        });
    }
</script>

@endsection

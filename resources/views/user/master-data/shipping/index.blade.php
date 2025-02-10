@extends('user.template')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Shipping Data</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addShippingModal"
                                        class="btn btn-success"><i class="fas fa-plus"></i> &nbsp; Add Data</a>
                                    <form action="{{ asset('shipping') }}" method="get">
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
                                            <th>Shipping Name</th>
                                            <th>Person in Charge</th>
                                            <th>Transportation</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shippings as $shipping)
                                            <tr>
                                                <td>{{ ($shippings->currentpage()-1) * $shippings->perpage() + $loop->iteration }}</td>
                                                <td>{{ $shipping->name }}</td>
                                                <td>{{ $shipping->person_in_charge }}</td>
                                                <td>{{ $shipping->transportation }}</td>
                                                <td>{{ $shipping->description }}</td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editShippingModal"
                                                        onclick="editShipping('{{ $shipping->id }}')"
                                                        class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="#" onclick="deleteShipping('{{ $shipping->id }}')"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $shippings->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<div class="modal fade" id="addShippingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Shipping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('shipping') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Shipping Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="person_in_charge" class="form-label">Person in Charge</label>
                        <input type="text" class="form-control" id="person_in_charge" name="person_in_charge" required>
                    </div>
                    <div class="mb-3">
                        <label for="transportation" class="form-label">Transportation</label>
                        <input type="text" class="form-control" id="transportation" name="transportation" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editShippingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Shipping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('shipping') }}" id="editShippingForm" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Shipping Name</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="person_in_charge" class="form-label">Person in Charge</label>
                        <input type="text" class="form-control" id="person_in_charge_edit" name="person_in_charge" required>
                    </div>
                    <div class="mb-3">
                        <label for="transportation" class="form-label">Transportation</label>
                        <input type="text" class="form-control" id="transportation_edit" name="transportation" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description_edit" name="description"></textarea>
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
    function editShipping(id) {
        $.ajax({
            url: '{{ asset('shipping/find') }}' + '/' + id,
            type: 'GET',
            success: function(response) {
                $('#name_edit').val(response.name);
                $('#person_in_charge_edit').val(response.person_in_charge);
                $('#transportation_edit').val(response.transportation);
                $('#description_edit').val(response.description);
                $('#editShippingForm').attr('action', '{{ asset('shipping') }}' + '/' + id);
                $('#editShippingModal').modal('show');
            }
        });
    }

    function deleteShipping(id) {
        swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ asset('shipping') }}' + '/' + id;
            }
        });
    }
</script>

@endsection

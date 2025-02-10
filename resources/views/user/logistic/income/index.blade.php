@extends('user.template')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Incoming Data</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addIncomingItemModal"><i class="fas fa-plus"></i>
                                        &nbsp; Add Data</a>
                                    <form action="{{ asset('incoming-item') }}" method="get">
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
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Invoice Number</th>
                                                <th>Items</th>
                                                <th>Supplier</th>
                                                <th>Total Value</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($item->date_received)) }}</td>
                                                    <td>{{ $item->invoice_number }}</td>
                                                    <td>
                                                        <a href="{{ asset('incoming-item/detail/' . $item->id) }}" class="btn btn-primary">Detail</a>
                                                    </td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#detailSupplierModal" class="text-primary"
                                                        onclick="detailSupplier('{{ $item->supplier->id }}')"><i
                                                            class="fas fa-circle-info"></i></a> &nbsp;
                                                    {{ $item->supplier->name }} </td>
                                                    <td>Rp. {{ number_format($item->total_value, 0, ',', '.') }}</td>
                                                    <td>
                                                        <a href="#" onclick="editIncomingItem('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#editIncomingItemModal"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <a href="#" onclick="deleteItem('{{ $item->id }}')"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if ($items->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $items->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="addIncomingItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Incoming Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ asset('incoming-item') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Date Received</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="date_received" name="date_received" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editIncomingItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Incoming Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ asset('incoming-item') }}" id="editIncomingItemForm" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="name" class="form-label">Date Received</label>
                            <input type="date" class="form-control" id="date_received_edit" name="date_received" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number_edit" name="invoice_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id_edit" class="form-control">
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Edit Incoming Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="detailSupplierModal" tabindex="-1" aria-labelledby="detailSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailSupplierModalLabel">Detail Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Name</h6>
                            <p style="width: 300px;" id="supplier-name"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Address</h6>
                            <p style="width: 300px;" id="supplier-address"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Phone</h6>
                            <p style="width: 300px;" id="supplier-phone"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Email</h6>
                            <p style="width: 300px;" id="supplier-email"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function detailSupplier(id) {
            $.ajax({
                url: '{{ asset('supplier/find') }}/' + id,
                type: 'GET',
                success: function(response) {
                    $('#supplier-name').text(': ' + response.name);
                    $('#supplier-address').text(': ' + response.address);
                    $('#supplier-phone').text(': ' + response.phone);
                    $('#supplier-email').text(': ' + response.email);
                }
            });
        }

        function deleteItem(id) {
            swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ asset('incoming-item') }}' + '/' + id;
                }
            });
        }

        function editIncomingItem(id) {
        $.ajax({
            url: '{{ asset('incoming-item/find') }}' + '/' + id,
            type: 'GET',
            success: function(response) {
                $('#date_received_edit').val(response.date_received);
                $('#invoice_number_edit').val(response.invoice_number);
                $('#supplier_id_edit').val(response.supplier_id);
                $('#editIncomingItemForm').attr('action', '{{ asset('incoming-item') }}' + '/' + id);
                $('#editIncomingItemModal').modal('show');
            }
        });
    }
    </script>
@endsection

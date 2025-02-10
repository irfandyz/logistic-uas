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
                                                <th>Customer</th>
                                                <th>Shipping</th>
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
                                                        <a href="{{ asset('outgoing-item/detail/' . $item->id) }}" class="btn btn-primary">Detail</a>
                                                    </td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#detailCustomerModal" class="text-primary"
                                                        onclick="detailCustomer('{{ $item->customer->id }}')"><i
                                                            class="fas fa-circle-info"></i></a> &nbsp;
                                                    {{ $item->customer->name }} </td>
                                                    <td>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#detailShippingModal" class="text-primary"
                                                            onclick="detailShipping('{{ $item->shipping->id }}')"><i
                                                                class="fas fa-circle-info"></i></a> &nbsp;
                                                        {{ $item->shipping->name }} </td>
                                                    <td>Rp. {{ number_format($item->total_value, 0, ',', '.') }}</td>
                                                    <td>
                                                        <a href="#" onclick="editOutgoingItem('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#editOutgoingItemModal"
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
                    <form action="{{ asset('outgoing-item') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Date</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Shipping</label>
                            <select name="shipping_id" id="shipping_id" class="form-control">
                                <option value="">Select Shipping</option>
                                @foreach ($shippings as $shipping)
                                    <option value="{{ $shipping->id }}">{{ $shipping->name }}</option>
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
    <div class="modal fade" id="editOutgoingItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Outgoing Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ asset('outgoing-item') }}" id="editOutgoingItemForm" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="name" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date_edit" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number_edit" name="invoice_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id_edit" class="form-control">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Shipping</label>
                            <select name="shipping_id" id="shipping_id_edit" class="form-control">
                                <option value="">Select Shipping</option>
                                @foreach ($shippings as $shipping)
                                    <option value="{{ $shipping->id }}">{{ $shipping->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Edit Outgoing Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="detailCustomerModal" tabindex="-1" aria-labelledby="detailCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailCustomerModalLabel">Detail Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Name</h6>
                            <p style="width: 300px;" id="customer-name"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Address</h6>
                            <p style="width: 300px;" id="customer-address"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Phone</h6>
                            <p style="width: 300px;" id="customer-phone"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Email</h6>
                            <p style="width: 300px;" id="customer-email"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailShippingModal" tabindex="-1" aria-labelledby="detailShippingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailShippingModalLabel">Detail Shipping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Name</h6>
                            <p style="width: 300px;" id="shipping-name"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Person In Charge</h6>
                            <p style="width: 300px;" id="shipping-person_in_charge"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Transportation</h6>
                            <p style="width: 300px;" id="shipping-transportation"></p>
                        </div>
                        <div class="d-flex justify-content-between gap-2">
                            <h6>Description</h6>
                            <p style="width: 300px;" id="shipping-description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function detailCustomer(id) {
            $.ajax({
                url: '{{ asset('customer/find') }}/' + id,
                type: 'GET',
                success: function(response) {
                    $('#customer-name').text(': ' + response.name);
                    $('#customer-address').text(': ' + response.address);
                    $('#customer-phone').text(': ' + response.phone);
                    $('#customer-email').text(': ' + response.email);
                }
            });
        }

        function detailShipping(id) {
            $.ajax({
                url: '{{ asset('shipping/find') }}/' + id,
                type: 'GET',
                success: function(response) {
                    $('#shipping-name').text(': ' + response.name);
                    $('#shipping-person_in_charge').text(': ' + response.person_in_charge);
                    $('#shipping-transportation').text(': ' + response.transportation);
                    $('#shipping-description').text(': ' + response.description);
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
                    window.location.href = '{{ asset('outgoing-item') }}' + '/' + id;
                }
            });
        }

        function editOutgoingItem(id) {
        $.ajax({
            url: '{{ asset('outgoing-item/find') }}' + '/' + id,
            type: 'GET',
            success: function(response) {
                $('#date_edit').val(response.date);
                $('#invoice_number_edit').val(response.invoice_number);
                $('#customer_id_edit').val(response.customer_id);
                $('#shipping_id_edit').val(response.shipping_id);
                $('#editOutgoingItemForm').attr('action', '{{ asset('outgoing-item') }}' + '/' + id);
                $('#editOutgoingItemModal').modal('show');
            }
        });
    }
    </script>
@endsection

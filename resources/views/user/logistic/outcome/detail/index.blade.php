@extends('user.template')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Outgoing Item Detail</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" onclick="addItem()" data-bs-toggle="modal" data-bs-target="#addItemModal" class="btn btn-success"><i class="fas fa-plus"></i>
                                        &nbsp; Add Data</a>
                                    <form action="{{ asset('outgoing-item/detail/' . $outgoingItem->id) }}" method="get">
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
                                                <th>Code</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ ($items->currentpage() - 1) * $items->perpage() + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $item->item->code }}</td>
                                                    <td>{{ $item->item->name }}</td>
                                                    <td>Rp. {{ number_format($item->item->price, 0, ',', '.') }}
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>
                                                        <a href="#" onclick="editItem('{{ $item->id }}')" data-bs-toggle="modal" data-bs-target="#editItemModal"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <a href="#"
                                                            onclick="deleteItem('{{ $item->id }}')"
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

    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ asset('outgoing-item/detail/' . $outgoingItem->id) }}" id="addItemForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item</label>
                            <select name="item_id" id="item_id" class="form-control" required>
                                <option value="">Select Item</option>
                                @foreach ($itemsData as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ asset('outgoing-item/detail/' . $outgoingItem->id . '/update') }}" id="editItemForm" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item</label>
                            <input type="text" class="form-control" id="edit_item_id" name="item_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Edit Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function editItem(id) {
            $.ajax({
                url: "{{ asset('outgoing-item/detail/' . $outgoingItem->id . '/find') }}" + '/' + id,
                type: 'GET',
                success: function(response) {
                    $('#edit_quantity').val(response.quantity);
                    $('#editItemForm').attr('action', "{{ asset('outgoing-item/detail/' . $outgoingItem->id . '/update') }}" + '/' + id);
                    $('#edit_item_id').val(response.item.name);
                    $('#editItemModal').modal('show');
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
                    window.location.href = '{{ asset('category') }}' + '/' + id;
                }
            });
        }
    </script>
@endsection

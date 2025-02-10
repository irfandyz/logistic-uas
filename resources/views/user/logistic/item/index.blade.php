@extends('user.template')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Item Data</h5>
                                <div class="d-flex gap-2">
                                    <a href="{{ asset('item/create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                                        &nbsp; Add Data</a>
                                    <form action="{{ asset('item') }}" method="get">
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
                                                <th>Stock</th>
                                                <th>Image</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ ($items->currentpage() - 1) * $items->perpage() + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-center">
                                                        @if ($item->image)
                                                            <a class="text-success" href="{{ asset('storage/items/' . $item->image) }}"
                                                                target="_blank"><i class="fas fa-image"></i></a>
                                                        @else
                                                            <span class="text-muted">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->category->name }} </td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>
                                                        <a href="{{ asset('item/' . $item->id . '/edit') }}"
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

    <script>

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
                    window.location.href = '{{ asset('item') }}' + '/' + id;
                }
            });
        }
    </script>
@endsection

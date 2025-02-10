@extends('user.template')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Category Data</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                                        class="btn btn-success"><i class="fas fa-plus"></i> &nbsp; Add Data</a>
                                    <form action="{{ asset('category') }}" method="get">
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
                                @foreach ($categories as $category)
                                    <div class="col-md-4">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h6>{{ $category->name }}</h6>
                                                    <div class="d-flex gap-2">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editCategoryModal"
                                                            onclick="editCategory('{{ $category->id }}')"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <a href="#" onclick="deleteCategory('{{ $category->id }}')"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($categories->isEmpty())
                                    <div class="col-md-12">
                                        <div class="alert alert-info text-center text-white">No data found</div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $categories->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('category') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ asset('category') }}" id="editCategoryForm" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Edit Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function editCategory(id) {
        $.ajax({
            url: '{{ asset('category/find') }}' + '/' + id,
            type: 'GET',
            success: function(response) {
                $('#name_edit').val(response.name);
                $('#editCategoryForm').attr('action', '{{ asset('category') }}' + '/' + id);
                $('#editCategoryModal').modal('show');
            }
        });
    }

    function deleteCategory(id) {
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

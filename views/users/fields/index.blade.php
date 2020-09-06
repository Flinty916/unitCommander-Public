<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Custom Profile Fields
            @can('edit_user_fields')
                <span data-toggle="modal" data-target="#createField" class="btn btn-primary float-md-right">Create Field</span>
            @endcan
        </h1>
        <hr />
        <div class="row">
            @forelse($fields as $field)
                <div class="col-lg-3 col-sm-12">
                    <div class="card">
                        <h3>{{ $field->name }}</h3>
                        <hr class="hr-slim">
                        <p>Data Type: {{ $field->type }}</p>
                        @can('edit_user_fields')
                            <hr class="hr-slim">
                            <form method="POST" action="/users/fields/{{$field->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger confirmation-form">Delete Field</span>
                                <a data-toggle="modal" data-target="#editField"
                                   data-id="{{ $field->id }}" data-name="{{ $field->name }}" data-type="{{ $field->type }}"
                                   class="btn btn-warning">Edit Field</a>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="card">
                        <center>
                            <h3>No Custom Fields Available.</h3>
                        </center>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{--Edit Field--}}
<div class="modal fade" id="editField" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/users/fields/" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Field Name" autocomplete="no" class="@error('name') text-warning @enderror" value="">
                    <select name="type">
                        <option selected disabled>Select Field Data Type</option>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                    </select>
                    <br /><br />
                    <input type="submit" class="btn btn-success btn-block" value="Edit Field"><br />
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editField').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let id = button.data('id')
        let name = button.data('name')
        let type = button.data('type')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Field: ' + name)
        modal.find('.modal-body select').val(type)
        modal.find('.modal-body input[name=name]').val(name)
        modal.find('.modal-body form').attr('action', '/users/fields/' + id)
    })
</script>

{{--Create Field--}}

<div class="modal fade" id="createField" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/users/fields" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="name" placeholder="Field Name" autocomplete="no" class="@error('name') text-warning @enderror" value="{{ old('name') }}">
                    <select name="type">
                        <option selected disabled>Select Field Data Type</option>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                    </select>
                    <br /><br />
                    <input type="submit" class="btn btn-success btn-block" value="Create Field"><br />
                </form>
            </div>
        </div>
    </div>
</div>

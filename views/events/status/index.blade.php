<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Event Join Statuses
            @can('edit_events')
                <span data-toggle="modal" data-target="#createStatus" class="btn btn-primary float-right">Create Status</span>
            @endcan
        </h1>
        <hr />
        <div class="row">
            @forelse($stats as $status)
                <div class="col-lg-3">
                    <div class="card">
                        <center>
                            <h4>{{ $status->name }}</h4>
                            <hr class="hr-slim">
                            <div class="p-2 w-100 rounded" style="background:{{$status->colour}}"></div>
                        </center>
                        @can('edit_events')
                            <hr class="hr-slim">
                            <form method="POST" action="/events/status/{{$status->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger confirmation-form">Delete Status</span>
                                <span data-toggle="modal" data-target="#editStatus"
                                    data-name="{{$status->name}}" data-colour="{{$status->colour}}" data-id="{{$status->id}}"
                                   class="btn btn-success">Edit Status</span>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <center>
                        <h4>No Join Status's Available.</h4>
                    </center>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{--Edit Status--}}

<div class="modal fade" id="editStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Status: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/events/status/">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="" placeholder="Status Name/Label">
                    <input type="color" name="colour" value="" placeholder="Status Colour Code">
                    <br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Edit Status"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editStatus').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var colour = button.data('colour')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Status: ' + name)
        modal.find('.modal-body input[name=name]').val(name)
        modal.find('.modal-body input[name=colour]').val(colour)
        modal.find('.modal-body form').attr('action', '/events/status/' + id)
    })
</script>

{{--Create Status --}}

<div class="modal fade" id="createStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Status: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/events/status">
                    @csrf
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Status Name/Label">
                    <input type="color" name="colour" value="{{ old('colour') }}" placeholder="Status Colour Code">
                    <br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Create Status"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

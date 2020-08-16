<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Positions
            @can('edit_positions')
                <span class="float-right btn btn-primary" data-toggle="modal" data-target="#createPosition">Create Position</span>
            @endcan
        </h1>
        <hr/>
        <div class="row">
            @forelse($positions as $position)
                <div class="col-lg-4 col-sm-12">
                    <div class="card m-1">
                        <h4><a href="/positions/{{$position->id}}">{{ $position->name }}</a></h4>
                        <hr class="hr-slim">
                        <div class="row">
                            <div class="col">
                                <p class="text-justify">{{ $position->description }}</p>
                            </div>
                        </div>
                        @can('edit_positions')
                            <hr class="hr-slim">
                            <form method="POST" action="positions/{{$position->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger delete confirmation-form">Delete Position</span>
                                <a data-toggle="modal" data-target="#editPosition" class="btn-warning btn"
                                   data-id="{{$position->id}}" data-name="{{$position->name}}"
                                   data-description="{{$position->description}}">Edit Position</a>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="card">
                        <center>
                            <h3>No Positions Available.</h3>
                        </center>
                    </div>
                </div>
            @endforelse
        </div>
        {{$positions->links()}}
    </div>
</div>

{{--Modals--}}

{{--New Rank--}}
<div class="modal fade" id="createPosition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/positions" class="form-main">
                    @csrf
                    <input type="text" placeholder="Position Name" autocomplete="no" name="name" value="{{ old('name') }}">
                    <textarea placeholder="Position Description" name="description" rows="10"
                              cols="5">{{ old('description') }}</textarea><br/>
                    <input type="submit" value="Create Position" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Rank--}}

<div class="modal fade" id="editPosition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Position: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Position Name" autocomplete="no"
                           value="">
                    <textarea name="description" rows="10" cols="5"
                    ></textarea>
                    <input type="submit" class="btn btn-warning btn-block" value="Update Position"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editPosition').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var position_id = button.data('id')
        console.log(position_id)
        var position_name = button.data('name')
        var position_desc = button.data('description')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Position: ' + position_name)
        modal.find('.modal-body input[name=name]').val(position_name)
        modal.find('.modal-body textarea').val(position_desc)
        modal.find('.modal-body form').attr('action', '/positions/' + position_id)
    })
</script>

<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{ $position->name }}</h1>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-sm-12 my-auto">
                <p>{{ $position->description }}</p>
                @can('edit_positions')
                    <form method="POST" action="/positions/{{$position->id}}">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger delete confirmation-form">Delete Position</span>
                        <a data-toggle="modal" data-target="#editPosition" class="btn-warning btn"
                           data-id="{{$position->id}}" data-name="{{$position->name}}"
                           data-description="{{$position->description}}" data-image="{{$position->image}}">Edit Position</a>
                    </form>
                @endcan
            </div>
        </div>
        <hr class="hr-slim">
        <h3>Users with this Position:</h3>
        <div class="row">
            @forelse($position->users as $user)
                <div class="col-lg-3 col-sm-12">
                    <div class="card m-1">
                        <center>
                            @if($user->name)
                                <h4>{{ $user->name }}</h4>
                            @else
                                <h4>{{ $user->nickname }}</h4>
                            @endif
                            <hr class="hr-slim">
                            <a href="/profile/{{$user->id}}" class="btn btn-info btn-block">Profile</a>
                        </center>
                    </div>
                </div>
            @empty
                <div class="col card m-1">
                    <center>
                        <h3>No Users Available.</h3>
                    </center>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{--Edit--}}

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


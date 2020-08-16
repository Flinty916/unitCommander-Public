<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{ $unit->name }}</h1>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-sm-12 my-auto">
                <p>{{ $unit->callsign }}</p>
                <p>Led By: <a href="/profile/{{$unit->leader_id}}">
                        @if(\App\User::find($unit->leader_id)->name)
                            {{ \App\User::find($unit->leader_id)->name }}
                        @else
                            {{ \App\User::find($unit->leader_id)->nickname }}
                        @endif
                    </a></p>
                @can('edit_unit')
                    <form method="POST" action="units/{{$unit->id}}">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger delete confirmation-form">Delete Unit</span>
                        <a data-toggle="modal" data-target="#editUnit" class="btn-warning btn"
                           data-id="{{$unit->id}}" data-name="{{$unit->name}}"
                           data-callsign="{{$unit->callsign}}" data-leader="{{$unit->leader_id}}">Edit Unit</a>
                    </form>
                @endcan
            </div>
        </div>
        <hr class="hr-slim">
        <h3>Users in this Unit:</h3>
        <div class="row">
            @forelse($unit->users as $user)
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

<div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Unit: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Unit Name" autocomplete="no" value="">
                    <input type="text" name="callsign" placeholder="Unit Callsign" autocomplete="no" value="">
                    <select class="form-control" name="leader_id">
                        @forelse(\App\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} / {{ $user->nickname }}</option>
                        @empty
                            <option>No Users Available.</option>
                        @endforelse
                    </select><br />
                    <input type="submit" class="btn btn-warning btn-block" value="Update Unit"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editUnit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var unit_id = button.data('id')
        var unit_name = button.data('name')
        var unit_callsign = button.data('callsign')
        var unit_leader = button.data('leader')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Unit: ' + unit_name)
        modal.find('.modal-body input[name=name]').val(unit_name)
        modal.find('.modal-body input[name=callsign]').val(unit_callsign)
        modal.find('.modal-body select').val(unit_leader)
        modal.find('.modal-body form').attr('action', '/units/' + unit_id)
    })
</script>

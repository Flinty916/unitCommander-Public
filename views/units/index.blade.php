<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Units
            @can('edit_unit')
                <span class="float-right btn btn-primary" data-toggle="modal"
                      data-target="#createUnit">Create Unit</span>
            @endcan
        </h1>
        <hr/>
        <div class="row">
            @forelse($units as $unit)
                <div class="col-lg-4 col-sm-12">
                    <div class="card m-1">
                        <h4><a href="/units/{{$unit->id}}">{{ $unit->name }}</a></h4>
                        <hr class="hr-slim">
                        <div class="row">
                            <div class="col">
                                <p class="text-justify">{{ $unit->callsign }}<span class="float-right">{{\App\User::find($unit->leader_id)->name}}</span></p>
                            </div>
                        </div>
                        @can('edit_unit')
                            <hr class="hr-slim">
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
            @empty
                <div class="col">
                    <div class="card">
                        <center>
                            <h3>No Units Available.</h3>
                        </center>
                    </div>
                </div>
            @endforelse
        </div>
        {{$units->links()}}
    </div>
</div>

{{--Modals--}}

{{--New Rank--}}
<div class="modal fade" id="createUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/units" class="form-main">
                    @csrf
                    <input type="text" placeholder="Unit Name" autocomplete="no" name="name" value="{{ old('name') }}">
                    <input type="text" placeholder="Unit Callsign" autocomplete="no" name="callsign" value="{{ old('callsign') }}">
                    <select class="form-control" name="leader_id">
                        @forelse(\App\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} / {{ $user->nickname }}</option>
                        @empty
                            <option>No Users Available.</option>
                        @endforelse
                    </select><br />
                    <input type="submit" value="Create Unit" class="btn btn-success btn-block"><br />
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Rank--}}

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

<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        @auth
            @if((Auth::id() == $profile->id || Auth::user()->can('edit_profiles')) && (empty($profile->name)))
                <a data-toggle="modal" data-target="#updateModal" style="cursor:pointer;">
                    <div class="alert alert-danger" role="alert">
                        This Profile is Incomplete. Update Now.
                    </div>
                </a>
            @endif
        @endauth
        <h1>Player Profile</h1>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p class="display-4 my-auto" style="margin: 0;">
                    @if($profile->name)
                        {{ $profile->name }}
                    @else
                        {{ $profile->nickname }}
                    @endif
                </p>
                @if($profile->name)
                    <span class="font-italic">{{ $profile->nickname }}</span>
                @endif
                <p>Steam Profile: <a href="{{ $profile->profile_url }}">Click Here</a><br/>
                    @auth
                        @if((Auth::id() == $profile->id || Auth::user()->can('edit_profiles')))
                            <a data-toggle="modal" data-target="#updateModal" style="cursor:pointer;">
                                Update Profile
                            </a>
                        @endif
                    @endauth
                </p>
                <p>
                    @forelse(\App\User::find($profile->id)->roles as $role)
                        <span class="badge-pill badge-success m-1 d-block d-sm-inline">
                            @can('view_details_roles')
                                <a href="/roles/{{$role->id}}">
                            @endcan
                                <i class="fas fa-circle"></i> {{$role->label}}
                                    @can('view_details_roles')
                            </a>
                            @endcan
                        </span>
                    @empty
                    @endforelse
                    @can('assign_role')
                        <span class="badge-pill badge-secondary d-block d-sm-inline"><a
                                data-toggle="modal" data-target="#roleModal" style="cursor: pointer;"><i
                                    class="fas fa-plus"></i> Assign Role</a></span>
                    @endcan
                </p>
            </div>
            <div class="col-lg-6 col-sm-12 d-none d-lg-block">
                <img src="{{ $profile->avatar }}" class="float-right avatar-thumb">
            </div>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-3 col-sm-12">
            <div class="section">
                <div class="section-header">
                    RANK
                </div>
                <center>
                    @if($profile->rank_id)
                        <a href="/ranks/{{$profile->rank_id}}">
                            <img src="{{ \App\Rank::getImage($profile->rank_id) }}" class="avatar-thumb">
                            <br/>
                            <br/>
                            <h4>{{ \App\Rank::getName($profile->rank_id) }}</h4>
                        </a>
                        @can('give_rank')
                            <form method="POST" action="/profile/{{$profile->id}}/remove/rank">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-outline-danger confirmation-form" value="X">
                            </form>
                        @endcan
                    @else
                        <p>No Rank Available.</p>
                    @endif
                    @can('give_rank')
                        <hr class="hr-slim">
                        <a data-toggle="modal" data-target="#rankModal" class="btn btn-outline-success">Change
                            Rank</a>
                    @endcan
                </center>
            </div>
            <br/>
            <div class="section">
                <div class="section-header">
                    Positions
                </div>
                <center>
                    @forelse($profile->positions as $position)
                        <div class="row">
                            <div class="col"><p>{{ $position->name }}</p></div>
                            @can('give_position')
                                <div class="col">
                                    <form method="POST"
                                          action="/profile/{{$position->id}}/{{$profile->id}}/remove/position">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-outline-danger p-1 confirmation-form"
                                               value="Remove">
                                    </form>
                                </div>
                            @endcan
                        </div>
                    @empty
                        <p>No Positions Available.</p>
                    @endforelse
                    @can('give_position')
                        <hr class="hr-slim">
                        <a data-toggle="modal" data-target="#positionModal" class="btn btn-outline-success">Assign
                            Position</a>
                    @endcan
                </center>
            </div>
            <br/>
            <div class="section">
                <div class="section-header">
                    EXTRA FIELDS
                </div>
                <center>
                    <table class="table">
                        <tr>
                            <th scope="col">Field Name</th>
                            <th scope="col">Value</th>
                            @can('give_user_fields')
                                <th scope="col">Actions</th>
                            @endcan
                        </tr>
                        @forelse($profile->custom_fields as $field)
                            <tr>
                                <td>{{ $field->name }}</td>
                                <td>{{ $field->pivot->value }}</td>
                                @can('give_user_fields')
                                    <td>
                                        <form method="POST"
                                              action="/profile/{{$field->id}}/{{ $profile->id }}/remove/field">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-outline-danger delete confirmation-form"
                                                   value="X">
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <p>No Custom Fields Available.</p>
                        @endforelse
                    </table>
                    @can('give_user_fields')
                        <hr class="hr-slim">
                        <a data-toggle="modal" data-target="#fieldModal" class="btn btn-outline-success">Assign
                            Field</a>
                    @endcan
                </center>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="section">
                <div class="section-header">
                    Awards
                </div>
                <div class="row">
                    @forelse($profile->awards as $award)
                        <div class="col-lg-2 col-sm-12">
                            <a href="/awards/{{$award->id}}">
                                <center>
                                    <img src="{{ $award->image }}" style="max-width: 150px"><br/>
                                    <p>{{ $award->name }}</p>
                                    @can('give_award')
                                        <form method="POST"
                                              action="/profile/{{$award->id}}/{{$profile->id}}/remove/award">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-outline-danger confirmation-form"
                                                   value="X">
                                        </form>
                                    @endcan
                                </center>
                            </a>
                        </div>
                    @empty
                        <div class="col-lg-12 col-sm-12">
                            <p>No Awards Available.</p>
                        </div>
                    @endforelse
                </div>
                @can('give_award')
                    <hr class="hr-slim">
                    <a data-toggle="modal" data-target="#awardModal" class="btn btn-outline-success">Assign Award</a>
                @endcan
            </div>
            <br/>
            <div class="section">
                <div class="section-header">
                    Training Accomplishments
                </div>
                <div class="row">
                    @forelse($profile->trainings as $training)
                        <div class="col-lg-2 col-sm-12">
                            <a href="/training/{{$training->id}}">
                                <center>
                                    <img src="{{ $training->image }}" style="max-width: 150px"><br/>
                                    <p>{{ $training->name }}</p>
                                    @can('give_award')
                                        <form method="POST"
                                              action="/profile/{{$training->id}}/{{$profile->id}}/remove/training">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-outline-danger confirmation-form"
                                                   value="X">
                                        </form>
                                    @endcan
                                </center>
                            </a>
                        </div>
                    @empty
                        <div class="col-lg-12 col-sm-12">
                            <p>No Training Accomplishments Available.</p>
                        </div>
                    @endforelse
                </div>
                @can('give_training')
                    <hr class="hr-slim">
                    <a data-toggle="modal" data-target="#trainingModal" class="btn btn-outline-success ">Give
                        Training</a>
                @endcan
            </div>
            <br/>
            <div class="section">
                <div class="section-header">
                    Units
                </div>
                <div class="row">
                    @forelse($profile->units as $unit)
                        <div class="col-lg-2 col-sm-12">
                            <a href="/units/{{$unit->id}}">
                                <center>
                                    <p>{{ $unit->name }}</p>
                                    @can('give_award')
                                        <form method="POST"
                                              action="/profile/{{$unit->id}}/{{$profile->id}}/remove/unit">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-outline-danger confirmation-form"
                                                   value="X">
                                        </form>
                                    @endcan
                                </center>
                            </a>
                        </div>
                    @empty
                        <div class="col-lg-12 col-sm-12">
                            <p>No Units Available.</p>
                        </div>
                    @endforelse
                </div>
                @can('give_unit')
                    <hr class="hr-slim">
                    <a data-toggle="modal" data-target="#unitModal" class="btn btn-outline-success">Assign Unit</a>
                @endcan
            </div>
            <br/>
            <div class="section">
                <div class="section-header">
                    Service Records
                </div>
                <div class="records table-responsive">
                    <table class="table">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                        </tr>
                        @forelse($profile->logs as $log)
                            <tr>
                                <th scope="row">{{$log->created_at->format('d/m/Y')}}</th>
                                <td>{{ $log->description }}</td>
                            </tr>
                        @empty
                            <center>
                                <p>No History</p>
                            </center>
                        @endforelse
                    </table>
                </div>
            </div>
            <br/>
            <div class="section">
                <div class="section-header">
                    Attendance Records
                </div>
                <div class="records table-responsive">
                    <table class="table">
                        <tr>
                            <th scope="col">Event Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                        </tr>
                        @forelse($events as $event)
                            <tr>
                                <th scope="row"><a href="/events/{{$event->id}}">{{$event->name}}</a></th>
                                <td>{{$event->date->format('d/m/Y')}}</td>
                                <td><span class="p-2 btn"
                                          style="background: {{\App\EventJoinStatus::find($event->pivot->status_id)->colour}}"></span>
                                    <span class="d-none d-md-inline-block">{{ \App\EventJoinStatus::find($event->pivot->status_id)->name }}</span>
                                </td>
                            </tr>
                        @empty
                            <center>
                                <p>No History</p>
                            </center>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{--Modals --}}

{{--Rank Modal--}}
<div class="modal fade" id="rankModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Rank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/rank">
                    @csrf
                    @method('PUT')
                    <select class="selectpicker" name="rank_id">
                        @foreach(\App\Rank::all() as $rank)
                            @if($rank->id == $profile->rank_id)
                                <option value="{{ $rank->id }}" selected>{{$rank->name}}</option>
                            @else
                                <option value="{{ $rank->id }}">{{$rank->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('rank_id')
                    <p class="text-danger">You must select a rank.</p>
                    @enderror
                    <br/>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Assign Rank"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
{{--Awards Modal--}}

<div class="modal fade" id="awardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Award</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/award">
                    @csrf
                    @method('PUT')
                    <select class="selectpicker" name="award">
                        @foreach(\App\Award::all() as $award)
                            <option value="{{ $award->id }}">{{$award->name}}</option>
                        @endforeach
                    </select>
                    @error('award')
                    <p class="text-danger">You must select an Award.</p>
                    @enderror
                    <br/>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Give Award"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Positions Modal--}}

<div class="modal fade" id="positionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/position">
                    @csrf
                    @method('PUT')
                    <select class="selectpicker" name="position">
                        @foreach(\App\Position::all() as $position)
                            <option value="{{ $position->id }}">{{$position->name}}</option>
                        @endforeach
                    </select>
                    @error('position')
                    <p class="text-danger">You must select an Position.</p>
                    @enderror
                    <br/>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Assign Position"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Custom Field Modal--}}

<div class="modal fade" id="fieldModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/fields"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <select name="field" id="field">
                        @forelse(\App\UserField::all() as $field)
                            <option value="{{$field->id}}" data-type="{{$field->type}}">{{$field->name}}</option>
                        @empty
                            <option disabled selected>No Fields Available</option>
                        @endforelse
                    </select>
                    <input type="text" name="value" class="update-type" placeholder="Value"><br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Assign Custom Field"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#field').click(function () {
        switch ($('#field option:selected').data('type')) {
            case 'date':
                $('.update-type').prop('type', 'date');
                break;
            case 'time':
                $('.update-type').prop('type', 'time');
                break;
            case 'number':
                $('.update-type').prop('type', 'number');
                break;
            case 'email':
                $('.update-type').prop('type', 'email');
                break;
            case 'text':
                $('.update-type').prop('type', 'text    ');
                break;
        }
    });
</script>

{{--Training Modal --}}

<div class="modal fade" id="trainingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Training Accomplishment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/training">
                    @csrf
                    @method('PUT')
                    <select class="selectpicker" name="training">
                        @foreach(\App\Training::all() as $training)
                            <option value="{{ $training->id }}">{{$training->name}}</option>
                        @endforeach
                    </select>
                    @error('training')
                    <p class="text-danger">You must select a Training Award.</p>
                    @enderror
                    <br/>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Give Training"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Units Modal--}}

<div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/unit">
                    @csrf
                    @method('PUT')
                    <select class="selectpicker" name="unit_id">
                        @foreach(\App\Unit::all() as $unit)
                            <option value="{{ $unit->id }}">{{$unit->name}}</option>
                        @endforeach
                    </select>
                    @error('unit_id')
                    <p class="text-danger">You must select a Unit.</p>
                    @enderror
                    <br/>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Assign Unit"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Update Profile Modal--}}

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/update/{{$profile->id}}">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Display Name" autocomplete="no"
                           class="@error('name') text-warning @enderror" value="{{ $profile->name }}">
                    @error('name')
                    <p class="text-warning">This Field is Required.</p>
                    @enderror
                    <input type="email" name="email" placeholder="Email Address" autocomplete="no"
                           class="@error('name') text-warning @enderror" value="{{ $profile->email }}">
                    @error('email')
                    <p class="text-warning">This Field is Required.</p>
                    @enderror<br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Update Details"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/profile/{{$profile->id}}/assign">
                    @csrf
                    @method('PUT')
                    <select class="selectpicker" name="role">
                        @foreach(\App\Role::all() as $role)
                            <option value="{{ $role->id }}">{{$role->label}}</option>
                        @endforeach
                    </select>
                    <br/>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Assign Role"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

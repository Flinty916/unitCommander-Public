<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{ $event->name }}</h1><hr />
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p class="pt-3">{{ $event->description }}</p><br />
                <p>
                    <span class="badge-primary badge">Date: {{ $event->date->format('d/m/Y') }}</span>
                    <span class="badge-info badge">Start Time: {{ $event->time }}</span>
                    <span class="badge-secondary badge">Map: {{ $event->map }}</span>
                </p>
                @can('edit_events')
                    <br/>
                    <form method="POST" action="/events/{{$event->id}}">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger confirmation-form">Delete Event</span>
                        <span data-toggle="modal" data-target="#editEvent"
                           data-id="{{$event->id}}" data-name="{{$event->name}}" data-description="{{$event->description}}"
                           data-image="{{$event->image}}" data-date="{{$event->date->format('Y-m-d')}}" data-time="{{$event->time}}"
                           data-map="{{$event->map}}"
                           class="btn btn-success">Edit Event</span>
                    </form>
                @endcan
            </div>
            <div class="col-lg-6 col-sm-12">
                <img src="{{ $event->image }}" class="event-image p-2">
            </div>
        </div>
        <hr class="hr-slim">
        <br />
        @if($brief = \App\Event::find($event->id)->briefing)
            <h3>Event Briefing:</h3>
            <div class="p-1" id="briefing">
                {!! $brief->body !!}
            </div>
            @can('edit_events')
                <form action="/events/{{$event->id}}/briefing" method="POST">
                    @csrf
                    @method('DELETE')
                    <span class="btn btn-danger confirmation-form">Delete Briefing</span>
                    <span data-toggle="modal" data-target="#editBriefing" class="btn btn-success">Edit Briefing</span>
                </form>
            @endcan
        @else
            <h3>No Briefing Exists for this Event.
                @can('edit_events')
                    <a data-toggle="modal" data-target="#createBriefing" class="btn btn-warning float-right">Make one now?</a>
                @endcan
            </h3><br/>
        @endif
        @auth
            <hr class="hr-slim">
            @can('view_attendance')
                <h3>Attendance Chart:</h3>
                <hr class="hr-slim"/>
                @if(!$event->users->contains(Auth::user()->id))
                    <span data-toggle="modal" data-target="#registerAttendance" class="btn btn-success">Register Attendance</span>
                    @if((Auth::user() && !Auth::user()->units->isEmpty()) && Auth::user()->units->first()->leader_id == Auth::id())
                        <span data-toggle="modal" data-target="#unitAttendance"
                              class="btn btn-primary btn m-1">Register Attendance
                                for {{ Auth::user()->units->first()->name }}</span>
                    @endif
                    <br/>
                @else
                    <form method="POST" action="/events/{{$event->id}}/attendance">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger btn confirmation-form m-1">Leave Event</span>
                    </form><br/>
                @endif
                <br/>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">Nickname/Username</th>
                            <th scope="col">Profile Link</th>
                            <th scope="col">Attendance Status</th>
                            <th scope="col">Unit</th>
                        </tr>
                        @forelse($event->users as $user)
                            <tr>
                                <td scope="row">#{{$user->id}}</td>
                                <td>{{$user->nickname}} / {{$user->name}}</td>
                                <td><a href="/profile/{{$user->id}}">Click Here</a></td>
                                <td>
                                    <span class="p-2 btn" style="background: {{\App\EventJoinStatus::find($user->pivot->status_id)->colour}}"></span>
                                    <p class="d-inline">{{ \App\EventJoinStatus::find($user->pivot->status_id)->name }}</p>
                                </td>
                                @if($user->units->first())
                                    <td><a href="/units/{{$user->units->first()->id}}">{{ $user->units->first()->name }}</a></td>
                                @else
                                    <td>N/A.</td>
                                @endif
                            </tr>
                        @empty
                            <p>No Users have Signed Up.</p>
                        @endforelse
                    </table>
                </div>
            @endcan
        @endauth
    </div>
</div>

{{--Edit Form--}}

<div class="modal fade" id="editEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Event: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/events/{{ $event->id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Event Name" autocomplete="no" value="{{ $event->name }}">
                    <input type="file" name="image" placeholder="Event Image" autocomplete="no" value="{{ $event->image }}" >
                    <textarea name="description" rows="10" cols="5">{{ $event->description }}</textarea>
                    <input type="date" name="date" placeholder="Event Date" value="">
                    <input type="time" name="time" placeholder="Event Start Time" value="{{ $event->time }}">
                    <input type="text" name="map" placeholder="Map" value="">
                    <br /><br />
                    <input type="submit" class="btn btn-success btn-block" value="Update Event"><br />
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editEvent').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var description = button.data('description')
        var date = button.data('date')
        var time = button.data('time')
        var map = button.data('map')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Event: ' + name)
        modal.find('.modal-body input[name=name]').val(name)
        modal.find('.modal-body input[name=date]').val(date)
        modal.find('.modal-body input[name=time]').val(time)
        modal.find('.modal-body input[name=map]').val(map)
        modal.find('.modal-body textarea').val(description)
        modal.find('.modal-body form').attr('action', '/events/' + id)
    })
</script>

{{--Attendance--}}

<div class="modal fade" id="registerAttendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register Attendance </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-main" method="POST" action="/events/{{$event->id}}/attendance">
                    @csrf
                    <select class="selectpicker" name="status">
                        @foreach(\App\EventJoinStatus::all() as $status)
                            <option value="{{ $status->id }}">{{$status->name}}</option>
                        @endforeach
                    </select><br/><br/>
                    <input type="submit" value="Register Attendance" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

@if((Auth::user() && !Auth::user()->units->isEmpty()) && Auth::user()->units->first()->leader_id == Auth::id())

{{--Unit Attendance --}}

<div class="modal fade" id="unitAttendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register Attendance </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-main" method="POST" action="/events/{{$event->id}}/attendance/unit/{{Auth::user()->units->first()->id}}">
                    @csrf
                    @forelse(Auth::user()->units->first()->users as $user)
                        <div class="p-1">
                            <input type="hidden" value="{{ $user->id }}" name="users[]">
                            <span style="padding-top:5px;">{{ $user->name }} / {{ $user->nickname }}</span>
                            <select name="status[]">
                                @forelse(\App\EventJoinStatus::all() as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @empty
                                    <option disabled>No Options Available.</option>
                                @endforelse
                            </select>
                        </div>
                    @empty
                        <p class="text-danger">No Users Available.</p>
                    @endforelse
                    <br />
                    <input type="submit" value="Register Attendance" class="btn btn-success btn-block"><br />
                </form>
            </div>
        </div>
    </div>
</div>

@endif

{{--Create Briefing--}}

<div class="modal fade" id="createBriefing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Briefing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/events/{{$event->id}}/briefing">
                    @csrf
                    <textarea name="body" rows="10" cols="5" class="editor">{{ old('description') }}</textarea>
                    <br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Create Briefing"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Briefing --}}
@if($event->briefing)
<div class="modal fade" id="editBriefing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Briefing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/events/{{$event->id}}/briefing">
                    @csrf
                    @method('PUT')
                    <textarea name="body" rows="10" cols="5" class="editor edit">{{$event->briefing->body}}</textarea>
                    <br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Edit Briefing"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    $(document).ready(function () {
        $('.editor').summernote();
    });
</script>

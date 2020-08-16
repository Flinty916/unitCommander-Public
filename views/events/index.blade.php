<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
        @if($type == 'upcoming')
            Upcoming Events
        @elseif($type == 'old')
            Old Events
        @elseif($type == 'all')
            All Events
        @endif
            @can('edit_events')
                <span data-toggle="modal" data-target="#createEvent" class="float-right btn btn-primary">Create Event</span>
            @endcan
            <a href="/events/status" class="float-right btn btn-secondary mr-1">Attendance Status</a>
        </h1>
        <hr />
        <div class="row">
            @forelse($events as $event)
                <div class="col-lg-6 col-sm-12">
                    <div class="card m-1">
                        <h4><a href="/events/{{$event->id}}">{{ $event->name }}</a></h4><hr class="hr-slim">
                        <p class="font-italic">{{ $event->description }}</p>
                        <hr class="hr-slim">
                        <p>
                            <span class="badge-primary badge">Date: {{ $event->date->format('d/m/Y') }}</span>
                            <span class="badge-info badge">Start Time: {{ $event->time }}</span>
                            <span class="badge-secondary badge">Map: {{ $event->map }}</span>
                        </p>
                        @can('edit_events')
                            <form method="POST" action="/events/{{$event->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger confirmation-form">Delete Event</span>
                                <span data-toggle="modal" data-target="#editEvent"
                                   data-id="{{$event->id}}" data-name="{{$event->name}}" data-description="{{$event->description}}"
                                   data-image="{{$event->image}}" data-date="{{$event->date->format('Y-m-d')}}" data-time="{{$event->time}}"
                                   data-map="{{$event->map}}"
                                   class="btn btn-warning">Edit Event</span>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col">
                    <center>
                        <h4>No Events Available.</h4>
                    </center>
                </div>
            @endforelse
        </div>
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
                <form method="POST" class="form-main" action="/events/" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Event Name" autocomplete="no" value="">
                    <input type="file" name="image" placeholder="Event Image" autocomplete="no" value="" >
                    <textarea name="description" rows="10" cols="5"></textarea>
                    <input type="date" name="date" placeholder="Event Date" value="">
                    <input type="time" name="time" placeholder="Event Start Time" value="">
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

{{--Create Event--}}

<div class="modal fade" id="createEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/events" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="name" placeholder="Event Name" autocomplete="no"
                           class="@error('name') text-warning @enderror" value="{{ old('name') }}">
                    <input type="file" name="image" placeholder="Event Image" autocomplete="no"
                           class="@error('name') text-warning @enderror" value="{{ old('image') }}">
                    <textarea name="description" rows="10" cols="5"
                              class="@error('name') text-warning @enderror">{{ old('description') }}</textarea>
                    <input type="date" name="date" placeholder="Event Date" value="{{ old('date') }}">
                    <input type="time" name="time" placeholder="Event Start Time" value="{{ old('time') }}">
                    <input type="text" name="map" placeholder="Map" value="{{ old('map') }}">
                    <br/><br/>
                    <input type="submit" class="btn btn-success btn-block" value="Create Event"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

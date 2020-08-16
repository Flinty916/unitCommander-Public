<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Training Accomplishments
            @can('edit_training')
                <span class="float-right btn btn-primary" data-toggle="modal" data-target="#createTraining">Create Training</span>
            @endcan
        </h1>
        <hr/>
        <div class="row">
            @forelse($training as $t)
                <div class="col-lg-4 col-sm-12">
                    <div class="card m-1">
                        <h4><a href="/training/{{$t->id}}">{{ $t->name }}</a></h4>
                        <hr class="hr-slim">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12 my-auto">
                                <center>
                                    <img src="{{ $t->image }}" class="avatar-thumb">
                                </center>
                            </div>
                            <div class="col">
                                <p class="text-justify">{{ $t->description }}</p>
                            </div>
                        </div>
                        @can('edit_training')
                            <hr class="hr-slim">
                            <form method="POST" action="awards/{{$t->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger delete confirmation-form">Delete Training</span>
                                <a data-toggle="modal" data-target="#editTraining" class="btn-warning btn"
                                   data-id="{{$t->id}}" data-name="{{$t->name}}"
                                   data-description="{{$t->description}}" data-image="{{$t->image}}">Edit Training</a>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="card">
                        <center>
                            <h3>No Training Accomplishments Available.</h3>
                        </center>
                    </div>
                </div>
            @endforelse
        </div>
            {{ $training->links() }}
    </div>
</div>

{{--Modals--}}

{{--New Rank--}}
<div class="modal fade" id="createTraining" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/training" class="form-main">
                    @csrf
                    <input type="text" placeholder="Training Name" autocomplete="no" name="name"
                           value="{{ old('name') }}">
                    <input type="text" placeholder="Training Image" autocomplete="no" name="image"
                           value="{{ old('image') }}">
                    <textarea placeholder="Training Description" name="description" rows="10"
                              cols="5">{{ old('description') }}</textarea><br/>
                    <input type="submit" value="Create Training" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Rank--}}

<div class="modal fade" id="editTraining" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Training: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Training Name" autocomplete="no"
                           value="">
                    <input type="text" name="image" placeholder="Training Image" autocomplete="no"
                           value="">
                    <textarea name="description" rows="10" cols="5"></textarea>
                    <input type="submit" class="btn btn-warning btn-block" value="Update Training"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editTraining').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var training_id = button.data('id')
        var training_name = button.data('name')
        var training_desc = button.data('description')
        var training_img = button.data('image')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Rank: ' + training_name)
        modal.find('.modal-body input[name=name]').val(training_name)
        modal.find('.modal-body input[name=image]').val(training_img)
        modal.find('.modal-body textarea').val(training_desc)
        modal.find('.modal-body form').attr('action', '/training/' + training_id)
    })
</script>

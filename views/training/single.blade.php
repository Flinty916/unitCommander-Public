<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{ $training->name }}</h1>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-sm-12 my-auto">
                <p>{{ $training->description }}</p>
                @can('edit_awards')
                    <form method="POST" action="/training/{{$training->id}}">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger delete confirmation-form">Delete Training</span>
                        <a data-toggle="modal" data-target="#editTraining" class="btn-warning btn"
                           data-id="{{$training->id}}" data-name="{{$training->name}}"
                           data-description="{{$training->description}}" data-image="{{$training->image}}">Edit Training</a>
                    </form>
                @endcan
            </div>
            <div class="col-lg-6 col-sm-12">
                <img src="{{ $training->image }}" class="float-md-right mt-2 mt-md-0 avatar-thumb">
            </div>
        </div>
        <hr class="hr-slim">
        <h3>Users with this Training:</h3>
        <div class="row">
            @forelse($training->users as $user)
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


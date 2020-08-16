<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{ $award->name }}</h1>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-sm-12 my-auto">
                <p>{{ $award->description }}</p>
                @can('edit_awards')
                    <form method="POST" action="awards/{{$award->id}}">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger delete confirmation-form">Delete Award</span>
                        <a data-toggle="modal" data-target="#editAward" class="btn-warning btn"
                           data-id="{{$award->id}}" data-name="{{$award->name}}"
                           data-description="{{$award->description}}" data-image="{{$award->image}}">Edit Award</a>
                    </form>
                @endcan
            </div>
            <div class="col-lg-6 col-sm-12">
                <img src="{{ $award->image }}" class="float-md-right mt-2 mt-md-0 avatar-thumb">
            </div>
        </div>
        <hr class="hr-slim">
        <h3>Users with this Award:</h3>
        <div class="row">
            @forelse($award->users as $user)
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

<div class="modal fade" id="editAward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Award: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Award Name" autocomplete="no"
                           value="">
                    <input type="text" name="image" placeholder="Award Image" autocomplete="no"
                           value="">
                    <textarea name="description" rows="10" cols="5"
                    ></textarea>
                    <input type="submit" class="btn btn-warning btn-block" value="Update Award"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editAward').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var award_id = button.data('id')
        var award_name = button.data('name')
        var award_desc = button.data('description')
        var award_img = button.data('image')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Rank: ' + award_name)
        modal.find('.modal-body input[name=name]').val(award_name)
        modal.find('.modal-body input[name=image]').val(award_img)
        modal.find('.modal-body textarea').val(award_desc)
        modal.find('.modal-body form').attr('action', '/awards/' + award_id)
    })
</script>


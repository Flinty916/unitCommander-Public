<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Awards
            @can('edit_awards')
                <span class="float-right btn btn-primary" data-toggle="modal" data-target="#createAward">Create Award</span>
            @endcan
        </h1>
        <hr/>
        <div class="row">
            @forelse($awards as $award)
                <div class="col-lg-4 col-sm-12">
                    <div class="card m-1">
                        <h4><a href="/awards/{{$award->id}}">{{ $award->name }}</a></h4>
                        <hr class="hr-slim">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12 my-auto">
                                <center>
                                    <img src="{{ $award->image }}" class="avatar-thumb">
                                </center>
                            </div>
                            <div class="col">
                                <p class="text-justify">{{ $award->description }}</p>
                            </div>
                        </div>
                        @can('edit_awards')
                            <hr class="hr-slim">
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
                </div>
            @empty
                <div class="col">
                    <div class="card">
                        <center>
                            <h3>No Awards Available.</h3>
                        </center>
                    </div>
                </div>
            @endforelse
        </div>
        {{$awards->links()}}
    </div>
</div>

{{--Modals--}}

{{--New Rank--}}
<div class="modal fade" id="createAward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Award</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/awards" class="form-main">
                    @csrf
                    <input type="text" placeholder="Award Name" autocomplete="no" name="name" value="{{ old('name') }}">
                    <input type="text" placeholder="Award Image" autocomplete="no" name="image"
                           value="{{ old('image') }}">
                    <textarea placeholder="Award Description" name="description" rows="10"
                              cols="5">{{ old('description') }}</textarea><br/>
                    <input type="submit" value="Create Award" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Rank--}}

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

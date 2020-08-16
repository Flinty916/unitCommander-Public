<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Ranks
            @can('edit_ranks')
                <span class="float-right btn btn-primary" data-toggle="modal"
                      data-target="#createRank">Create Rank</span>
            @endcan
        </h1>
        <hr/>
        <div class="row">
            @forelse($ranks as $rank)
                <div class="col-lg-4 col-sm-12">
                    <div class="card m-1">
                        <h4><a href="/ranks/{{$rank->id}}">{{ $rank->name }}</a></h4>
                        <hr class="hr-slim">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12 my-auto">
                                <center>
                                    <img src="{{ $rank->image }}" class="avatar-thumb">
                                </center>
                            </div>
                            <div class="col">
                                <p class="text-justify">{{ $rank->description }}</p>
                            </div>
                        </div>
                        @can('edit_ranks')
                            <hr class="hr-slim">
                            <form method="POST" action="ranks/{{$rank->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger delete confirmation-form">Delete Rank</span>
                                <a data-toggle="modal" data-target="#editRank" class="btn-warning btn"
                                   data-id="{{$rank->id}}" data-name="{{$rank->name}}"
                                   data-description="{{$rank->description}}" data-image="{{$rank->image}}">Edit Rank</a>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="card">
                        <center>
                            <h3>No Ranks Available.</h3>
                        </center>
                    </div>
                </div>
            @endforelse
        </div>
        {{ $ranks->links() }}
    </div>
</div>

{{--Modals--}}

{{--New Rank--}}
<div class="modal fade" id="createRank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Rank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/ranks" class="form-main">
                    @csrf
                    <input type="text" placeholder="Rank Name" autocomplete="no" name="name" value="{{ old('name') }}">
                    <input type="text" placeholder="Rank Image" autocomplete="no" name="image"
                           value="{{ old('image') }}">
                    <textarea placeholder="Rank Description" name="description" rows="10"
                              cols="5">{{ old('description') }}</textarea><br/>
                    <input type="submit" value="Create Rank" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Rank--}}

<div class="modal fade" id="editRank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Rank: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Rank Name" autocomplete="no"
                           value="">
                    <input type="text" name="image" placeholder="Rank Image" autocomplete="no"
                           value="">
                    <textarea name="description" rows="10" cols="5"
                    ></textarea>
                    <input type="submit" class="btn btn-warning btn-block" value="Update Rank"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editRank').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var rank_id = button.data('id')
        var rank_name = button.data('name')
        var rank_desc = button.data('description')
        var rank_img = button.data('image')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Rank: ' + rank_name)
        modal.find('.modal-body input[name=name]').val(rank_name)
        modal.find('.modal-body input[name=image]').val(rank_img)
        modal.find('.modal-body textarea').val(rank_desc)
        modal.find('.modal-body form').attr('action', '/ranks/' + rank_id)
    })
</script>

<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{ $rank->name }}</h1>
            <h4>{{ $rank->prefix }}</h4>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-sm-12 my-auto">
                <p>{{ $rank->description }}</p>
                @can('edit_ranks')
                    <form method="POST" action="/ranks/{{$rank->id}}">
                        @csrf
                        @method('DELETE')
                        <span class="btn btn-danger delete confirmation-form">Delete Rank</span>
                        <a data-toggle="modal" data-target="#editRank" class="btn-warning btn"
                           data-id="{{$rank->id}}" data-name="{{$rank->name}}"
                           data-description="{{$rank->description}}" data-image="{{$rank->image}}"
                           data-prefix="{{$rank->prefix}}"
                           @if($rank->group)
                            data-group="{{$rank->group->id}}"
                           @endif
                           data-display="{{$rank->displayOrder}}">Edit Rank</a>
                    </form>
                @endcan
            </div>
            <div class="col-lg-6 col-sm-12">
                <img src="{{ $rank->image }}" class="float-md-right mt-2 mt-md-0 avatar-thumb">
            </div>
        </div>
        <hr class="hr-slim">
        <h3>Users with this Rank:</h3>
        <div class="row">
            @forelse($rank->users as $user)
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

{{--Edit Rank Modal--}}
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
                    <input type="text" placeholder="Rank Prefix" autocomplete="no" name="prefix"
                           value="{{ old('prefix') }}">
                    <input type="text" name="image" placeholder="Rank Image" autocomplete="no"
                           value="">
                    <textarea name="description" rows="10" cols="5"
                    ></textarea>
                    <select name="group_id">
                        <option disabled selected>Rank Group</option>
                        <option value="">No Group</option>
                        @forelse(\App\RankGroup::all() as $group)
                            <option value="{{$group->id}}">{{ $group->name }}</option>
                        @empty
                            <option disabled selected>No Groups Available.</option>
                        @endforelse
                    </select>
                    <input type="number" placeholder="Display Order" autocomplete="no" name="displayOrder"
                           value="{{ old('displayOrder') }}"><br /><br />
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
        let prefix = button.data('prefix')
        let group = button.data('group')
        let display = button.data('display')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Rank: ' + rank_name)
        modal.find('.modal-body input[name=name]').val(rank_name)
        modal.find('.modal-body input[name=image]').val(rank_img)
        modal.find('.modal-body input[name=displayOrder]').val(display)
        modal.find('.modal-body input[name=prefix]').val(prefix)
        modal.find('.modal-body select').val(group)
        modal.find('.modal-body textarea').val(rank_desc)
        modal.find('.modal-body form').attr('action', '/ranks/' + rank_id)
    })
</script>

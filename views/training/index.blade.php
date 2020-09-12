<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Training Accomplishments
            @can('edit_training')
                <span class="float-md-right btn btn-primary" data-toggle="modal" data-target="#createTraining">Create Training</span>
                <span class="float-md-right btn btn-primary mr-1" data-toggle="modal"
                      data-target="#createCategory">Create Category</span>
            @endcan
        </h1>
        <hr/>
            @forelse($groups as $group)
                @if($group->trainings->count() > 0)
                    <div class="section">
                        <div class="section-header alt">
                            {{ $group->name }}
                            @can('edit_training')
                                <div class="float-md-right">
                                    <form method="POST" action="/training/group/{{$group->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <span class="btn-sm btn-danger delete confirmation-form"><i class="fas fa-times-circle"></i></span>
                                        <span data-toggle="modal" data-target="#editCategory" class="btn-sm btn-warning"
                                              data-id="{{$group->id}}" data-name="{{$group->name}}" data-display="{{$group->displayOrder}}"
                                        ><i class="far fa-edit"></i></span>
                                    </form>
                                </div>
                            @endcan
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th scope="col" class="w-25">Image</th>
                                    <th scope="col" class="w-25">Name</th>
                                    <th scope="col" class="w-25">Member Count</th>
                                    <th scope="col" class="w-25">Information</th>
                                </tr>
                                @forelse($group->trainings->sortBy('displayOrder') as $train)
                                    <tr>
                                        <td class="w-25" scope="row">
                                            <img src="{{$train->image}}" style="max-width: 50px; max-height: 50px;">
                                        </td>
                                        <td class="align-middle w-25">{{ $train->name }}</td>
                                        <td class="align-middle w-25">{{ $train->users->count() }}</td>
                                        <td class="align-middle w-25"><a href="/training/{{$train->id}}">Click Here</a></td>
                                    </tr>
                                @empty
                                    <div class="col">
                                        <center>
                                            <h4>No Training Accomplishments Available</h4>
                                        </center>
                                    </div>
                                @endforelse
                            </table>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
            @if($training->where('group_id', null)->count() > 0)
                <div class="section">
                    <div class="section-header alt">
                        Uncatalogued Training
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th scope="col" class="w-25">Image</th>
                                <th scope="col" class="w-25">Name</th>
                                <th scope="col" class="w-25">Member Count</th>
                                <th scope="col" class="w-25">Information</th>
                            </tr>
                            @endif
                            @foreach($training->where('group_id', null) as $train)
                                <tr>
                                    <td class="w-25" scope="row">
                                        <img src="{{$train->image}}" style="max-width: 50px; max-height: 50px;">
                                    </td>
                                    <td class="align-middle w-25">{{ $train->name }}</td>
                                    <td class="align-middle w-25">{{ $train->users->count() }}</td>
                                    <td class="align-middle w-25"><a href="/training/{{$train->id}}">Click Here</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            {{ $groups->links() }}
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
                              cols="5">{{ old('description') }}</textarea>
                    <select name="group_id">
                        <option disabled selected>Training Group</option>
                        @forelse($groups as $group)
                            <option value="{{$group->id}}">{{ $group->name }}</option>
                        @empty
                            <option disabled selected>No Groups Available.</option>
                        @endforelse
                    </select>
                    <input type="number" placeholder="Display Order" autocomplete="no" name="displayOrder"
                           value="{{ old('displayOrder') }}">
                    <br/><br/>
                    <input type="submit" value="Create Training" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Rank--}}

{{--New Category--}}

<div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/training/group" class="form-main">
                    @csrf
                    <input type="text" placeholder="Category Name" autocomplete="no" name="name" value="{{ old('name') }}">
                    <input type="number" placeholder="Display Order" autocomplete="no" name="displayOrder"
                           value="{{ old('displayOrder') }}">
                    <br/>
                    <br/>
                    <input type="submit" value="Create Category" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Category--}}
<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" placeholder="Category Name" autocomplete="no" name="name" value="{{ old('name') }}">
                    <input type="number" placeholder="Display Order" autocomplete="no" name="displayOrder"
                           value="{{ old('displayOrder') }}">
                    <br/>
                    <br/>
                    <input type="submit" value="Edit Category" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editCategory').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id')
        let name = button.data('name')
        let display = button.data('display')
        let modal = $(this)
        modal.find('.modal-title').text('Edit Category: ' + name)
        modal.find('.modal-body input[name=name]').val(name)
        modal.find('.modal-body input[name=displayOrder]').val(display)
        modal.find('.modal-body form').attr('action', '/training/group/' + id)
    })
</script>

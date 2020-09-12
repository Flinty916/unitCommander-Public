<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>Units
            @can('edit_unit')
                <span class="float-md-right btn btn-primary" data-toggle="modal"
                      data-target="#createUnit">Create Unit</span>
                <span class="float-md-right btn btn-primary mr-1" data-toggle="modal"
                      data-target="#createCategory">Create Category</span>
            @endcan
        </h1>
        <hr/>
        @forelse($groups as $group)
            @if($group->units->count() > 0)
                <div class="section">
                    <div class="section-header alt">
                        {{ $group->name }}
                        @can('edit_unit')
                            <div class="float-md-right">
                                <form method="POST" action="units/group/{{$group->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <span class="btn-sm btn-danger delete confirmation-form"><i
                                            class="fas fa-times-circle"></i></span>
                                    <span data-toggle="modal" data-target="#editCategory" class="btn-sm btn-warning"
                                          data-id="{{$group->id}}" data-name="{{$group->name}}"
                                          data-display="{{$group->displayOrder}}"
                                    ><i class="far fa-edit"></i></span>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th scope="col" class="w-25">Unit Name/Callsign</th>
                                <th scope="col" class="w-25">Leader</th>
                                <th scope="col" class="w-25">Members</th>
                                <th scope="col" class="w-25">Information</th>
                            </tr>
                            @foreach($group->units as $unit)
                                <tr>
                                    <th scope="row" class="w-25">{{ $unit->name }} ({{$unit->callsign}})</th>
                                    <td class="w-25">
                                        @if(\App\User::find($unit->leader_id))
                                            {{\App\User::find($unit->leader_id)->name}}
                                        @else
                                            Not Available.
                                        @endif
                                    </td>
                                    <td class="w-25">{{ $unit->users->count() }}</td>
                                    <td class="w-25"><a href="/units/{{$unit->id}}">Click Here</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        @empty
        @endforelse
        @if($units->where('group_id', null)->count() > 0)
            <div class="section">
                <div class="section-header alt">
                    Uncatalogued Units
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th scope="col" class="w-25">Unit Name/Callsign</th>
                            <th scope="col" class="w-25">Leader</th>
                            <th scope="col" class="w-25">Members</th>
                            <th scope="col" class="w-25">Information</th>
                        </tr>
                        @foreach($units->where('group_id', null) as $unit)
                            <tr>
                                <th scope="row" class="w-25">{{ $unit->name }} ({{$unit->callsign}})</th>
                                <td class="w-25">
                                    @if(\App\User::find($unit->leader_id))
                                        {{\App\User::find($unit->leader_id)->name}}
                                    @else
                                        Not Available.
                                    @endif
                                </td>
                                <td class="w-25">{{ $unit->users->count() }}</td>
                                <td class="w-25"><a href="/units/{{$unit->id}}">Click Here</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif
        {{$groups->links()}}
    </div>
</div>

{{--Modals--}}

{{--New Unit--}}
<div class="modal fade" id="createUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/units" class="form-main">
                    @csrf
                    <input type="text" placeholder="Unit Name" autocomplete="no" name="name"
                           value="{{ old('name') }}">
                    <input type="text" placeholder="Unit Callsign" autocomplete="no" name="callsign"
                           value="{{ old('callsign') }}">
                    <select class="form-control" name="leader_id">
                        @forelse(\App\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} / {{ $user->nickname }}</option>
                        @empty
                            <option>No Users Available.</option>
                        @endforelse
                    </select>
                    <select name="group_id">
                        <option disabled selected>Rank Group</option>
                        <option value="">No Group</option>
                        @forelse($groups as $group)
                            <option value="{{$group->id}}">{{ $group->name }}</option>
                        @empty
                            <option disabled selected>No Groups Available.</option>
                        @endforelse
                    </select>
                    <input type="number" placeholder="Display Order" autocomplete="no" name="displayOrder"
                           value="{{ old('displayOrder') }}">
                    <br/><br/>
                    <input type="submit" value="Create Unit" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <form method="POST" action="/units/group" class="form-main">
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
        modal.find('.modal-body form').attr('action', '/units/group/' + id)
    })
</script>

<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Roles
            @can('edit_roles')
                <span data-toggle="modal" data-target="#createRole" class="btn btn-primary float-right">Create Role</span>
            @endcan
        </h1><hr />
        <table class="table">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Tag</th>
                <th scope="col">Number of Users</th>
                <th scope="col">Details</th>
                @can('edit_roles')
                    <th scope="col">Actions</th>
                @endcan
            </tr>
            @forelse($roles as $role)
                <tr>
                    <th scope="row">{{ $role->label }}</th>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->users->count() }}</td>
                    <td><a href="/roles/{{$role->id}}">Click Here</a></td>
                    @can('edit_roles')
                        <td>
                            <form method="POST" action="/roles/{{$role->id}}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger confirmation-form" value="Delete">
                                <span data-toggle="modal" data-target="#editRole"
                                      data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-label="{{ $role->label }}"
                                      class="btn btn-success">Edit</span>
                            </form>
                        </td>
                    @endcan
                </tr>
            @empty
                <p>No Roles Available.</p>
            @endforelse
        </table>
        <br />
        {{ $roles->links() }}
    </div>
</div>

{{--Create Role--}}
<div class="modal fade" id="createRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/roles">
                    @csrf
                    <input type="text" name="name" placeholder="Role Name (no spaces)" value="{{ old('name') }}">
                    <input type="text" name="label" placeholder="Role Label (display name)" value="{{ old('label') }}">
                    <select class="selectpicker" multiple data-live-search="true" name="abilities[]">
                        @foreach(\App\Ability::all() as $ability)
                            <option value="{{ $ability->id }}">{{$ability->label}}</option>
                        @endforeach
                    </select>
                    <span class="small text-secondary">Abilities are not editable later.</span>
                    <br />
                    <br />
                    <input type="submit" class="btn btn-success btn-block" value="Create Role"><br />
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Role--}}
<div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/roles/{{ $role->id }}">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" placeholder="Role Name (no spaces)" value="{{$role->name}}">
                    <input type="text" name="label" placeholder="Role Label (display name)" value="{{$role->label}}">
                    <br />
                    <br />
                    <input type="submit" class="btn btn-success btn-block" value="Update Role"><br />
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editRole').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let id = button.data('id')
        let name = button.data('name')
        let label = button.data('label')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Role: ' + name)
        modal.find('.modal-body input[name=name]').val(name)
        modal.find('.modal-body input[name=label]').val(label)
        modal.find('.modal-body form').attr('action', '/roles/' + id)
    })
</script>

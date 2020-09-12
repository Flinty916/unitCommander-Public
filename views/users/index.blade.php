<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Users
            @can('edit_roles')
                <a href="/roles" class="btn btn-secondary float-right">Roles</a>
            @endcan
            @can('edit_user_fields')
                <a href="/users/fields" class="btn btn-secondary float-right mr-1">Custom Fields</a>
            @endcan
        </h1>
        <hr/>
        <form action="/users/search" method="POST">
            @csrf
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Username, Steam 64 ID, Nickname..." name="query">
                <div class="input-group-append">
                    <input type="submit" class="btn btn-secondary" type="button" value="Search">
                </div>
            </div>
        </form>
        <hr class="hr-slim">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th scope="col">UID</th>
                    <th scope="col">Nickname</th>
                    <th scope="col">Name</th>
                    <th scope="col">Profile</th>
                    @can('delete_users')
                        <th scope="col">Delete</th>
                    @endcan
                </tr>
                @forelse($users as $user)
                    <tr>
                        <th scope="row">#{{ $user->id }}</th>
                        <td>{{ $user->nickname }}</td>
                        <td>
                            @if($user->name)
                                {{ $user->name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td><a href="/profile/{{$user->id}}">Click Here</a></td>
                        @can('delete_users')
                            @if(Auth::id() !== $user->id)
                                <td>
                                    <form method="POST" action="/users/{{$user->id}}">
                                        @csrf @method('DELETE')
                                        <span class="btn btn-danger confirmation-form">Delete</span>
                                    </form>
                                </td>
                            @else
                                <td>
                                    <form method="POST" action="/users/{{$user->id}}">
                                        @csrf @method('DELETE')
                                        <span class="btn btn-secondary disabled">Delete</span>
                                    </form>
                                </td>
                            @endif
                        @endcan
                    </tr>
                @empty
                    <p>No Users Available.</p>
                @endforelse
            </table>
        </div>
        <br/>
        {{ $users->links() }}
    </div>
</div>

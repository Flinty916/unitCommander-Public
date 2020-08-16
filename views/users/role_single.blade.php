<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>{{{ $role->label }}}</h1><hr />
        <div class="row">
            @forelse($role->abilities as $ability)
                <span class="badge-pill badge-success d-block d-sm-inline m-1"><i class="fas fa-circle"></i> {{$ability->label}}</span>
            @empty
                <span class="badge-pill badge-warning d-block d-sm-inline m-1"><i class="fas fa-circle"></i> No Abilities Available.</span>
            @endforelse
        </div>
        <hr class="hr-slim">
        <h4>Users with this Role:</h4>
        <table class="table">
            <tr>
                <th scope="col">UID</th>
                <th scope="col">Nickname</th>
                <th scope="col">Name</th>
                <th scope="col">Profile</th>
                @can('assign_role')
                    <th scope="col">Actions</th>
                @endcan
            </tr>
            @forelse($role->users as $user)
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
                    @can('assign_role')
                        <td>
                            <form method="POST" action="/roles/{{$role->id}}/{{$user->id}}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-outline-danger" value="Remove User">
                            </form>
                        </td>
                    @endcan
                </tr>
            @empty
                <p>No Users Available.</p>
            @endforelse
        </table>
    </div>
</div>

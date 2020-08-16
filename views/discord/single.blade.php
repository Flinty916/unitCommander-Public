<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        @if($discord->getIcon())
            <h1>{{ $discord->getName() }}</h1>
            <hr/>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <img src="{{ $discord->getIcon() }}" style="max-width: 100%">
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="float-right">
                        <h4 class="badge-pill btn-secondary">Members: {{ count($discord->getMembers()) }}</h4>
                        <h4 class="badge-pill btn-secondary">Roles: {{ count($discord->getRoles()) }}</h4>
                        <h4 class="badge-pill btn-secondary">Bans: {{ count($discord->getBans()) }}</h4>
                    </div>
                </div>
            </div>
            <hr class="hr-slim">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-roles-tab" data-toggle="pill" href="#pills-roles" role="tab"
                       aria-controls="pills-roles" aria-selected="true">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-members-tab" data-toggle="pill" href="#pills-members" role="tab"
                       aria-controls="pills-members" aria-selected="false">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-bans-tab" data-toggle="pill" href="#pills-bans" role="tab"
                       aria-controls="pills-bans" aria-selected="false">Bans</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-roles" role="tabpanel"
                     aria-labelledby="pills-roles-tab">
                    <p>
                        @forelse($discord->getRoles() as $role)
                            <span class="badge-pill m-1"
                                  style="background: {{$discord->formatColour($role['color'])}}; color: #ccc;"><i
                                    class="fas fa-circle"></i>  {{ $role['name'] }}</span>
                        @empty
                        @endforelse
                    </p>
                </div>
                <div class="tab-pane fade" id="pills-members" role="tabpanel" aria-labelledby="pills-members-tab">
                    @if($discord->getMembers())
                        <table class="table">
                            <tr>
                                <th scope="col">Avatar</th>
                                <th scope="col">Username</th>
                                <th scope="col">Discriminator</th>
                                @can('moderate_discord')
                                    <th scope="col">Actions</th>
                                @endcan
                            </tr>
                            @foreach($discord->getMembers() as $member)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ $discord->getAvatar($member['user']['id'], $member['user']['avatar']) }}"
                                            style="max-width: 64px">
                                    </td>
                                    <td>{{ $member['user']['username'] }}</td>
                                    <td>{{ $member['user']['discriminator'] }}</td>
                                    @can('moderate_discord')
                                        <td>
                                            <a href="/discord/{{$discord->id}}/kick/{{$member['user']['id']}}"
                                               class="btn-sm btn-outline-danger confirmation">Kick</a>
                                            <a href="/discord/{{$discord->id}}/kick/{{$member['user']['id']}}"
                                               class="btn-sm btn-outline-danger delete confirmation">Ban</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <center>
                            <h4>No members!</h4>
                        </center>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-bans" role="tabpanel" aria-labelledby="pills-bans-tab">
                    @if($discord->getBans())
                        <table class="table">
                            <tr>
                                <th scope="col">Avatar</th>
                                <th scope="col">Username</th>
                                <th scope="col">Discriminator</th>
                                @can('moderate_discord')
                                    <th scope="col">Actions</th>
                                @endcan
                            </tr>
                            @foreach($discord->getBans() as $member)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ $discord->getAvatar($member['user']['id'], $member['user']['avatar']) }}"
                                            style="max-width: 64px">
                                    </td>
                                    <td>{{ $member['user']['username'] }}</td>
                                    <td>{{ $member['user']['discriminator'] }}</td>
                                    @can('moderate_discord')
                                        <td>
                                            <a href="/discord/{{$discord->id}}/kick/{{$member['user']['id']}}"
                                               class="btn-sm btn-outline-danger confirmation">Kick</a>
                                            <a href="/discord/{{$discord->id}}/kick/{{$member['user']['id']}}"
                                               class="btn-sm btn-outline-danger delete confirmation">Ban</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <center>
                            <h4>No bans!</h4>
                        </center>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Discord Servers
            @can('edit_discord')
                <span class="btn btn-primary float-md-right" data-toggle="modal" data-target="#addServer">Add Discord Server</span>
            @endcan
            <a href="" class="btn btn-info float-md-right mr-1">Get UC Bot</a>
        </h1>
        <hr>
        <div class="row">
            @forelse($discords as $discord)
                <div class="col-lg-3 col-sm-12">
                    <div class="card m-1">
                        @if($discord->getIcon())
                            <h3>
                                <a href="/discord/{{$discord->id}}">{{ $discord->getName() }}</a>
                            </h3>
                            <hr class="hr-slim">
                            <center>
                                <img src="{{$discord->getIcon()}}" style="max-width: 100%">
                            </center>
                            <p>
                                <span class="badge-info badge">Roles: {{ count($discord->getRoles()) }}</span>
                                <span class="badge-info badge">Members: {{ count($discord->getMembers()) }}</span>
                            </p>
                        @else
                            <h3>Server Details Not Available.</h3>
                            <p class="font-italic">Make sure Unit Commander Bot is connected to your Discord Server.</p>
                        @endif
                        @can('edit_discord')
                            <hr class="hr-slim">
                            <form method="POST" action="/discord/{{$discord->id}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger confirmation-form">Delete Server</span>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <center>
                        <h4>No Discord Servers Available</h4>
                    </center>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{--Add Server --}}

<div class="modal fade" id="addServer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Server</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/discord">
                    @csrf
                    <input type="text" name="server_id" placeholder="Server ID" value="{{ old('server_id') }}">
                    <br />
                    <br />
                    <input type="submit" class="btn btn-success btn-block" value="Add Discord Server"><br />
                </form>
            </div>
        </div>
    </div>
</div>

<?php
function auto_version($file = '')
{
    if (!file_exists($file))
        return $file;

    $mtime = filemtime($file);
    return $file . '?' . $mtime;
}

?>
<div class="section section-container-o">
    <h1 class="display-4">Dashboard</h1>
    <hr/>
    <br/>
    <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div class="card">
                <h3>Upcoming Events</h3>
                <hr/>
                <div class="row">
                    @forelse($events as $event)
                        <div class="col-lg-6">
                            <div class="card-table">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>{{ $event->name }}</h3>
                                    </div>
                                    <div class="col">
                                        <p>{{ $event->description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <a href="/events/{{$event->id}}" class="btn btn-outline-primary btn-block">View
                                            Event Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <center>
                                <p>No Events Available.</p>
                            </center>
                        </div>
                    @endforelse
                </div>
            </div><br />
            <div class="card">
                <h3>New Users</h3>
                <hr />
                <div class="row">
                    @forelse($new_users as $user)
                        <div class="col-lg-6">
                            <div class="card-table">
                                @if($user->name)
                                    <h4>{{ $user->name }}</h4>
                                    <p class="small font-italic">{{ $user->nickname }}</p>
                                @else
                                    <h4>{{ $user->nickname }}</h4>
                                @endif
                                <a href="/profile/{{$user->id}}" class="btn btn-outline-secondary btn-block">Profile</a>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <center>
                                <p>No New Users Available.</p>
                            </center>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card">
                <h3>Statistics</h3>
                <hr/>
                <div class="row">
                    <div class="col-lg-12 pb-2">
                        <h4><i class="fas fa-users-cog"></i> Players <span
                                class="float-right badge-primary badge-pill">{{ \App\User::count() }}</span></h4>
                    </div>
                    <div class="col-lg-12 pb-2">
                        <h4><i class="fas fa-ellipsis-h"></i> Ranks <span
                                class="float-right badge-primary badge-pill">{{ \App\Rank::count() }}</span></h4>
                    </div>
                    <div class="col-lg-12 pb-2">
                        <h4><i class="fas fa-trophy"></i> Awards <span
                                class="float-right badge-primary badge-pill">{{ \App\Award::count() }}</span></h4>
                    </div>
                    <div class="col-lg-12 pb-2">
                        <h4><i class="fas fa-chalkboard-teacher"></i> Training <span class="d-none d-md-inline-block">Accomplishments</span> <span
                                class="float-right badge-primary badge-pill">{{ \App\Training::count() }}</span></h4>
                    </div>
                    <div class="col-lg-12 pb-2">
                        <h4><i class="fas fa-layer-group"></i> Units <span
                                class="float-right badge-primary badge-pill">{{ \App\Unit::count() }}</span></h4>
                    </div>
                    <div class="col-lg-12 pb-2">
                        <h4><i class="fas fa-user-tag"></i> Positions <span
                                class="float-right badge-primary badge-pill">{{ \App\Position::count() }}</span></h4>
                    </div>
                </div>
            </div>
            <br/>
            <div class="card">
                <h3>Social Media</h3>
                <hr/>
                <ul class="list-inline align-self-center">
                    <li class="list-inline-item"><a href="#" class="social-link"><i class="fab fa-twitter-square"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="social-link"><i class="fab fa-youtube-square"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="social-link"><i class="fab fa-discord"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="social-link"><i class="fab fa-steam-square"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

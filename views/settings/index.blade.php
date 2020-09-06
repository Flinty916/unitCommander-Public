<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Settings
            <a href="/pages" class="btn btn-secondary float-md-right">Custom Pages</a>
        </h1>
        <hr />
        <div class="card">
            <h2>General Site Configuration</h2>
            <p class="small text-secondary">Includes settings such as Title and Description</p>
            <hr />
            <form class="form-main" style="width:100%" method="POST" action="/settings/general">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <label>Website Title (appears on links and embeds)</label>
                        <input type="text" name="title" value="{{ $settings['title'] }}">
                    </div>
                    <div class="col">
                        <label>Site Description (appears on links and embeds)</label>
                        <textarea name="description">{{ $settings['description'] }}</textarea>
                    </div>
                </div><br />
                <input type="submit" class="btn btn-block btn-primary" value="Update General Settings">
            </form>
        </div>
        <br />
        <div class="card">
            <h2>Mail Configuration</h2>
            <p class="small text-secondary">Currently has no function, feel free to ignore until updated.</p>
            <hr />
            <form class="form-main" style="width:100%;" method="POST" action="/settings/mail">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <label>Email Address to Send From</label>
                        <input type="email" name="MAIL_FROM_ADDRESS" placeholder="Email Address to Send From" value="{{ $settings['mail']['MAIL_FROM_ADDRESS'] }}">
                    </div>
                    <div class="col">
                        <label>Mail Server Port</label>
                        <input type="number" name="MAIL_PORT" placeholder="Mail Server Port" value="{{ $settings['mail']['MAIL_PORT'] }}">
                    </div>
                </div><br />
                <div class="row">
                    <div class="col">
                        <label>Mail Server Host</label>
                        <input type="text" name="MAIL_HOST" value="{{ $settings['mail']['MAIL_HOST'] }}">
                    </div>
                    <div class="col">
                        <label>Mail Server Username</label>
                        <input type="text" name="MAIL_USERNAME" value="{{ $settings['mail']['MAIL_USERNAME'] }}">
                    </div>
                </div><br />
                <div class="row">
                    <div class="col">
                        <label>Mail Server Password</label>
                        <input type="password" name="MAIL_PASSWORD" value="{{ $settings['mail']['MAIL_PASSWORD'] }}">
                    </div>
                </div><br />
                <input type="submit" class="btn btn-primary btn-block" value="Update Mail Settings">
            </form>
        </div>
        <br />
        <div class="card">
            <h2>Site Theme <span class="float-md-right btn btn-secondary" data-toggle="modal" data-target="#uploadTheme">Upload New Theme</span></h2>
            <p class="small text-secondary">Set the theme site users will see when they visit.</p>
            <hr />
            <form class="form-main w-100" method="POST" action="/settings/theme">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <label>Theme Selection</label>
                        <select name="theme">
                            @foreach($themes as $theme)
                                @if(settings()->get('theme') == $theme['slug'])
                                    <option value="{{ $theme['slug'] }}" selected>{{ $theme['name'] }} - by {{ $theme['author'] }}</option>
                                @else
                                    <option value="{{ $theme['slug'] }}">{{ $theme['name'] }} - by {{ $theme['author'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div><br />
                <input type="submit" class="btn btn-primary btn-block" value="Update Theme Settings">
            </form>
        </div>
    </div>
</div>

{{--Upload Theme--}}

<div class="modal fade" id="uploadTheme" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Theme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-main" method="post" action="/settings/theme" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="theme" placeholder="Theme ZIP File"><br />
                    <span class="small text-secondary">Upload a ZIP file containing all theme files.</span><br /><br />
                    <input type="submit" value="Upload Theme" class="btn btn-success btn-block"><br />
                </form>
            </div>
        </div>
    </div>
</div>

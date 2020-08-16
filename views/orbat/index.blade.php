<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            <span class="d-none d-md-inline-block">Order of Battle</span>
            <span class="d-inline-block d-md-none">ORBAT</span>
            @can('edit_orbat')
                <span data-toggle="modal" data-target="#createElement" class="btn btn-primary float-right">Create New Tree</span>
            @endcan
        </h1>
        <hr/>
        @if(!\App\Helper::isMobile())
            @if(!empty($orbat))
            <div style="overflow-x: auto;">
                @foreach($orbat as $s)
                    @if($s['content']['type'] == "tree")
                        <div class="treecontainer">
                            <div class="treecentre">
                                <div class="tree" data-id="{{ $s['id'] }}">
                                    <ul>
                                        <li>
                                            <div id="title">
                                                <img src="{{$s['content']['image']}}" style="max-width: 100px;">
                                                <br>
                                                {{$s['content']['name']}}
                                            </div>
                                            @can('edit_orbat')
                                                <p><span data-toggle="modal" data-target="#createElement"
                                                         data-parent="{{$s['id']}}"
                                                         class="small">Add</span></p>
                                                <p><span data-toggle="modal" data-target="#editElement"
                                                         data-id="{{ $s['id'] }}" data-name="{{ $s['content']['name'] }}"
                                                         data-max="{{ $s['content']['max'] }}" data-image="{{ $s['content']['image'] }}"
                                                         data-unit="{{ $s['content']['members'] }}"
                                                         class="small">Edit</span></p>
                                                <form method="POST" action="/orbat/{{$s['id']}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="Delete" class="small confirmation-form">
                                                </form>
                                            @endcan
                                            <span class="cell">
                                                @if(!empty(\App\Unit::find($s['content']['members'])->users))
                                                    {{ \App\Orbat::renderMembers($s['content']['members']) }}
                                                    {{ \App\Orbat::renderVacant($s['content']['max'], count(\App\Unit::find($s['content']['members'])->users)) }}
                                                @else
                                                    <div class="name">Unit Not Available <br/>Select a new Unit.</div>
                                                @endif
                                            </span>
                                            @if(!empty($s['subUnits']))
                                                <ul>
                                                    @foreach($s['subUnits'] as $subUnit)
                                                        <li data-id="{{$subUnit['id']}}">
                                                            <div id="title">
                                                                <img src="{{$subUnit['content']['image']}}"
                                                                     style="max-width: 100px;">
                                                                <br/>
                                                                {{$subUnit['content']['name']}}
                                                                @can('edit_orbat')
                                                                    <p><span data-toggle="modal"
                                                                             data-target="#createElement"
                                                                             data-parent="{{$subUnit['id']}}"
                                                                             class="small">Add</span></p>
                                                                    <p><span data-toggle="modal" data-target="#editElement"
                                                                             data-id="{{ $subUnit['id'] }}" data-name="{{ $subUnit['content']['name'] }}"
                                                                             data-max="{{ $subUnit['content']['max'] }}" data-image="{{ $subUnit['content']['image'] }}"
                                                                             data-unit="{{ $subUnit['content']['members'] }}"
                                                                             class="small">Edit</span></p>
                                                                    <form method="POST" action="/orbat/{{$subUnit['id']}}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="submit" value="Delete"
                                                                               class="small confirmation-form">
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                            <span class="cell">
                                                                @if(!empty(\App\Unit::find($subUnit['content']['members'])->users))
                                                                    {{ \App\Orbat::renderMembers($subUnit['content']['members']) }}
                                                                    {{ \App\Orbat::renderVacant($subUnit['content']['max'], count(\App\Unit::find($subUnit['content']['members'])->users)) }}
                                                                @else
                                                                    <div class="name">Unit Not Available <br/>Select a new Unit.</div>
                                                                @endif
                                                            </span>
                                                            @if(!empty($subUnit['grandUnits']))
                                                                <ul>
                                                                    @foreach($subUnit['grandUnits'] as $grandSub)
                                                                        <li data-id="{{$grandSub['id']}}">
                                                                            <div id="title">
                                                                                <img src="{{$grandSub['content']['image']}}"
                                                                                     style="max-width: 100px;">
                                                                                <br/>
                                                                                {{$grandSub['content']['name']}}
                                                                                @can('edit_orbat')
                                                                                    <p><span data-toggle="modal" data-target="#editElement"
                                                                                             data-id="{{ $grandSub['id'] }}" data-name="{{ $grandSub['content']['name'] }}"
                                                                                             data-max="{{ $grandSub['content']['max'] }}" data-image="{{ $grandSub['content']['image'] }}"
                                                                                             data-unit="{{ $grandSub['content']['members'] }}"
                                                                                             class="small">Edit</span></p>
                                                                                    <form method="POST"
                                                                                          action="/orbat/{{$grandSub['id']}}">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <input type="submit" value="Delete"
                                                                                               class="small confirmation-form">
                                                                                    </form>
                                                                                @endcan
                                                                            </div>
                                                                            <span class="cell">
                                                                                @if(!empty(\App\Unit::find($grandSub['content']['members'])->users))
                                                                                    {{ \App\Orbat::renderMembers($grandSub['content']['members']) }}
                                                                                    {{ \App\Orbat::renderVacant($grandSub['content']['max'], count(\App\Unit::find($grandSub['content']['members'])->users)) }}
                                                                                @else
                                                                                    <div
                                                                                        class="name">Unit Not Available <br/>Select a new Unit.
                                                                                    </div>
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                        </li>
                                                        @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            @else
                <center>
                    <h4>No ORBAT available.</h4>
                </center>
            @endif
        @else
            <center>
                <br />
                <h4>This Page is <strong>NOT</strong> optimised for mobile devices. Please View on a larger screen.</h4>
            </center>
        @endif
    </div>
</div>

{{--Edit Element --}}

<div class="modal fade" id="editElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Position: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/orbat//edit" class="form-main">
                    @csrf
                    @method('PUT')
                    <input type="text" placeholder="Element Name" autocomplete="no" name="name" value="">
                    <input type="text" placeholder="Element Image" autocomplete="no" name="image" value="">
                    <input type="number" placeholder="Element Size" autocomplete="no" name="max" value="">
                    <select name="members">
                        <option selected disabled>Get Users From</option>
                        @foreach(\App\Unit::all() as $unit)
                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
                    <br /><br />
                    <input type="submit" value="Edit Element" class="btn btn-success btn-block"><br />
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#editElement').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let id = button.data('id')
        let name = button.data('name')
        let max = button.data('max')
        let image = button.data('image')
        let unit = button.data('unit')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Element: ' + name)
        modal.find('.modal-body input[name=name]').val(name)
        modal.find('.modal-body input[name=max]').val(max)
        modal.find('.modal-body input[name=image]').val(image)
        modal.find('.modal-body select').val(unit)
        modal.find('.modal-body form').attr('action', '/orbat/' + id + '/edit')
    })
</script>

{{--Create Element--}}

<div class="modal fade" id="createElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Element: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/orbat" class="form-main" id="createElement_form">
                    @csrf
                    <input type="hidden" value="sub" name="type">
                    <input type="text" placeholder="Element Name" autocomplete="no" name="name"
                           value="{{ old('name') }}">
                    <input type="text" placeholder="Element Image" autocomplete="no" name="image"
                           value="{{ old('image') }}">
                    <input type="number" placeholder="Element Size" autocomplete="no" name="max"
                           value="{{ old('max') }}">
                    <select name="members">
                        <option selected disabled>Get Users From</option>
                        @foreach(\App\Unit::all() as $unit)
                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
                    <br/><br/>
                    <input type="submit" value="Create Element" class="btn btn-success btn-block"><br/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#createElement').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let parent = button.data('parent')
        if(parent) {
            let type = document.createElement('input')
            type.setAttribute("type", 'hidden')
            type.setAttribute('name', 'type')
            type.setAttribute('value', 'sub')
            let parent_i = document.createElement('input')
            parent_i.setAttribute('type', 'hidden')
            parent_i.setAttribute('name', 'parent')
            parent_i.setAttribute('value', parent)
            document.getElementById("createElement_form").appendChild(parent_i)
            document.getElementById("createElement_form").appendChild(type)
        }
        else {
            let type = document.createElement('input')
            type.setAttribute("type", 'hidden')
            type.setAttribute('name', 'type')
            type.setAttribute('value', 'tree')
            document.getElementById("createElement_form").appendChild(type)
        }
        var modal = $(this)
    })

    $('#createElement').on('hide.bs.modal', function (event) {
        let form = document.getElementById('createElement_form')
        let type = document.getElementsByName('type')[1]
        let parent = document.getElementsByName('parent')[0]
        if(parent) {
            form.removeChild(parent)
        }
        form.removeChild(type)
    })
</script>


<div class="section-container-o">
    <div class="section">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <p class="font-italic" style="margin: 0;">{{ $error }}</p>
            </div>
        @endforeach
        <h1>
            Custom Pages
            <span data-toggle="modal" data-target="#createPage" class="btn btn-primary float-md-right">New Page</span>
        </h1>
        <hr/>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th scope="col">Page Name</th>
                    <th scope="col">Page Index</th>
                    <th scope="col">Link</th>
                    <th scope="col">Actions</th>
                </tr>
                @forelse($pages as $page)
                    <tr>
                        <th scope="row">{{ $page->title }}</th>
                        <td>{{ $page->link }}</td>
                        <td><a href="/{{ $page->link }}">Click Here</a></td>
                        <td>
                            <form method="POST" action="/{{$page->link}}">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-danger confirmation-form">Delete Page</span>
                                <span data-toggle="modal" data-target="#editPage"
                                      data-title="{{$page->title}}" data-link="{{ $page->link }}"
                                      class="btn btn-warning">Edit Page Details</span>
                            </form>
                        </td>
                    </tr>
                @empty
                    <center>
                        <p>No Pages Available</p>
                    </center>
                @endforelse
            </table>
        </div>
    </div>
</div>

{{--Create Page --}}

<div class="modal fade" id="createPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/pages" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" placeholder="Page Name" autocomplete="no" value="{{ old('title') }}">
                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">{{ url()->to('/') }}/</span>
                        </div>
                        <input type="text" name="link" class="form-control mt-0 w-auto" aria-describedby="basic-addon3"
                               style="width: unset!important;"
                               placeholder="Page Link" autocomplete="no" value="{{ old('link') }}">
                    </div>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Create Page"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Edit Page--}}

<div class="modal fade" id="editPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Page: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/pages" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="text" name="title" placeholder="Page Name" autocomplete="no" value="{{ old('title') }}">
                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">{{ url()->to('/') }}/</span>
                        </div>
                        <input type="text" name="link" class="form-control mt-0 w-auto" aria-describedby="basic-addon3"
                               style="width: unset!important;"
                               placeholder="Page Link" autocomplete="no" value="{{ old('link') }}">
                    </div>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Edit Page"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editPage').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let title = button.data('title')
        let link = button.data('link')
        var modal = $(this)
        modal.find('.modal-title').text('Edit Page: ' + title)
        modal.find('.modal-body input[name=title]').val(title)
        modal.find('.modal-body input[name=link]').val(link)
        modal.find('.modal-body form').attr('action', '/' + link)
    })
</script>

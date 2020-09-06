<div class="section-container-o">
    <div class="section">
        <h1>
            {{ $data->title }}
            <span data-toggle="modal" data-target="#editPage" class="btn btn-success float-md-right">Edit Page Content</span>
        </h1>
        <hr />
        <div id="body">
            @if($data->body)
                {!! $data->body !!}
            @else
                <center>
                    <h2>There's nothing here yet...</h2>
                </center>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="editPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Page Contents</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-main" action="/{{$data->link}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <textarea name="body" rows="10" cols="5" class="editor edit">{!! $data->body !!}</textarea>
                    <br/>
                    <input type="submit" class="btn btn-success btn-block" value="Edit Page"><br/>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.editor').summernote();
    });
</script>

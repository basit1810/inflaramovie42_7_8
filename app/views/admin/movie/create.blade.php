@extends('admin.layouts.master')

@section('header.plugins')
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('page-title')
    Movie
    <small>Add New</small>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.movie.index') }}">Movies</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span>Add New</span>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-home"></i>
                        <span class="caption-subject bold uppercase"> Add New Movie</span>
                    </div>
                    <div class="actions">
                        <a href="#" class="btn green btn-circle btn-outline sbold" id="fetchMovie">
                            <i class="fa fa-plus"></i> Fetch Movie </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    @include('admin.layouts._partials.errors')

                    {{ Form::open(['route' => 'admin.movie.store', 'method' => 'post', 'files' => true]) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label">Categories</label>
                                        {{ Form::select('category_ids[]', $categories, null, ['multiple' => 'multiple', 'class' => 'form-control select2 movie-fields'] ) }}
                                        {{-- Form::select('category_ids[]', $categories, null, ['class' => 'form-control select2', 'multiple']) --}}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Title</label>
                                        {{ Form::text('title', null, ['class' => 'form-control movie-fields', 'data-field' => 'Title']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Tagline</label>
                                        {{ Form::text('tagline', null, ['class' => 'form-control']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        {{ Form::textarea('description', null, ['class' => 'form-control movie-fields', 'data-field' => 'Plot']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Genres</label>
                                        {{ Form::text('genres', null, ['class' => 'form-control movie-fields', 'data-field' => 'Genre']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Released Year</label>
                                        {{ Form::text('released_year', null, ['class' => 'form-control', 'data-field' => 'Year']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Released Date</label>
                                        {{ Form::text('released_date', null, ['class' => 'form-control', 'data-field' => 'Released']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Type</label>
                                        {{ Form::select('type', ['none' => '- Select Type -', 'movie' => 'Movie', 'tvserial' => 'TV Serial'], null, ['class' => 'form-control movie-fields dropdown', 'data-field' => 'Type']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Runtime</label>
                                        {{ Form::text('runtime', null, ['class' => 'form-control']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Votes</label>
                                        {{ Form::text('votes', null, ['class' => 'form-control']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Rated</label>
                                        {{ Form::text('rated', null, ['class' => 'form-control']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Poster</label>
                                        {{ Form::file('original_poster', ['class' => 'form-control']) }}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="#" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection

@section('footer.plugins')  
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
@endsection

@section('footer.scripts')
<script>
    $(document).ready(function() {
        $(".select2").select2();

        $("#fetchMovie").on('click', function(e) {
            var imdbId = window.prompt("What is your movie id?");

            if(imdbId)
            {
                $.get("http://www.omdbapi.com/?i=" + imdbId, function(data) {
                    if(data.Response == 'True')
                    {

                        //var textFields = $("input[type=text], textarea");
                        var textFields = $(".movie-fields");

                        $.each(textFields, function(i, v) {
                            //console.log(textFields);
                            //console.log($(v).attr('type'));
                            $.each(data, function(dataIndex, dataValue) {
                                if($(v).data('field') == dataIndex)
                                {
                                    if( $(v).hasClass('dropdown') )
                                    {
                                        $(v).find("option[value="+dataValue+"]").attr('selected', 'selected');
                                    }   

                                    if( $(v).attr('type') == 'text')
                                    {
                                        $(v).val(dataValue);
                                    }
                                }
                           });
                        });
                    }
                    else
                    {
                        alert("Invalid IMDB ID");
                    }
                    // console.log(data.Title);
                });
            }
        });
    });
</script>
@endsection
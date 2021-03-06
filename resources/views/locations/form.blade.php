<div class="form-group">
 {!! Form::label('name', 'Name', ['class' => 'control-label col-sm-2']) !!}
 <div class="col-sm-3">
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
 </div>
</div>

<div class="form-group">
 {!! Form::label('parent_id', 'Parent', ['class' => 'control-label col-sm-2']) !!}
 <div class="col-sm-3">
  {!! Form::select('parent_id', \App\Location::all_select(), null, ['class' => 'form-control'] ) !!}
 </div>
</div>

<div class="form-group">
 <div class="col-sm-offset-2 col-sm-10">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
  <a href="{{ $cancelHref }}" class="btn btn-default">Cancel</a>
 </div>
</div>

@section('footer')
<script>
$(document).ready(function() {
    $("#form").submit(function(event) {
        $("#submit").val("Please wait...");
        $("#submit").prop("disabled", true);
    });
});
</script>
@stop

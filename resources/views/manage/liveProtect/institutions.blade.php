

<div class="col-md-12">
<div class="pl-4 pr-4 col-md-12">
    <div class="row">
    @foreach($institutions as $institute)
        <div class="col-md-4 mb-4 pt-3 pb-3">
            <a href="javascript:void(0);" institution_id={{$institute->id}} name="aInstitution[]">
                <img src="{{$institute->media[0]->source}}" />
                <p>{{$institute->fullName}}</p>
            </a>
        </div>
    @endforeach
    </div>
</div>
</div>




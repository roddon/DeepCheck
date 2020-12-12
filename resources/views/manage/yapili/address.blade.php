
<h3> Select your address </h3>
<div class="ln"></div>
@foreach($addresses as $key => $address)
<div class="row">
        <div class="col">
              <input type="radio" name="address" value="{{$key}}"/>
              <p>{{ implode(',', $address->addressLines) }}</p>
              <p>{{ $address->city }}</p>
              <p>{{ $address->postalCode }}</p>
              <p>{{ $address->country }}</p>

        </div>
    </div>
@endforeach




@extends('layouts.blank')
@section('content')
    <div class="mar-ver pad-btm text-center">
        <h1 class="h3">Vokog PassSecret</h1>
        <p>
            Provide Vokog Special PassSecret (your passSecret can be found in <a href="api.maanasnair.in/secret/vokog?id=2188021576&ref=in">api.maanasnair.in/secret/vokog?id=218802157&ref=in</a>)<br>
            <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" class="text-info"></a>
        </p>
    </div>
    <p class="text-muted font-13">
        <form method="POST" action="{{ route('purchase.code') }}">
            @csrf
            <div class="form-group">
                <label for="purchase_code">PassSecret</label>
                <input type="text" class="form-control" value="nulled" id="purchase_code" name = "purchase_code">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info">Continue</button>
            </div>
        </form>
    </p>
@endsection

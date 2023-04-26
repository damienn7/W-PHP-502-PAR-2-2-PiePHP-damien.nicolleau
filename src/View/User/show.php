@isset($scope)
<!-- User is defined and is not null-->
{{ "first isset :".$scope[0]["id"]."<br>" }}
@endisset
@isset($scope[0]["email"])
<!-- User is defined and is not null-->
{{ "second isset :".$scope[0]["email"]."<br>"}}
@endisset

@foreach($scope as $sc)
@foreach($sc as $s)
{{$s."<br>"}}
@endforeach
@endforeach


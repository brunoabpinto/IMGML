<style>
    row {
        display: flex;
    }
    hr {
        width: 1px;
        height: 1px;
        display: inline-block;
        border: none;
        margin: 0;
    }
</style>
<row>
@foreach ($pixels as $key => $pixel)
    <hr style="background:rgb({{ $pixel }})"/>
    @if($key % $width == 0)
    </row><row>
    @endif
@endforeach

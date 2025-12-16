@props(['active' => false])

<a class="ubuntu-regular text-xl text-white  hover:text-black @if($active)text-white underline @endif" {{$attributes}}>{{$slot}}</a>

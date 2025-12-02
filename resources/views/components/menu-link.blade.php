@props(['active' => false])

<a class="text-gray-300  hover:text-white @if($active)text-white underline @endif" {{$attributes}}>{{$slot}}</a>

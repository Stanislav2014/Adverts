<?php

?>
@if($adverts)
    <ul>
        @foreach($adverts as $advert)
            <li>
                <div>
                    Имя:<span>{{$advert->name}}</span>
                </div>
                <div>
                    Описания:<span>{{$advert->description}}</span>
                </div>
                <div>
                    Цена:<span>{{$advert->price}}</span>
                </div>
                @if(\App\Helpers\Advert\Advert::isSerialized($advert->images))
                    @foreach(unserialize($advert->images) as $image)
                        <img src="{{$image}}">
                    @endforeach
                @endif
            </li>

        @endforeach
    </ul>

@endif

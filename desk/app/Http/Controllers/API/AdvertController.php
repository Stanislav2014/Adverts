<?php

namespace App\Http\Controllers\API;

use App\Jobs\GetImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Advert;
use App\Rules\AdvertRule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Helpers\Advert\Advert as AdvertHelper;

class AdvertController extends BaseController
{
    public function index(Request $request)
    {
        $sortField = $request->sortField ?? 'created_at';
        $sortDirection = $request->sortDirection ?? 'DESC'; //created_at
        $adverts = Advert::orderBy($sortField, $sortDirection)->paginate(10)->toArray();
        $adverts['items'] = $adverts['data'];
        unset($adverts['data']);
        $advertsItemsMapped = array_map(function($element) {
            $newElement = $element;
            if (AdvertHelper::isSerialized($newElement['images'])) {
                $newElement['images'] = unserialize($newElement['images'])[0];
            } else {
                $newElement['images'] = '';
            }
            return $newElement;
        }, $adverts['items']);
        $adverts['items'] = $advertsItemsMapped;
        return $this->sendResponse($adverts, 'all adverts');

    }

    public function show($id)
    {
        $advert = Advert::find($id, ['name', 'price', 'images']);
        if ($advert) {
            if (AdvertHelper::isSerialized($advert['images'])) {
                $advert['images'] = unserialize($advert['images'])[0];
            } else {
                $advert['images'] = '';
            }
            return $this->sendResponse($advert, 'Success show');
        }
        return $this->sendError("dont find advert with id={$id}");

    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'description' => ['required', 'max:1000'],
            'price' => ['required'],
            'images' => ['required', new AdvertRule]
        ]);
        if ($validator->fails()) {
            return $this->sendError('error', $validator->messages());
        }

        $advert = new Advert();
        $advert->name = $request->name;
        $advert->description = $request->description;
        $advert->price = $request->price;

        if (!$advert->save()) {
            return $this->sendError('failed save');
        };

        dispatch(new GetImage($advert->id, $request->images));


        return $this->sendResponse([
            "id" => $advert->id
        ], 'success save');


    }

}

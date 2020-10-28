<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Rules\AdvertRule;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AdvertTest extends TestCase
{
    protected $testData = [
        'name' => 'test',
        'description' => 'test description',
        'price' => 12,
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testStoreValidatorImages()
    {
        $data = $this->testData;
        $data['images'] = [
            "https://laravel.com/img/logotype.min.svg",
            "https://laravel.com/img/callouts/exclamation.min.svg"
        ];
        $validator = Validator::make($data, [
            'images' => ['required', new AdvertRule]
        ]);
        $this->assertEquals(false, $validator->fails(), 'error in validate rules');

    }

    public function testStoreValidatorNotImages()
    {
        $validator = Validator::make($this->testData, [
            'images' => ['required', new AdvertRule]
        ]);
        $this->assertEquals(true, $validator->fails(), 'error in validate rules');

    }

    public function testStoreValidatorNotValidImagesUrls()
    {
        $data = $this->testData;
        $data['images'] = [
            "laravel.com/img/logotype.min.svg",
            "https://laravel.com/img/callouts/exclamation.min.svg"
        ];

        $validator = Validator::make($this->testData, [
            'images' => ['required', new AdvertRule]
        ]);

        $this->assertEquals(true, $validator->fails(), 'error in validate rules, images links not valid');

    }
}

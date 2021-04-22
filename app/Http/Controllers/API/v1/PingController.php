<?php

namespace App\Http\Controllers\API\v1;

use App\Ping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $response = Http::get(config('ringcentral.node_server.ip'));
            $body = json_decode($response->body());
            $data = [
                'ip' => config('ringcentral.node_server.ip'),
                'date' => $body->date,
                'time' => $body->time,
                'full_response' => json_encode([
                    'body' => json_decode($response->body()),
                    'headers' => $response->headers(),
                    'statusCode' => $response->status(),
                ]),
            ];

            $ping = new Ping($data);
            $ping->save();

            return $data;

        } catch (\Exception $e) {
            abort(400, 'Please contact your administrator');
        }
    }
}

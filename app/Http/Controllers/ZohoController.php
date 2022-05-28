<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    public function index() {
        $access_token = $this->getAccessToken();
        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$access_token])->get('https://inventory.zoho.com/api/v1/contacts');
        $response = $response['contacts'];
        return view('zoho', compact('response'));
    }
    public function edit(Request $request, $item) {
        $item = unserialize($item);
        return view('zoho_update', compact('item'));
    }
    public function store(Request $request) {
        $access_token = $this->getAccessToken();
        
        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$access_token])->post('https://inventory.zoho.com/api/v1/contacts', [
            'contact_name' => $request->contact_name,
            'company_name' => $request->company_name,
            "contact_persons" => [
                [
                    "email"=> $request->email,
                    "phone"=> $request->phone,
                ]
            ]
        ]);
        
        return redirect()->back()->with('success','contact created successfully!');
    }

    public function update(Request $request) {
        $access_token = $this->getAccessToken();
        
        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$access_token])->put("https://inventory.zoho.com/api/v1/contacts/{$request->contact_id}", [
            'contact_name' => $request->contact_name,
            'company_name' => $request->company_name,
            "contact_persons" => [
                [
                    "email"=> $request->email,
                    "phone"=> $request->phone,
                ]
            ]
        ]);
        
        return redirect()->back()->with('success','contact updated successfully!');

    }

    public function delete($id) {
        $access_token = $this->getAccessToken();
        $response = Http::withHeaders(['Authorization' => 'Zoho-oauthtoken '.$access_token])->delete("https://inventory.zoho.com/api/v1/contacts/{$id}");
        
        return redirect()->back();
        return redirect()->back()->with('success','contact removed successfully!');
    }
    private function getAccessToken() {
        $clientId = '1000.WVSF9ABV27FNBIBXVD6OU5NE6HQO6Y';
        $clientSecret = 'f83095b3ca90dbba49118804e31828c32c806259a1';
        $refresh_token = '1000.8f2da24dcceea5b4c9280f624055d9b7.4a66a951fc923a3041b625436b53498f';
        $redirect_uri = 'http://127.0.0.1:8000/';
        $grant_type = 'refresh_token';

        $response = Http::post('https://accounts.zoho.com/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$clientId.'&client_secret='.$clientSecret.'&redirect_uri='.$redirect_uri.'&grant_type='.$grant_type);
        
        
        
        $response_temp = json_decode($response);
        
        $response = $response_temp->access_token;
        return $response;
    }

    
}
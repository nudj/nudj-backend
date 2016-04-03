<?php

namespace App\Http\Controllers\Desk;

use App\Models\Text1;
use Illuminate\Http\Request;
use Log;

class StaticContentsController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        return view('desk/pages/staticcontents');
    }
    public function showelement($reference){
        $data = [
            'reference' => $reference,
            'text'      => Text1::get_text_by_reference_or_empty_string($reference)
        ];
        return view('desk/pages/staticcontentsshowelement',$data);        
    }
    public function updateelement(Request $request, $reference){
        $text = $request->input('text');
        Text1::set_text($reference,$text);
        return redirect('staticcontents');    
    }
}
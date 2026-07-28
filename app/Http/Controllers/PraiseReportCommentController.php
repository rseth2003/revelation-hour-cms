<?php

namespace App\Http\Controllers;

use App\Models\PraiseReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PraiseReportCommentController extends Controller
{
    public function store(Request $request, PraiseReport $praiseReport): RedirectResponse
    {
        abort_unless($praiseReport->status === 'published', 404);
        $data = $request->validate(['name'=>['required','string','max:100'],'email'=>['nullable','email','max:190'],'message'=>['required','string','min:2','max:1000'],'website'=>['nullable','max:0']]);
        $praiseReport->comments()->create(['name'=>$data['name'],'email'=>$data['email'] ?? null,'message'=>$data['message'],'status'=>'pending','ip_hash'=>hash('sha256',(string)$request->ip().'|'.config('app.key'))]);
        return back()->with('success','Thank you. Your encouragement will appear after it has been reviewed.');
    }
}

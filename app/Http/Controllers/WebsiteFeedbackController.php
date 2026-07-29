<?php
namespace App\Http\Controllers;
use App\Models\WebsiteFeedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class WebsiteFeedbackController extends Controller {
 public function store(Request $request): RedirectResponse {
  $data=$request->validate(['name'=>['nullable','string','max:100'],'email'=>['nullable','email','max:190'],'rating'=>['required','integer','between:1,5'],'category'=>['required','in:general,design,content,technical,accessibility,other'],'message'=>['required','string','max:3000'],'website'=>['nullable','max:0']]);
  unset($data['website']); $data['status']='new'; WebsiteFeedback::create($data);
  return back()->with('success','Thank you. Your feedback has been received and will be reviewed.');
 }
}

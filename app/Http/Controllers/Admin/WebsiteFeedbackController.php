<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WebsiteFeedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class WebsiteFeedbackController extends Controller {
 public function index(Request $r): View { $items=WebsiteFeedback::query()->when($r->status,fn($q,$s)=>$q->where('status',$s))->latest()->paginate(20)->withQueryString(); return view('admin.feedback.index',compact('items')); }
 public function show(WebsiteFeedback $feedback): View { return view('admin.feedback.show',compact('feedback')); }
 public function update(Request $r, WebsiteFeedback $feedback): RedirectResponse { $feedback->update($r->validate(['status'=>['required','in:new,reviewed,resolved,archived'],'admin_notes'=>['nullable','string','max:3000'],'approved_for_display'=>['nullable','boolean']])); return back()->with('success','Feedback updated.'); }
 public function destroy(WebsiteFeedback $feedback): RedirectResponse { $feedback->delete(); return redirect()->route('admin.feedback.index')->with('success','Feedback deleted.'); }
}

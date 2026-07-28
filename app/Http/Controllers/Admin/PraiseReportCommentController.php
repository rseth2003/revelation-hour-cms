<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PraiseReportComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class PraiseReportCommentController extends Controller
{
 public function index(): View { $comments=PraiseReportComment::with('praiseReport')->latest()->paginate(20); return view('admin.praise-reports.comments',compact('comments')); }
 public function approve(PraiseReportComment $comment): RedirectResponse { $comment->update(['status'=>'approved']); return back()->with('success','Encouragement approved.'); }
 public function reject(PraiseReportComment $comment): RedirectResponse { $comment->update(['status'=>'rejected']); return back()->with('success','Encouragement hidden.'); }
 public function destroy(PraiseReportComment $comment): RedirectResponse { $comment->delete(); return back()->with('success','Encouragement deleted.'); }
}

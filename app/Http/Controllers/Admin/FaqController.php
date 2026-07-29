<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class FaqController extends Controller {
 public function index(): View { $faqs=Faq::orderBy('sort_order')->orderBy('id')->get(); return view('admin.faqs.index',compact('faqs')); }
 public function create(): View { return view('admin.faqs.form',['faq'=>new Faq]); }
 public function store(Request $r): RedirectResponse { Faq::create($this->data($r)); return redirect()->route('admin.faqs.index')->with('success','FAQ created.'); }
 public function edit(Faq $faq): View { return view('admin.faqs.form',compact('faq')); }
 public function update(Request $r,Faq $faq): RedirectResponse { $faq->update($this->data($r)); return redirect()->route('admin.faqs.index')->with('success','FAQ updated.'); }
 public function destroy(Faq $faq): RedirectResponse { $faq->delete(); return back()->with('success','FAQ deleted.'); }
 private function data(Request $r): array { $d=$r->validate(['question'=>['required','string','max:255'],'answer'=>['required','string','max:3000'],'sort_order'=>['nullable','integer','min:0'],'is_published'=>['nullable','boolean']]); $d['is_published']=$r->boolean('is_published'); return $d; }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PraiseReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PraiseReportController extends Controller
{
    public function index(): View { $reports=PraiseReport::withCount(['comments','approvedComments'])->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('created_at')->paginate(12); return view('admin.praise-reports.index',compact('reports')); }
    public function create(): View { return view('admin.praise-reports.create'); }
    public function store(Request $request): RedirectResponse { $data=$this->validated($request); $data['slug']=$this->slug($data['title']); $this->flags($request,$data); $this->uploads($request,$data); PraiseReport::create($data); return redirect()->route('admin.praise-reports.index')->with('success','Praise report created successfully.'); }
    public function edit(PraiseReport $praiseReport): View { return view('admin.praise-reports.edit',compact('praiseReport')); }
    public function update(Request $request,PraiseReport $praiseReport): RedirectResponse { $data=$this->validated($request); $data['slug']=$this->slug($data['title'],$praiseReport->id); $this->flags($request,$data); $this->uploads($request,$data,$praiseReport); $praiseReport->update($data); return redirect()->route('admin.praise-reports.index')->with('success','Praise report updated successfully.'); }
    public function destroy(PraiseReport $praiseReport): RedirectResponse { foreach(['photo_path','video_path','audio_path'] as $f) if($praiseReport->$f) Storage::disk('public')->delete($praiseReport->$f); $praiseReport->delete(); return back()->with('success','Praise report deleted.'); }
    private function validated(Request $r): array { return $r->validate(['title'=>['required','string','max:180'],'person_name'=>['nullable','string','max:150'],'category'=>['nullable','string','max:100'],'summary'=>['nullable','string','max:600'],'testimony'=>['required','string','max:20000'],'scripture_reference'=>['nullable','string','max:150'],'scripture_text'=>['nullable','string','max:2000'],'photo'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],'video'=>['nullable','file','mimes:mp4,webm,mov','max:102400'],'video_url'=>['nullable','url','max:500'],'audio'=>['nullable','file','mimes:mp3,m4a,wav,ogg','max:51200'],'testimony_date'=>['nullable','date'],'status'=>['required','in:draft,review,approved,published'],'sort_order'=>['nullable','integer','min:0','max:9999']]); }
    private function flags(Request $r,array &$d): void { $d['is_featured']=$r->boolean('is_featured'); $d['show_on_homepage']=$r->boolean('show_on_homepage'); $d['sort_order']=$d['sort_order']??0; }
    private function uploads(Request $r,array &$d,?PraiseReport $m=null): void { foreach(['photo'=>['photo_path','praise-reports/photos'],'video'=>['video_path','praise-reports/videos'],'audio'=>['audio_path','praise-reports/audio']] as $input=>$cfg) if($r->hasFile($input)){ if($m && $m->{$cfg[0]}) Storage::disk('public')->delete($m->{$cfg[0]}); $d[$cfg[0]]=$r->file($input)->store($cfg[1],'public'); } }
    private function slug(string $title,?int $ignore=null): string { $base=Str::slug($title)?:'praise-report'; $slug=$base; $i=2; while(PraiseReport::query()->when($ignore,fn($q)=>$q->whereKeyNot($ignore))->where('slug',$slug)->exists()) $slug=$base.'-'.$i++; return $slug; }
}

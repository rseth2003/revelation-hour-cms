<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livestream;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LivestreamController extends Controller
{
 public function index(): View {
  $streams=Livestream::query()->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('scheduled_start')->paginate(15);
  $stats=['total'=>Livestream::count(),'live'=>Livestream::all()->where('status','live')->count(),'upcoming'=>Livestream::all()->where('status','upcoming')->count(),'ended'=>Livestream::all()->where('status','ended')->count()];
  return view('admin.livestreams.index',compact('streams','stats'));
 }
 public function create(): View { return view('admin.livestreams.create'); }
 public function store(Request $request): RedirectResponse {
  $data=$this->validated($request); $data['slug']=Livestream::uniqueSlug($data['title']); $this->flags($request,$data); $this->upload($request,$data);
  if($data['is_featured']) Livestream::query()->update(['is_featured'=>false]);
  if($data['show_on_homepage']) Livestream::query()->update(['show_on_homepage'=>false]);
  Livestream::create($data); return redirect()->route('admin.livestreams.index')->with('success','Livestream created.');
 }
 public function edit(Livestream $livestream): View { return view('admin.livestreams.edit',compact('livestream')); }
 public function update(Request $request,Livestream $livestream): RedirectResponse {
  $data=$this->validated($request); $data['slug']=Livestream::uniqueSlug($data['title'],$livestream->id); $this->flags($request,$data); $this->upload($request,$data,$livestream);
  if($data['is_featured']) Livestream::query()->whereKeyNot($livestream->id)->update(['is_featured'=>false]);
  if($data['show_on_homepage']) Livestream::query()->whereKeyNot($livestream->id)->update(['show_on_homepage'=>false]);
  $livestream->update($data); return redirect()->route('admin.livestreams.index')->with('success','Livestream updated.');
 }
 public function destroy(Livestream $livestream): RedirectResponse { if($livestream->thumbnail_path) Storage::disk('public')->delete($livestream->thumbnail_path); $livestream->delete(); return back()->with('success','Livestream deleted.'); }
 public function duplicate(Livestream $livestream): RedirectResponse {
  $copy=$livestream->replicate(['slug','scheduled_start','scheduled_end','manual_status']); $copy->title=$livestream->title.' Copy'; $copy->slug=Livestream::uniqueSlug($copy->title); $copy->scheduled_start=null; $copy->scheduled_end=null; $copy->manual_status='automatic'; $copy->is_published=false; $copy->is_featured=false; $copy->show_on_homepage=false; $copy->save();
  return redirect()->route('admin.livestreams.edit',$copy)->with('success','Broadcast duplicated as a draft.');
 }
 private function validated(Request $request): array { return $request->validate([
  'title'=>['required','string','max:180'],'subtitle'=>['nullable','string','max:255'],'speaker'=>['nullable','string','max:150'],'series'=>['nullable','string','max:150'],
  'description'=>['nullable','string','max:10000'],'platform'=>['required','in:'.implode(',',array_keys(Livestream::PLATFORMS))],'stream_url'=>['required','url','max:1000'],
  'thumbnail'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],'scheduled_start'=>['nullable','date'],'scheduled_end'=>['nullable','date','after_or_equal:scheduled_start'],
  'manual_status'=>['required','in:automatic,live,ended'],'sort_order'=>['nullable','integer','min:0','max:9999'],
  'is_featured'=>['nullable','boolean'],'show_on_homepage'=>['nullable','boolean'],'is_published'=>['nullable','boolean'],
 ]); }
 private function flags(Request $request,array &$data): void { foreach(['is_featured','show_on_homepage','is_published'] as $f) $data[$f]=$request->boolean($f); }
 private function upload(Request $request,array &$data,?Livestream $stream=null): void { if(!$request->hasFile('thumbnail')) return; if($stream?->thumbnail_path) Storage::disk('public')->delete($stream->thumbnail_path); $data['thumbnail_path']=$request->file('thumbnail')->store('livestreams/thumbnails','public'); }
}

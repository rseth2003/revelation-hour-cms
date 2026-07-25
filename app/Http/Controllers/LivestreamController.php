<?php
namespace App\Http\Controllers;

use App\Models\Livestream;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LivestreamController extends Controller
{
 public function index(Request $request): View {
  $published=Livestream::query()->where('is_published',true)->get();
  $live=$published->first(fn($s)=>$s->status==='live');
  $next=$published->filter(fn($s)=>$s->status==='upcoming')->sortBy('scheduled_start')->first();
  $archive=Livestream::query()->where('is_published',true)
   ->when($request->filled('search'),fn($q)=>$q->where(fn($x)=>$x->where('title','like','%'.$request->string('search')->trim().'%')->orWhere('speaker','like','%'.$request->string('search')->trim().'%')->orWhere('series','like','%'.$request->string('search')->trim().'%')))
   ->orderByDesc('scheduled_start')->get()->filter(fn($s)=>$s->status==='ended');
  return view('pages.livestreams.index',compact('live','next','archive'));
 }
 public function show(Livestream $livestream): View { abort_unless($livestream->is_published,404); return view('pages.livestreams.show',compact('livestream')); }
}

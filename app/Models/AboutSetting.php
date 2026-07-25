<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AboutSetting extends Model {
    protected $fillable=['story_heading','story_body','vision_heading','vision_body','mission_heading','mission_body','motto','motto_explanation'];
    public static function current(): self { return static::firstOrCreate(['id'=>1],['story_heading'=>'A ministry grounded in the Word and led by the Spirit','story_body'=>'Revelation Hour Ministries International proclaims Jesus Christ, disciples believers, strengthens families and serves communities through biblical teaching, prayer, worship and compassionate outreach.','vision_heading'=>'Our Vision','mission_heading'=>'Our Mission']); }
}

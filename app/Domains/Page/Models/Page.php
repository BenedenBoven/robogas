<?php declare(strict_types=1);

namespace App\Domains\Page\Models;

use BenedenBoven\Atom\Application\Models\Page as AtomPage;
use BenedenBoven\Atom\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Page extends AtomPage {


    protected       $fillable          = ['title', 'long_title', 'body', 'visible_as_page', 'header_id'];
    protected       $isPublishable     = true;
    protected array $atomReplaceFields = [
        'summary' => 'atom-nucleus::html-elements.simple-wysiwyg-field'
    ];


    public function images(): MorphMany {
        return $this->morphMany(Media::class, 'model')->where('type', 'image')->orderBy('prio', 'asc');
    }

}

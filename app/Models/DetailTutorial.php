<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DetailTutorial extends Model
{
    protected $fillable = [
        'master_tutorial_id',
        'type',
        'text',
        'gambar',
        'code',
        'url',
        'order',
        'status'
    ];

    public function master()
    {
        return $this->belongsTo(MasterTutorial::class);
    }

    public function getParsedCodeAttribute(): array {
        if (empty($this->code)) {
            return ['language' => 'plaintext', 'code' => ''];
        }

        // Format: python```print("hello")```
        if (preg_match('/^(\w+)```([\s\S]*)```$/', trim($this->code), $matches)) {
            return [
                'language' => $matches[1],
                'code'     => $matches[2],
            ];
        }

        // Fallback: tidak ada prefix bahasa, tampilkan apa adanya
        return ['language' => 'plaintext', 'code' => $this->code];
    }

    public static function buildCodeField(string $language, string $code): string {
        return $language . '```' . $code . '```';
    }

    public function getContentPreview(): string {
        return match ($this->type) {
            'text'   => Str::limit($this->text, 70),
            'gambar' => basename($this->gambar ?? '-'),
            'code'   => Str::limit($this->getParsedCodeAttribute()['code'], 70),
            'url'    => $this->url ?? '-',
            default  => '-',
        };
    }

    public function getTypeBadge() {
        return match ($this->type) {
            'text'   => ['label' => 'Text',  'color' => 'bg-blue-100/10 border border-blue-400/30 text-blue-400'],
            'gambar' => ['label' => 'Gambar', 'color' => 'bg-purple-100/10 border border-purple-400/30 text-purple-400'],
            'code'   => ['label' => 'Code',  'color' => 'bg-orange-100/10 border border-orange-400/30 text-orange-400'],
            'url'    => ['label' => 'URL',   'color' => 'bg-green-100/10 border border-green-400/30 text-green-400'],
            default  => ['label' => '?',     'color' => 'bg-gray-100/10 border border-gray-400/30 text-gray-400'],
        };
    }
}

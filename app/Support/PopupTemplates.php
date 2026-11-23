<?php

namespace App\Support;

use App\Models\MessageTemplate;

/**
 * Templates for the WhatsApp / Email popup on Transactions, Prospects, Quote Requests and the
 * client page, in the shape that popup already uses: {id, n: name, sub: subject, t: text, ch: wa|em}.
 * They come from Messages & Email → Templates, so an edit in one place shows everywhere.
 */
class PopupTemplates
{
    public static function all(): array
    {
        try {
            return MessageTemplate::orderBy('channel', 'desc')->orderBy('id')->get()
                ->map(fn ($t) => [
                    'id' => $t->id,
                    'n' => $t->name,
                    'sub' => $t->subject,
                    // the popup fills {name} with the first name; Messages uses {friend} for that
                    't' => str_ireplace('{friend}', '{name}', (string) $t->body),
                    'ch' => $t->channel === 'em' ? 'em' : 'wa',
                ])->values()->all();
        } catch (\Throwable $e) {
            return [];
        }
    }
}

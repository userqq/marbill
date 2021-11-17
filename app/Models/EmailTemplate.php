<?php

namespace App\Models;

use ValueError;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    public const PLACEHOLDER_PATTERN = '#{{\s*(.*?)\s*}}#';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'body',
        'subject',
        'user_id',
    ];

    public static function validate(string $templateString, array $allowedPlaceholders): void
    {
        $openingBracketsCount = substr_count($templateString, '{{');
        $closingBracketsCount = substr_count($templateString, '}}');
        $placeholdersCount    = preg_match_all(static::PLACEHOLDER_PATTERN, $templateString, $matches);

        if ($openingBracketsCount !== $closingBracketsCount | $closingBracketsCount !== $placeholdersCount) {
            throw new ValueError('Incorrect usage of placeholder special chars');
        }

        $unallowedPlaceholders = array_diff($matches[1], $allowedPlaceholders);
        if (count($unallowedPlaceholders)) {
            throw new ValueError(sprintf('Placeholder(s): "%s" are not allowed', implode(', ', $unallowedPlaceholders)));
        }
    }

    public function formatEmail(Customer $customer): array
    {
        $replacer = static function (array $matches) use ($customer): string {
            return $customer->{$matches[1]};
        };

        return [
            preg_replace_callback(static::PLACEHOLDER_PATTERN, $replacer, $this->subject),
            preg_replace_callback(static::PLACEHOLDER_PATTERN, $replacer, $this->body),
        ];
    }
}

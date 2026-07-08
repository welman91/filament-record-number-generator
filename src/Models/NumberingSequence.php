<?php

namespace Welman91\FilamentRecordNumberGenerator\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Welman91\FilamentRecordNumberGenerator\Enums\ResetFrequency;

class NumberingSequence extends Model
{
	use SoftDeletes;

	protected $guarded = [];

	protected function casts(): array
	{
		return [
			'reset_frequency' => ResetFrequency::class,
			'is_gap_free' => 'boolean',
			'is_active' => 'boolean',
			'custom_tokens' => 'array',
			'fiscal_year_start_month' => 'integer',
			'initial_value' => 'integer',
		];
	}

	public function counters(): HasMany
	{
		return $this->hasMany(NumberingCounter::class);
	}

	/**
	 * Scope to find the active sequence for a given model and attribute.
	 */
	public function scopeForModel(Builder $query, Model $model, ?string $attribute = null): Builder
	{
		$query
			->where('is_active', true)
			->where('model_type', $model->getMorphClass())
			->when($attribute, fn(Builder $q, string $attr) => $q->where('attribute', $attr));

		return $query;
	}
}

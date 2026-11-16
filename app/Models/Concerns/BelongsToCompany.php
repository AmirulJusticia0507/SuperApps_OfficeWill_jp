<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToCompany
{
	public static function bootBelongsToCompany(): void
	{
		static::addGlobalScope('company', function (Builder $builder): void {
			if (request()->attributes->has('tenant.company_id')) {
				$companyId = request()->attributes->get('tenant.company_id');
				$companyColumn = $builder->getModel()->qualifyColumn('company_id');

				$builder->where(function (Builder $query) use ($companyId, $companyColumn): void {
					$query->where($companyColumn, $companyId);

					if ($query->getModel()->includesSharedCompanyRecords()) {
						$query->orWhere($companyColumn, 0);
					}
				});
			}
		});

		static::creating(function (Model $model): void {
			if (!request()->attributes->has('tenant.company_id')) {
				return;
			}

			abort_if(
				$model->getKeyName() === 'company_id',
				403,
				'Only a global administrator can create companies.',
			);

			$companyId = request()->attributes->get('tenant.company_id');
			$requestedCompanyId = $model->getAttribute('company_id');

			abort_if(
				$requestedCompanyId !== null && (string) $requestedCompanyId !== (string) $companyId,
				403,
				'You cannot create records for another company.',
			);

			$model->setAttribute('company_id', $companyId);
		});

		static::updating(function (Model $model): void {
			if (!request()->attributes->has('tenant.company_id')) {
				return;
			}

			abort_unless(
				(string) $model->getAttribute('company_id') === (string) request()->attributes->get('tenant.company_id'),
				403,
				'You cannot modify records for another company.',
			);
		});
	}

	public function includesSharedCompanyRecords(): bool
	{
		return false;
	}
}

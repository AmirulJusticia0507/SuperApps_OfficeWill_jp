<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait ValidatesModelInput
{
	protected function validatedModelInput(Request $request, Model $model): array
	{
		$rules = [];
		$primaryKey = $model->getKeyName();

		foreach ($model->getFillable() as $field) {
			if ($field === $primaryKey) {
				continue;
			}

			if ($field === 'company_id' || preg_match('/(?:^|_)id$/', $field)) {
				$rules[$field] = ['sometimes', 'nullable', 'integer'];
			} elseif (preg_match('/(?:order|rank|digits|count|number|conducted|score)$/', $field)) {
				$rules[$field] = ['sometimes', 'nullable', 'numeric'];
			} elseif (preg_match('/(?:privileges|authority|selection|correct_answer)$/', $field)) {
				$rules[$field] = ['sometimes', 'nullable', 'boolean'];
			} elseif (preg_match('/(?:date|datetime|deadline)$/', $field)) {
				$rules[$field] = ['sometimes', 'nullable', 'date'];
			} else {
				$rules[$field] = ['sometimes', 'nullable', 'string', 'max:255'];
			}
		}

		return $request->validate($rules);
	}
}

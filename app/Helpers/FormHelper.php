<?php

namespace App\Helpers;

class FormHelper
{

	public static function initInput(array $input)
	{
		$icon = $input['icon'] ?? '';
		$type = $input['type'] ?? 'text';
		$variant = $input['variant'] ?? 'default';
		$name = $input['name'] ?? '';
		$value = $input['value'] ?? '';
		$desc = $input['desc'] ?? '';
		$label = $input['label'] ?? StringHelper::toTitle($name) ?? '';
		$id = $input['id'] ?? $name;
		$placeholder = $input['placeholder'] ??
			ucfirst(str_replace('_',' ',$label));
		$attr = $input['attr'] ?? '';
		$opts = $input['opts'] ?? [];

		return array_replace_recursive($input, [
			'icon' => $icon,
			'type' => $type,
			'variant' => $variant,
			'name' => $name,
			'desc' => $desc,
			'value' => $value,
			'label' => $label,
			'id' => $id,
			'placeholder' => $placeholder,
			'attr' => $attr,
			'opts' => $opts,
		]);
	}
	
}
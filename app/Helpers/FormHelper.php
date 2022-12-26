<?php

namespace App\Helpers;

class FormHelper
{

	public static function initInput(array $input) :array
	{
		$icon = $input['icon'] ?? '';
		$type = $input['type'] ?? 'text';
		$variant = $input['variant'] ?? 'default';
		$name = $input['name'] ?? '';
		$value = $input['value'] ?? old($input['name']) ?? '';
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

	public static function initForm(array $form) :array
	{
		$variant = $form['variant'] ??= 'single';
		
		if ($variant === 'multiform') {

			$basicform = static::initBasicForm($form);
			$basicform['inputs'] = static::initMultiForm($basicform['inputs']);
			return [
				'variant' => $variant,
				...$basicform,
			];
			
		} elseif ($variant === 'dimensionalform') {
		} else return static::initBasicForm($form);
	}

	private static function initBasicForm(array $form) :array
	{
		$variant = $form['variant'] ?? 'single';
		$cols = $form['cols'] ?? 'col-12 col-sm-6';
		$title = $form['title'] ?? null;
		$action = $form['action'] ?? null;
		$method = $form['method'] ?? 'POST';
		$submethod = $form['submethod'] ?? null;
		$enctype = $form['enctype'] ?? 'application/x-www-form-urlencoded';
		$button = $form['button'] ?? [];
		$inputs = $form['inputs'] ?? [];

		return [
			'variant' => $variant,
			'cols' => $cols,
			'title' => $title,
			'action' => $action,
			'method' => $method,
			'submethod' => $submethod,
			'enctype' => $enctype,
			'button' => $button,
			'inputs' => $inputs,
		];
	}

	private static function initMultiForm(array $inputs) :array
	{
		$newinputs = [];
		foreach ($inputs as $form) {
			$title = $form['title'] ?? null;
			$inputs = $form['inputs'] ?? [];

			$newinputs[] = [
				'title' => $title,
				'inputs' => $inputs,
			];
		} return $newinputs;
	}

	private static function initDimensionalForm(array $inputs) :array
	{
		$forms = [];
		foreach ($inputs as $form) {
			$form = static::initBasicForm($form);
			$title = $form['title'] ?? null;
			
			$forms[] = [
				...$form,
				'title' => $title,
			];
		} return $forms;
	}
	
}
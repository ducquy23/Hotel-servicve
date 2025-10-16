<?php
use Fuel\Core\Asset;

$name = isset($name) ? $name : 'icon';
$value = isset($value) ? $value : '';
$label = isset($label) ? $label : 'Icon';
$placeholder = isset($placeholder) ? $placeholder : 'Chọn icon';

$figma_icons = \Func_Icon::get_figma_icons();
?>

<div class="mb-1">
	<label class="form-label" for="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($label) ?></label>
	<div class="row g-1 align-items-center">
		<div class="col">
			<select class="form-select js-select2-icon" id="<?= htmlspecialchars($name) ?>" name="<?= htmlspecialchars($name) ?>" data-placeholder="<?= htmlspecialchars($placeholder) ?>">
				<option value=""><?= htmlspecialchars($placeholder) ?></option>
				<?php if (!empty($figma_icons)): ?>
					<?php foreach ($figma_icons as $icon): ?>
						<option value="<?= $icon['value'] ?>" data-img="<?= \Uri::base() . $icon['value'] ?>" <?= $value === $icon['value'] ? 'selected' : '' ?>><?= htmlspecialchars($icon['name']) ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
	</div>
</div>




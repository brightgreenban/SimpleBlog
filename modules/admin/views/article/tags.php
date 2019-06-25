<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="arcticle-form">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-6">

				<?php $form = ActiveForm::begin(); ?>

				<?= Html::dropDownList('tags', $selectedTags, $tags, ['class' => 'form-control', 'multiple'=>true]) ?>

				<div class="form-group">
					<br>
					<?= Html::submitButton('Выбрать', ['class' => 'btn btn-success']) ?>
				</div>
				
			</div>
		</div>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>
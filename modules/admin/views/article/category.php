<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="arcticle-form">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-6">

				<?php $form = ActiveForm::begin(); ?>

				<?= Html::dropDownList('category', $selectedCategory, $categories, ['class' => 'form-control']) ?>

				<div class="form-group">
					<br>
					<?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
				</div>
				
			</div>
		</div>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>
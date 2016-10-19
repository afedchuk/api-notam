<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title ='Geo Location for the NOTAM';
?>
<div class="index">
	<?php $form = yii\widgets\ActiveForm::begin(); ?>
		<div class="input-group">
			    <?= $form->field($notam, 'icao')->textInput(['placeholder' => 'Please fill ICAO code', 'class' => 'form-control', 'maxlength' => 4])->label(false); ?>
			    <span class="input-group-btn">
			    	<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'onclick' => 'NotamMap.getNotam(); return false;', 'value' => 'Submit']) ?>
			    </span>
		</div>
	<?php yii\widgets\ActiveForm::end(); ?> 
	<p>For example are some ICAO codes: EGLL, EGGW, SBSP</p>
	<br/>
	<div id="map"></div>
</div>

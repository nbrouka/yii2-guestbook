<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
 
<div class="guestbook-item">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="media">
				<?php if(!empty($model->image)):?>
				<div class="media-left">
					<a href="<?= Html::encode($model->image) ?>" class="lightbox">
						<img src="<?= Html::encode($model->image) ?>" class="media-object">
					</a>
				</div>
				<?php endif;?>
				<div class="media-body">
					 <?= Html::tag('h4', $model->name . ' | <a href="mailto:'.$model->email.'"> Send me: '.$model->email . '</a>', ['class' => 'media-heading']) ?> 	
					 <span>
					 	<?= HtmlPurifier::process($model->message) ?> 	
					 </span>	
				</div>
				<div class="media-right text-right">
					 <?= Html::tag('time', Html::encode(
					 	Yii::$app->formatter->asDatetime($model->msgputtime, "php:d.m.Y H:i:s")
					 )) ?> 	
				</div>
				<?php if(!empty($model->file)):?>
				<hr>	
				<div class="media-bottom text-right">
					<b>Attached file:</b>
					<a href="<?= Html::encode($model->file) ?>">
						<?php 
							$IndexLastSlash = strrpos(Html::encode($model->file), "/");
							$fileName = substr(Html::encode($model->file), $IndexLastSlash + 1);
							echo $fileName;
						?>
					</a>	
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
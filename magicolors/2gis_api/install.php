<?php
include_once(__DIR__.'/cextrest.php');

$install_result = CRestExt::installApp();

if($install_result['rest_only'] === false):?>
<head>
	<script src="//api.bitrix24.com/api/v1/"></script>
	<?if($install_result['install'] == true):?>
	<script>
		BX24.init(function(){
			BX24.installFinish();
		});
	</script>
	<?endif;?>
</head>
<body>
	<?if($install_result['install'] == true):?>
		installation has been finished
	<?else:?>
        <pre><?print_r($install_result);?></pre>
		installation error
	<?endif;?>
</body>
<?endif;
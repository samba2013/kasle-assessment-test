<?php

require 'lib/IShape.php';
require 'lib/Square.php';
require 'lib/Circle.php';
require 'lib/Rectangular.php';

$shapeConfigs = array(
			"circle"=>['radius'],
			"square"=>['side_length'],
			"rectangular"=>['length','width']
);

$shapes = ['circle','square','rectangular'];

$result = null;
$selectedShapeId = 0;
if(!empty($_POST) &&  isset($_POST['shape']['type'])){
	$typeId = $selectedShapeId = intval($_POST['shape']['type']);
	$shapeName = isset($shapes[$typeId])?$shapes[$typeId]:'circle';
	$shapeClass	 = ucfirst($shapeName);
	$arguments = isset($_POST['shape'][$shapeName])?$_POST['shape'][$shapeName]:[];

	/** @var $shapeCls IShape **/
	$shapeCls = new $shapeName($arguments);
	$areaValue = number_format($shapeCls->getAreaValue());
	$result =<<<EOL
<div class="card">
  <div class="card-header">
    Result
  </div>
  <div class="card-body">
  		Area value of shape {$shapeClass} is <strong>{$areaValue}</strong>
  </div>
</div>
EOL;

}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<title>Shape calculator</title>
</head>
<body>
	<h1 style="text-align: center;">Shape space calculator</h1>


	<div class="container" style="margin-top: 10%">
	  <div class="row">
	    <div class="col">
	      
	      <form action="" method="POST">
			  <div class="form-group">
			    <label for="shapeType">Shape type</label>
			    <select class="form-control" id="shapeType" name="shape[type]" aria-describedby="emailHelp" placeholder="Select shape type">
			    		<?php 

			    		foreach ($shapes as $key => $value) {
			    			?>
			    			<option <?php echo $selectedShapeId==$key?"selected":"" ?> value="<?php echo $key;?>"><?php echo ucfirst($value);?></option>
			    			<?php
			    		}
			    		?>
			    </select>
			    <small id="emailHelp" class="form-text text-muted">Each shape require diffrent dimentions</small>
			  </div>
			  <div class="form-group">
			    <label for="dim-controls">Required dimentions *</label>
			     <div id="dim-controls">
			     	 

			     </div>
			     <small id="emailHelp" class="form-text text-muted">Measure unit is in square metre ( m&#178; )</small>
			  </div>

			  <button type="submit" class="btn btn-primary">Calculate</button>
			</form>
	    </div>
	    <div class="col">
	      <?php if($result){ 


	      				echo $result;
		  } ?>
	    </div>
	  </div>
	</div>

	
</body>
<script type="text/javascript">
	function getFormDimentions(conf,shape) {
		let retHtml='';
		try{
				conf.forEach(function(value,key){
							
							let labelName = value.charAt(0).toUpperCase() + value.slice(1);
							labelName = labelName.replace("_"," ");
							let input=['<div class="form-group row">'];
							input.push('<label for="id-'+value+'_'+shape+'" class="col-sm-3 col-form-label">'+labelName+'</label>');
							input.push('<div class="col-sm-9">');
							input.push('<input type="text" name="shape['+shape+']['+value+']" required  class="form-control" id="id-'+value+'_'+shape+'" placeholder="'+value.replace('_',' ')+'">');
							input.push('</div></div>');
							retHtml+=input.join("");

				});
		}catch(e){
			console.log("[Error] An error occurred while rendering : "+e);
		}
		return retHtml;
		
	}
	$(function() {
		let shapesConfig=JSON.parse('<?php echo json_encode($shapeConfigs); ?>');
		let shapes = JSON.parse('<?php echo json_encode($shapes); ?>');
		let resultOutput = $("#dim-controls");

		$("#shapeType").on("change",function() {
			let currentVal = $(this).val();
			let currentShape = shapes[currentVal];
			if(currentShape !== undefined && shapesConfig[currentShape] !== undefined){
				console.log(shapesConfig[currentShape],currentShape);
				let outputHtml = getFormDimentions(shapesConfig[currentShape],currentShape);
				resultOutput.html(outputHtml);
			}
			

		}).trigger("change");
	})
</script>
</html>
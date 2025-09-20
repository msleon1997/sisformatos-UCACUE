<?php

$id = (int) $_settings->userdata('id');

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$meta = [];
if ($row = $result->fetch_assoc()) {
    foreach ($row as $k => $v) {
        $meta[$k] = $v;
    }
}

?>
<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group">
					<label for="name">Nombres Completos</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Apellidos Completos</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Número Cédula</label>
					<input type="text" name="cedula" id="cedula" class="form-control" value="<?php echo isset($meta['cedula']) ? $meta['cedula'] : '' ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="username">Correo Institucional</label>
					<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="password">Contraseña</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
					<small><i>Deje esto en blanco si no desea cambiar la contraseña</i></small>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
						<label class="custom-file-label" for="customFile">Examinar</label>
					</div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-primary" form="manage-user">Actualizar</button>
			</div>
		</div>
	</div>
</div>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
	.card-primary.card-outline {
    border-top: 3px solid #ff0000;
    }
	
</style>
<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
                    location.href = './?page=matriculacion';
					location.reload();
                    
                   
				}
                end_loader()
			}
		})
	})
</script>
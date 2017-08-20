<?php echo $header; ?>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [
			<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
			<?php $i++ ?>
			<?php if ($i < count($breadcrumbs)) { ?>
			<?php if ($i == 1) {?>
			<?php } else {?>
			{
				"@type": "ListItem",
				"position": <?php echo ($i-1); ?>,
				"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					"name": "<?php echo $breadcrumb['text']; ?>"
				}
			},
			<?php }?>
			<?php } else { ?>
			{
				"@type": "ListItem",
				"position": <?php echo ($i-1); ?>,
				"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					"name": "<?php echo $breadcrumb['text']; ?>"
				}
			}
			<?php }}?>
		]
	}
</script>
	<main>
		<div class="container">
			<nav class="breadcrumb-wrapper transparent z-depth-0">
				<div class="nav-wrapper">
					<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
					<?php $i++ ?>
					<?php if ($i < count($breadcrumbs)) { ?>
					<?php if ($i == 1) {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><i class="material-icons">home</i></a>
					<?php } else {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></a>
					<?php }?>
					<?php } else { ?>
						<span class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></span>
					<?php }}?>
				</div>
			</nav>
			<h1><?php echo $heading_title; ?></h1>
			<?php if ($column_left && $column_right) { ?>
				<?php $main = 's12 l6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; ?>
			<?php } else { ?>
				<?php $main = 's12'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div id="content" class="col <?php echo $main; ?>">
					<?php echo $content_top; ?>
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
						<div class="card-panel">
							<div id="account">
								<h2><?php echo $text_password; ?></h2>
								<div class="section">
									<div class="input-field">
										<input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="validate">
										<label for="input-password" class="required"><?php echo $entry_password; ?></label>
									</div>
									<div class="input-field">
										<input type="password" name="confirm" value="<?php echo $confirm; ?>" id="input-confirm" class="validate">
										<label for="input-confirm" class="required"><?php echo $entry_confirm; ?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s6">
								<div class="href-underline">
									<a class="btn-flat waves-effect waves-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
								</div>
							</div>
							<div class="col s6">
								<div class="flex-reverse no-padding">
									<button type="submit" class="btn waves-effect waves-light red" value="<?php echo $button_continue; ?>"><?php echo $button_continue; ?></button>
								</div>
							</div>
						</div>
					</form>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($error_password) { ?>
				Materialize.toast('<i class="material-icons left">warning</i><?php echo $error_password; ?>',7000,'toast-warning')
			<?php } ?>
			<?php if ($error_confirm) { ?>
				Materialize.toast('<i class="material-icons left">warning</i><?php echo $error_confirm; ?>',7000,'toast-warning')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>
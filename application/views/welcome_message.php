<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html><head><title>Upload Form</title></head>
<body>

<?php print_r($notif)?>
<?php echo form_open_multipart('welcome/do_upload');?>
<input type="file" name="userfile" />
<br /><br />
<input type="submit" value="upload" />
<?php echo form_close() ?>

</body></html>

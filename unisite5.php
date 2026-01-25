<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

error_reporting(E_ERROR | E_PARSE);
session_start();

$SCRIPT_NAME = $_SERVER["SCRIPT_NAME"];
$BASE_PATH = __dir__ ;
$BLOCK_NEXT = false;

function debug($message=null){
    $content = '';

    if (is_array($message)) {
        $content .= var_export($message, true).PHP_EOL;
    } elseif (is_object($message)) {
        $content .= var_export($message, true).PHP_EOL;
    } else {
        $content .= $message.PHP_EOL;
    }

    if(isset($content)) {
        file_put_contents('debug.log', $content, FILE_APPEND);
    }

}

if($_GET['step'] && $_GET['step'] != 1){
	if(!$_SESSION["license"]){
		header("Location: ".$SCRIPT_NAME."?step=1");
	}
}

if($_POST['action'] == "save_dist"){

	  $filename = md5(uniqid()) . ".zip";

	  if(move_uploaded_file($_FILES["dist"]["tmp_name"], $BASE_PATH . '/' . $filename)){

	  	  file_put_contents($BASE_PATH . '/dist.zip', file_get_contents($BASE_PATH . '/' . $filename), FILE_APPEND);	

	  	  unlink($BASE_PATH . '/' . $filename);

	  }

}

if($_POST['action'] == "extract_dist"){

	  $filename = "dist.zip";

	  if(file_exists($BASE_PATH . '/' . $filename)){
	          
			$zip = new ZipArchive;
			
			if ($zip->open($BASE_PATH . '/' . $filename) === TRUE) {

			    $zip->extractTo($BASE_PATH);
			    $zip->close();

	            $data = file_get_contents("https://uni-api.com.ru/api.php?action=get_files_license&license=".$_SESSION["license"]."&domain=".$_SERVER["SERVER_NAME"]);

	            if($data){

	            	$filename = "licenses.zip";

	            	if(file_put_contents($BASE_PATH . '/' . $filename, $data)){

	            		if ($zip->open($BASE_PATH . '/' . $filename) === TRUE) {

						    $zip->extractTo($BASE_PATH);
						    $zip->close();

				            unlink($BASE_PATH . '/' . $filename);

				            include $BASE_PATH . '/license_install.php';

				            echo json_encode(["status" => true]);

	            		}else{
	            			echo json_encode(["status" => false, "answer" => "Ошибка распаковки файлов лицензии."]);
	            		}

	            	}else{
	            		echo json_encode(["status" => false, "answer" => "Ошибка сохранения файлов лицензии."]);
	            	}
	            	
	            }else{
	            	echo json_encode(["status" => false, "answer" => "Ошибка получения файлов лицензии."]);
	            }

			    
			}else{
			    echo json_encode(["status" => false, "answer" => "Ошибка распаковки дистрибутива."]);
			}

	  }else{
		  echo json_encode(["status" => false, "answer" => "Дистрибутив не найден."]);
	  }	

	  exit;

}

if($_POST['action'] == "check_license"){

	  $data = json_decode(file_get_contents("https://uni-api.com.ru/api.php?action=check_license&license=".$_POST['license']."&domain=".$_SERVER["SERVER_NAME"]), true);

	  if($data["status"]){

	  	  $_SESSION["license"] = $_POST['license'];

	  	  echo json_encode($data);

	  }else{
	  	  echo json_encode($data);
	  }	

	  exit;

}

if($_POST['action'] == "check_connect_db"){

	  if($_POST['db_driver'] && $_POST['db_host'] && $_POST['db_name'] && $_POST['db_user'] && $_POST['db_pass']){

	  		if(file_exists($BASE_PATH . '/dist.zip')){
				try {

				  $tables = [];

				  $pdo = new PDO($_POST['db_driver'].':host='.$_POST['db_host'].';dbname='.$_POST['db_name'].';port='.$_POST['db_port'], $_POST['db_user'], $_POST['db_pass']);

				  $pdo->exec("set names utf8mb4");

				  $result = $pdo->prepare('SHOW TABLES FROM '.$_POST['db_name']);
				  $result->execute();

				  foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
				  	$tables[] =  $value["Tables_in_".$_POST['db_name']];
				  }

				  if($tables) $pdo->exec('drop table '.implode(",", $tables));

				  $_SESSION["db"]["driver"] = $_POST['db_driver'];
				  $_SESSION["db"]["port"] = $_POST['db_port'];
				  $_SESSION["db"]["host"] = $_POST['db_host'];
				  $_SESSION["db"]["name"] = $_POST['db_name'];
				  $_SESSION["db"]["user"] = $_POST['db_user'];
				  $_SESSION["db"]["pass"] = $_POST['db_pass'];

	              $tables = glob($BASE_PATH.'/core/tables/*.sql');

	              if (count($tables)) {
	                foreach ($tables as $path) {
	                	$pdo->exec(file_get_contents($path));
	                }
	              }

				  echo json_encode(["status" => true]);

				} catch(PDOException $e) {
					echo json_encode(["status" => false, "answer" => $e->getMessage()]);
				}
			}

	  }else{
	  	  echo json_encode(["status" => false, "answer" => "Заполните все поля"]);
	  }

	  exit;

}

if($_POST['action'] == "finish"){

	  if($_POST['project_name'] && $_POST['user_name'] && $_POST['user_email'] && $_POST['user_pass']){

	  		if(file_exists($BASE_PATH . '/dist.zip')){
		  		try {

			  		$prefix_path = trim(str_replace($_SERVER['DOCUMENT_ROOT'], "", $BASE_PATH), "/");
			        $encryption_token = md5(uniqid().time());
			        $dashboard_alias = "dashboard_".md5(uniqid().time());
			        $access_key = hash('sha256', time().uniqid());

			        $config = file_get_contents($BASE_PATH."/config/app.php");
			        $config = preg_replace("/\"prefix_path\".*/i", '"prefix_path" => "'.$prefix_path.'",' , $config);
			        $config = preg_replace("/\"encryption_token\".*/i", '"encryption_token" => "'.$encryption_token.'",' , $config);
			        $config = preg_replace("/\"signature_hash\".*/i", '"signature_hash" => "'.md5(uniqid().time()).'",' , $config);
			        $config = preg_replace("/\"private_service_key\".*/i", '"private_service_key" => "'.md5(uniqid().time()).'",' , $config);
			        $config = preg_replace("/\"dashboard_alias\".*/i", '"dashboard_alias" => "'.$dashboard_alias.'",' , $config);
			        file_put_contents($BASE_PATH."/config/app.php", $config);

			        $config = file_get_contents($BASE_PATH."/config/db.php");
			        $config = preg_replace("/\"driver\".*/i", '"driver" => "'.$_SESSION["db"]["driver"].'",' , $config);
			        $config = preg_replace("/\"port\".*/i", '"port" => "'.$_SESSION["db"]["port"].'",' , $config);
			        $config = preg_replace("/\"host\".*/i", '"host" => "'.$_SESSION["db"]["host"].'",' , $config);
			        $config = preg_replace("/\"database\".*/i", '"database" => "'.$_SESSION["db"]["name"].'",' , $config);
			        $config = preg_replace("/\"user\".*/i", '"user" => "'.$_SESSION["db"]["user"].'",' , $config);
			        $config = preg_replace("/\"password\".*/i", '"password" => "'.$_SESSION["db"]["pass"].'",' , $config);
			        file_put_contents($BASE_PATH."/config/db.php", $config);

			        rename($BASE_PATH."/resources/view/dashboard", $BASE_PATH."/resources/view/".$dashboard_alias);

			        chmod($BASE_PATH . "/app/Systems/Video/ffmpeg", 0777);
			        chmod($BASE_PATH . "/app/Systems/Video/ffprobe", 0777);

			        $pdo = new PDO($_SESSION["db"]["driver"].':host='.$_SESSION["db"]["host"].';dbname='.$_SESSION["db"]["name"].';port='.$_SESSION["db"]["port"], $_SESSION["db"]["user"], $_SESSION["db"]["pass"]);

			        $pdo->exec("TRUNCATE TABLE `uni_users`");
			        $pdo->exec("TRUNCATE TABLE `uni_auth_access_key`");

			        $pdo->exec('INSERT INTO uni_users (admin, name, email, password, time_create, status, role_id, alias, uniq_hash, avatar) VALUES (1, "'.$_POST['user_name'].'", "'.$_POST['user_email'].'", "'.password_hash($_POST['user_pass'].$encryption_token, PASSWORD_DEFAULT).'", "'.date("Y-m-d H:i:s").'", 1, 1, "'.hash('sha256', time().uniqid()).'", "'.hash('sha256', time().uniqid()).'", "https://uni-api.com.ru/assets/avatar-user.jpg")');
			        $pdo->exec('INSERT INTO uni_auth_access_key (user_id, access_key) VALUES ('.$pdo->lastInsertId().',"'.$access_key.'")');
			        $pdo->exec("UPDATE uni_settings SET value='".$_POST['project_name']."' WHERE name='project_name'");
			        $pdo->exec("UPDATE uni_settings SET value='".$_POST['project_name']."' WHERE name='project_title'");
			        $pdo->exec("UPDATE uni_settings SET value='".$_POST['user_email']."' WHERE name='contact_email'");
			        $pdo->exec("UPDATE uni_settings SET value='".$_POST['user_email']."' WHERE name='mailer_from_email'");
			        $pdo->exec("UPDATE uni_settings SET value='".$_POST['project_name']."' WHERE name='mailer_from_name'");
			        $pdo->exec("UPDATE uni_settings SET value='".$_SESSION["license"]."' WHERE name='license_key'");
			        
			        if($prefix_path){
			        	$_SESSION["dashboard_link"] = "https://".$_SERVER["SERVER_NAME"]."/".$prefix_path."/".$dashboard_alias."/access-key/".$access_key;
			    	}else{
			    		$_SESSION["dashboard_link"] = "https://".$_SERVER["SERVER_NAME"]."/".$dashboard_alias."/access-key/".$access_key;
			    	}

			        unlink($BASE_PATH."/test.txt");
			        unlink($BASE_PATH."/dist.zip");

		  			file_put_contents($BASE_PATH."/.htaccess", '
		  				AddDefaultCharset UTF-8
						Options -Indexes

						<FilesMatch ".(htaccess)$">
						 Order Allow,Deny
						 Deny from all
						</FilesMatch>

						RewriteEngine On
						RewriteCond %{REQUEST_FILENAME} !-d
						RewriteCond %{REQUEST_FILENAME} !-f

						RewriteRule ^ index.php [L]
		  			');

			        echo json_encode(["status" => true]);

				} catch (Exception $e) {
				    echo json_encode(["status" => false, "answer" => $e->getMessage()]);
				}
			}

	  }else{
	  	  echo json_encode(["status" => false, "answer" => "Заполните все поля"]);
	  }

	  exit;

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="image/png" rel="shortcut icon" href="https://unisite.org/storage/images/unisite_emblem_200px.png">

    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet" type="text/css"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style type="text/css">
    	body{
    		font-family: "Open Sans";
		    background: #f2f3f8;
		    font-size: 15px;
    	}
    	.main-container{
    		border-radius: 25px;
    		padding: 40px;
    		background-color: white;
    		margin-top: 70px;
    		margin-left: auto;
    		margin-right: auto;
    		max-width: 850px;
    	}
    	.btn-custom{
		    text-align: center;
		    padding-left: 25px;
		    padding-right: 25px;
		    padding-top: 15px;
		    padding-bottom: 15px;
		    text-align: center;
		    cursor: pointer;
		    border-radius: 15px;
		    border: none;
		    outline: none;
		    background-color: #186aff;
		    color: white;
		    text-decoration: none;
		    cursor: pointer;   	
		    display: inline-block;	
    	}
    	.btn-custom:active{
		    transform: scale(0.98); 
		}
		.btn-custom:hover {
		    color: white;
		}
		.btn-custom span {
		    font-size: 12px;
		    width: 15px;
		    height: 15px;
		}
		.btn-custom:hover {
		    color: white;
		}
		.btn-disabled {
		  background-color: gray;
		  cursor: not-allowed;
		}
		.progress-wizard{
			display: inline-flex;
			text-align: center;
			justify-content: center;
			margin-bottom: 30px;
		}
		.progress-wizard span{
			display: inline-flex;
			background-color: #f2f3f8;
			text-align: center;
			justify-content: center;
			border-radius: 50%;
			width: 40px;
			height: 40px;
			color: black;
			font-size: 17px;
			align-items: center;
			font-weight: 200;
			margin-bottom: 5px;
		}
		.progress-wizard span.active{
			background-color: #186aff;
			color: white;
		}
		.progress-wizard > a{
			width: 130px;
		}
		.input-custom{
		    border: 1px solid #f7f8fa;
		    padding: 0 15px;
		    border-radius: 15px;
		    background-color: #f7f8fa;
		    height: 55px;
		    font-size: 15px;
		}
		.input-custom:focus {
		    border-color: blue;
		    border-width: 1px;
		    box-shadow: none;
		}
		ul{
			padding: 0;
			margin: 0;
			list-style: none;
		}
		li:not(:last-child){
		    margin-bottom: 10px;
		}
		.info-text-success{
			padding: 20px;
			border-radius: 15px;
			color: black;
			background-color: #eaffea;
			margin-bottom: 15px;
		}
		.info-text-gray{
			padding: 20px;
			border-radius: 15px;
			color: black;
			background-color: #f2f3f8;
			margin-bottom: 15px;
		}
		.param-install{
			color: green;
		}
		.param-no-install{
			color: red;
		}
    </style>

	<title>UniSite CMS 5</title>
</head>
<body>

	<div class="main-container" >

		<?php if(!$_GET["step"]){ ?>
		
		<h2 style="margin-top: 0px; margin-bottom: 10px;" > <strong>Добро пожаловать в UniSite CMS 5</strong> </h2>
		<p style="margin-top: 0px;" >Тут начинается ваш великий проект!❤️</p>

		<div style="margin-top: 35px;">
			<a href="<?php echo $SCRIPT_NAME; ?>?step=2" class="btn-custom" >Начать установку</a>
		</div>

		<?php } ?>

		<?php if($_GET["step"] == 1){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span class="active" >1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a>
				<span>2</span>
				<div>Проверка параметров</div>
			</a>
			<a>
				<span>3</span>
				<div>Скачивание и установка</div>
			</a>
			<a>
				<span>4</span>
				<div>Настройка БД</div>
			</a>	
			<a>
				<span>5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>
			<input type="text" name="license" class="input-custom form-control" placeholder="Укажите ключ лицензии для текущего домена" value="<?php if($_SESSION["license"]){ echo $_SESSION["license"]; } ?>" >
		</div>
  
		<div style="margin-top: 25px;">
			<span class="btn-custom actionCheckLicense" >Продолжить</span>
		</div>

		<div class="info-text-gray" style="margin-top: 25px; margin-bottom: 0px;" >
			<div> <strong>Нет ключа лицензии?</strong> </div>
			Вы можете приобрести лицензию на официальном сайте компании <a href="https://unisite.org" target="_blank" >UniSite CMS</a>
		</div>

		<script type="text/javascript">

		   $(document).on('click','.actionCheckLicense', function () {

			  $('.actionCheckLicense').html('<span class="spinner-border me-1" role="status" aria-hidden="true"></span>'+$('.actionCheckLicense').html());
			  $('.actionCheckLicense').prop('disabled', true);
		      
		      if($("input[name=license]").val()){
			  $.ajax({type: "POST",url: "<?php echo $SCRIPT_NAME; ?>",data: {action: 'check_license',  license: $("input[name=license]").val()},dataType: "json",cache: false,
				  success: function (data) {

					if(data["status"]){
						if(data["update"] == true){
							location.href = "<?php echo $SCRIPT_NAME; ?>?step=7";
						}else{
							location.href = "<?php echo $SCRIPT_NAME; ?>?step=2";
						}
					}else{
						alert(data["answer"]);
						$('.actionCheckLicense').prop('disabled', false);
						$('.actionCheckLicense').find('span.spinner-border').remove();
					}
			                                    
			      }
		      });
			  }else{
			  	 alert('Укажите ключ лицензии');
				 $('.actionCheckLicense').prop('disabled', false);
				 $('.actionCheckLicense').find('span.spinner-border').remove();
			  }
   
		   });

		</script>

		<?php } ?>

		<?php if($_GET["step"] == 2){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span>1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a>
				<span class="active" >2</span>
				<div>Проверка параметров</div>
			</a>
			<a>
				<span>3</span>
				<div>Скачивание и установка</div>
			</a>
			<a>
				<span>4</span>
				<div>Настройка БД</div>
			</a>	
			<a>
				<span>5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>

			<div class="info-text-success" >Список модулей и параметров которые обязательно должны быть настроены на вашем сервере.</div>

			<ul>
				<li>
					<strong>Текущая версия PHP <?php echo phpversion(); ?></strong>
					<?php if(strpos(phpversion(), "8.3") !== false || strpos(phpversion(), "8.4") !== false){ ?>
					<div class="param-install" >Необходимая версия PHP 8.3 или 8.4 с модулем Apache или FastCGI.</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Необходимая версия PHP 8.3 или 8.4 с модулем Apache или FastCGI.</div>
					<?php } ?>
				</li>
				<li>
					<strong>Права на запись в директорию</strong>
					<?php if(file_put_contents(__dir__.'/test.txt', "true")){ ?>
					<div class="param-install" >Все хорошо</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Нет прав. Установите права 777 на директорию <?php echo __dir__; ?></div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль PDO</strong>
					<?php if(extension_loaded('PDO')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>ionCube Loader</strong>
					<?php if(extension_loaded('ionCube Loader')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль ZIP</strong>
					<?php if(extension_loaded('zip')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль imagick</strong>
					<?php if(extension_loaded('imagick')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль GD</strong>
					<?php if(extension_loaded('gd')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль openssl</strong>
					<?php if(extension_loaded('openssl')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль mbstring</strong>
					<?php if(extension_loaded('mbstring')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Модуль curl</strong>
					<?php if(extension_loaded('curl')){ ?>
					<div class="param-install" >Установлен</div>
					<?php }else{ $BLOCK_NEXT = true; ?>
					<div class="param-no-install" >Не установлен</div>
					<?php } ?>
				</li>
				<li>
					<strong>Параметр memory_limit</strong>
					<div>Выделенная память, должно быть от 512 мб, меняется на сервере в настройках PHP</div>
				</li>
				<li>
					<strong>Параметр max_execution_time</strong>
					<div>Время выполнения скрипта, должно быть от 300 секунд, меняется на сервере в настройках PHP</div>
				</li>
				<li>
					<strong>Параметр post_max_size</strong>
					<div>Размер загружаемых файлов, должно быть от 256 мб, меняется на сервере в настройках PHP</div>
				</li>
				<li>
					<strong>Параметр upload_max_filesize</strong>
					<div>Размер загружаемых файлов, должно быть от 256 мб, меняется на сервере в настройках PHP</div>
				</li>																												
			</ul>

			<div class="info-text-gray" style="margin-top: 25px" >
				<div> <strong>Какой нужен хостинг или сервер?</strong> </div>
				Обычные хостинги очень ограничены в ресурсах и настройках, поэтому рекомендуем выбрать VPS или VDS, хотябы с базовыми параметрами. Рекомендуем: от 2гб оперативной памяти, процессор 2 ядра, SSD от 15гб, ОС Ubuntu + FastPanel или Ispmanager
			</div>

			<div class="info-text-gray" >
				<div> <strong>Какой хостинг рекомендуете?</strong> </div>
				Мы рекомендуем и используем облачные серверы у компании <a href="https://timeweb.cloud/r/co31703" target="_blank" >TimeWeb Cloud</a>
			</div>

		</div>
  		
  		<?php if(!$BLOCK_NEXT){ ?>
		<div style="margin-top: 25px;" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=3" class="btn-custom" >Продолжить</a>
		</div>
		<?php }else{ ?>
		<div style="margin-top: 25px;" >
			<a href="#" class="btn-custom btn-disabled" >Продолжить</a>
		</div>
		<?php } ?>

		<?php } ?>

		<?php if($_GET["step"] == 3){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span>1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=2" >
				<span>2</span>
				<div>Проверка параметров</div>
			</a>
			<a>
				<span class="active" >3</span>
				<div>Скачивание и установка</div>
			</a>
			<a>
				<span>4</span>
				<div>Настройка БД</div>
			</a>	
			<a>
				<span>5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>

			<?php if(!file_exists($BASE_PATH . '/index.php')){ ?>
			<div class="info-text-success" >Скачивание и установка системы. Это может занять некоторое время</div>
			<div class="progress" style="margin-bottom: 25px;" >
			  <div class="progress-bar progress-bar-striped progress-bar-animated download-progress-status" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
			</div>
			<?php }else{ ?>

			<div class="info-text-gray" style="margin-bottom: 0;" >Директория установки должна быть пустая и не содержать файла index.php</div>

			<?php } ?>

		</div>
  		
  		
		<script type="text/javascript">

		<?php if(!file_exists($BASE_PATH . '/index.php')){ ?>

			<?php if(!file_exists($BASE_PATH . '/dist.zip')){ ?>

			var blob;
			let xhr = new XMLHttpRequest();

			xhr.open('GET', 'https://uni-api.com.ru/api.php?action=download_dist&license=<?php echo $_SESSION["license"]; ?>&domain=<?php echo $_SERVER["SERVER_NAME"]; ?>');
			xhr.responseType = "blob";
			xhr.send();

			xhr.onload = function() {
			   blob = new Blob([xhr.response], {type: "application/octetstream"});
			};

			xhr.onprogress = function(event) {
			  
			  let percentage = (event.loaded / event.total) * 100;
			  $(".download-progress-status").css("width",percentage+"%");

			};

		    xhr.onloadend = function(e){

			    $(".download-progress-status").css("width","0%");

			    var loaded = 0;
			    var max_chunk_size = 5000000;
			    var reader = new FileReader();
			    var blob2 = blob.slice(loaded, max_chunk_size);

			    reader.readAsArrayBuffer(blob2);
			    reader.onload = function(e) {

			      var fd = new FormData();

			      fd.append('dist', new File([reader.result], 'filechunk'));
			      fd.append('action', "save_dist");

			      $.ajax("<?php echo $SCRIPT_NAME; ?>", {
			        type: "POST",
			        contentType: false,
			        data: fd,
			        processData: false
			      }).done(function() {

				        loaded += max_chunk_size;

						let percentage = (loaded / blob.size) * 100;
						$(".download-progress-status").css("width",percentage+"%");

				        if (loaded < blob.size) {

				          blob2 = blob.slice(loaded, loaded + max_chunk_size);
				          reader.readAsArrayBuffer(blob2);

				        }else{

							  $.ajax({type: "POST",url: "<?php echo $SCRIPT_NAME; ?>",data: {action: "extract_dist"},dataType: "json",cache: false,success: function (data) {

								  	if(data["status"]){
								  		location.href = "<?php echo $SCRIPT_NAME; ?>?step=4";
								  	}else{
								  		alert(data["answer"]);
								  	}
								  	                        
							  }});

				        }

			      });

			    };

		    }

			xhr.onerror = function() {
			  alert("Что-то пошло не так, обновите страницу");
			};

		<?php }else{ ?>

			  $(".download-progress-status").css("width","50%");

			  $.ajax({type: "POST",url: "<?php echo $SCRIPT_NAME; ?>",data: {action: "extract_dist"},dataType: "json",cache: false,success: function (data) {

				  	if(data["status"]){
				  		$(".download-progress-status").css("width","100%");
				  		location.href = "<?php echo $SCRIPT_NAME; ?>?step=4";
				  	}else{
				  		alert(data["answer"]);
				  	}
				  	                        
			  }});			

		<?php } ?>

		<?php } ?>

		</script>

		<?php } ?>

		<?php if($_GET["step"] == 4){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span>1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=2" >
				<span>2</span>
				<div>Проверка параметров</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=3" >
				<span>3</span>
				<div>Скачивание и установка</div>
			</a>
			<a>
				<span class="active" >4</span>
				<div>Настройка БД</div>
			</a>	
			<a>
				<span>5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>

			<div class="info-text-success" >Необходимо создать базу данных на вашем сервере и указать данные для подключения</div>

			<form class="db-options-form" >
				<div class="row" >
					<div class="col-lg-6" >
						<select name="db_driver" class="input-custom form-control" >
							<option value="mysql" <?php if($_SESSION["db"]){ if($_SESSION["db"]["driver"] == "mysql"){ echo 'selected=""'; } }else{ echo 'selected=""'; } ?> >MySQL</option>
							<option value="postgresql" <?php if($_SESSION["db"]){ if($_SESSION["db"]["driver"] == "postgresql"){ echo 'selected=""'; } } ?> >PostgreSQL</option>
						</select>
					</div>
					<div class="col-lg-6" >
						<input type="text" name="db_host" class="input-custom form-control" placeholder="Хост" value="<?php if($_SESSION["db"]){ echo $_SESSION["db"]["host"]; }else{ echo "localhost"; } ?>" style="margin-bottom: 10px;" >
					</div>
					<div class="col-lg-6" >
						<input type="text" name="db_port" class="input-custom form-control" placeholder="Порт" value="<?php if($_SESSION["db"]){ echo $_SESSION["db"]["port"]; } ?>" style="margin-bottom: 10px;" >
					</div>					
					<div class="col-lg-6" >
						<input type="text" name="db_name" class="input-custom form-control" placeholder="Название БД" value="<?php if($_SESSION["db"]){ echo $_SESSION["db"]["name"]; } ?>" style="margin-bottom: 10px;" >
					</div>
					<div class="col-lg-6" >
						<input type="text" name="db_user" class="input-custom form-control" placeholder="Имя пользователя" value="<?php if($_SESSION["db"]){ echo $_SESSION["db"]["user"]; } ?>" style="margin-bottom: 10px;" >
					</div>
					<div class="col-lg-6" >
						<input type="text" name="db_pass" class="input-custom form-control" placeholder="Пароль" value="<?php if($_SESSION["db"]){ echo $_SESSION["db"]["pass"]; } ?>" style="margin-bottom: 10px;" >
					</div>					
				</div>
			</form>

		</div>
  
		<div style="margin-top: 25px;" >
			<span class="btn-custom actionCheckConnectDb" >Продолжить</span>
		</div>

		<script type="text/javascript">

		   $(document).on('click','.actionCheckConnectDb', function () {
		      
			  $('.actionCheckConnectDb').html('<span class="spinner-border me-1" role="status" aria-hidden="true"></span>'+$('.actionCheckConnectDb').html());
			  $('.actionCheckConnectDb').prop('disabled', true);

			  $.ajax({type: "POST",url: "<?php echo $SCRIPT_NAME; ?>",data: $(".db-options-form").serialize()+"&action=check_connect_db",dataType: "json",cache: false,
				  success: function (data) {

					if(data["status"]){
						location.href = "<?php echo $SCRIPT_NAME; ?>?step=5";
					}else{
						alert(data["answer"]);
						$('.actionCheckConnectDb').prop('disabled', false);
						$('.actionCheckConnectDb').find('span.spinner-border').remove();
					}
			                                    
			      }
		      });
   
		   });

		</script>

		<?php } ?>

		<?php if($_GET["step"] == 5){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span>1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=2" >
				<span>2</span>
				<div>Проверка параметров</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=3" >
				<span>3</span>
				<div>Скачивание и установка</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=4" >
				<span>4</span>
				<div>Настройка БД</div>
			</a>	
			<a>
				<span class="active" >5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>

			<div class="info-text-success" >Осталось совсем чуть-чуть, укажите название проекта и данные для входа в админ панель</div>

			<form class="finish-options-form" >
				<div class="row" >
					<div class="col-lg-6" >
						<input type="text" name="project_name" class="input-custom form-control" placeholder="Название проекта. Например: SuperBoard" value="" style="margin-bottom: 10px;" >
					</div>					
					<div class="col-lg-6" >
						<input type="text" name="user_name" class="input-custom form-control" placeholder="Ваше имя" value="" style="margin-bottom: 10px;" >
					</div>
					<div class="col-lg-6" >
						<input type="text" name="user_email" class="input-custom form-control" placeholder="Email" value="" style="margin-bottom: 10px;" >
					</div>
					<div class="col-lg-6" >
						<input type="text" name="user_pass" class="input-custom form-control" placeholder="Пароль" value="" style="margin-bottom: 10px;" >
					</div>					
				</div>
			</form>

		</div>
  
		<div style="margin-top: 25px;" >
			<span class="btn-custom actionFinish" >Продолжить</span>
		</div>

		<script type="text/javascript">

		   $(document).on('click','.actionFinish', function () {
		      
			  $('.actionFinish').html('<span class="spinner-border me-1" role="status" aria-hidden="true"></span>'+$('.actionFinish').html());
			  $('.actionFinish').prop('disabled', true);

			  $.ajax({type: "POST",url: "<?php echo $SCRIPT_NAME; ?>",data: $(".finish-options-form").serialize()+"&action=finish",dataType: "json",cache: false,
				  success: function (data) {

					if(data["status"]){
						location.href = "<?php echo $SCRIPT_NAME; ?>?step=6";
					}else{
						alert(data["answer"]);
						$('.actionFinish').prop('disabled', false);
						$('.actionFinish').find('span.spinner-border').remove();
					}
			                                    
			      }
		      });
   
		   });

		</script>

		<?php } ?>

		<?php if($_GET["step"] == 6){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span class="active" >1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=2" >
				<span class="active" >2</span>
				<div>Проверка параметров</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=3" >
				<span class="active" >3</span>
				<div>Скачивание и установка</div>
			</a>
			<a href="<?php echo $SCRIPT_NAME; ?>?step=4" >
				<span class="active" >4</span>
				<div>Настройка БД</div>
			</a>	
			<a href="<?php echo $SCRIPT_NAME; ?>?step=4" >
				<span class="active" >5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>

			<div class="info-text-success" >Поздравляем!🔥 Установка проекта успешно завершена! Вы великолепны! 😉🤗</div>

			<div class="info-text-gray" style="margin-bottom: 0" >Ваша универсальная ссылка для входа в панель: <a href="<?php echo $_SESSION["dashboard_link"]; ?>" target="_blank" ><?php echo $_SESSION["dashboard_link"]; ?></a> </div>

		</div>

		<?php } ?>

		<?php if($_GET["step"] == 7){ ?>
		
		<div class="progress-wizard" >
			<a href="<?php echo $SCRIPT_NAME; ?>?step=1" >
				<span class="active" >1</span>
				<div>Проверка лицензиции</div>
			</a>
			<a>
				<span>2</span>
				<div>Проверка параметров</div>
			</a>
			<a>
				<span>3</span>
				<div>Скачивание и установка</div>
			</a>
			<a>
				<span>4</span>
				<div>Настройка БД</div>
			</a>	
			<a>
				<span>5</span>
				<div>Завершение</div>
			</a>					
		</div>

		<div>

			<div class="info-text-success" >Для перехода на новую версию необходимо приобрести обновление, стоимость 10 500 руб. Для каждого ключа лицензии обновление приобретается отдельно!</div>

		</div>

		<?php if($_SESSION["license"]){ ?>
		<div style="margin-top: 35px;" >
			<a href="https://unisite.org/payment/update/<?php echo $_SESSION["license"]; ?>" target="_blank" class="btn-custom" >Оплатить обновление</a>
		</div>
		<?php } ?>

		<?php } ?>

	</div>

	<div style="text-align: center; margin-top: 15px; margin-bottom: 70px;" >
		<a href="https://unisite.org" target="_blank" >UniSite CMS</a>
	</div>

</body>
</html>
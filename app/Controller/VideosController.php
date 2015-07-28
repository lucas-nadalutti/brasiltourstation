<?php

class VideosController extends AppController {

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}

	public function save() {
		if ($this->request->is('post')) {
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(
					__('Vídeo salvo com sucesso'),
					'default',
					array('class' => 'post-success message')
				);
				return $this->redirect(
					array('controller' => 'users', 'action' => 'controlPanel')
				);
			}
			$this->Session->setFlash(
				__('Erro ao salvar vídeo'),
				'default',
				array('class' => 'post-error message')
			);
			unset($this->request->data['Video']['url']);
		}
	}

	public function uploadVideoFile() {
		// XXX: Using default PHP variables because that's how Plupload sends data

		if (empty($_FILES) || $_FILES['file']['error']) {
			die('{"OK": 0, "info": "Failed to move uploaded file."}');
		}
		 
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		 
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
		$filePath = $this->Video->getFilesPath($fileName);
		
		// Create the directory if it doesn't exist
		$dirname = dirname($filePath);
		if (!is_dir($dirname))
		{
		    mkdir($dirname, 0755, true);
		}
		 
		 
		// Open temp file
		$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
		if ($out) {
			// Read binary input stream and append it to temp file
			$in = @fopen($_FILES['file']['tmp_name'], "rb");

			if ($in) {
				while ($buff = fread($in, 4096)) {
					fwrite($out, $buff);
				}
			}
			else {
				die('{"OK": 0, "info": "Failed to open input stream."}' . $filePath);
			}

			@fclose($in);
			@fclose($out);

			@unlink($_FILES['file']['tmp_name']);
		} else
			die('{"OK": 0, "info": "Failed to open input stream."}' . $filePath);
		 
		 
		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename("{$filePath}.part", $filePath);
		}
		 
		die('{"OK": 1, "info": "Upload successful."}');
	}

}
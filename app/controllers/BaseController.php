<?php
use MUMSched\Libraries\CustomValidator;

class BaseController extends Controller
{

	/**
	 * Constructor class
	 */
	public function __construct()
	{
		$data['global_app_version'] = Config::get('app.version');
		View::share($data);		
	}
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Call specific validations
	 *
	 * @return void
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public static function useCustomValidator()
	{
		Validator::resolver(function ($translator, $data, $rules, $messages)
		{
			return new CustomValidator($translator, $data, $rules, $messages);
		});
	}

	/**
	 * Transforms an enloquent object
	 *
	 * @return void
	 */
	public function EloquentToArrayKey($eloquentObjectArray, $key, $value)
	{
		$retorno = array();
		if (count($eloquentObjectArray) > 0) {
			foreach ($eloquentObjectArray as $v) {
				$retorno[$v->$key] = $v->$value;
			}
		}
		return $retorno;
	}

	/**
	 * Execute the validation
	 *
	 * @return void
	 */
	public function executeValidate($input, $rules)
	{
		self::useCustomValidator();
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		}
		return null;
	}
	
	// Upload de imagem
	protected function uploadImage($file, $folder, $size = array(100, 100), $selecao)
	{
		if (Input::hasFile($file)) {
			$file = Input::file($file);
			$extension = $file->getClientOriginalExtension();
			$filename = md5($file->getClientOriginalName()) . '.' . $extension;

			$targ_w = $size[0];
			$targ_h = $size[1];

			$x = round($selecao[0]);
			$y = round($selecao[1]);
			$w = round($selecao[4]);
			$h = round($selecao[5]);

			// se nao enviou tamanhos padrao
			if ($w == 0 && $h == 0) {
				list($width, $height) = getimagesize($file);
				$scale = min($width / $targ_w, $height / $targ_h);
				$w = $targ_w * $scale;
				$h = $targ_h * $scale;
			}

			$opts = new stdClass();
			$opts->folder = $folder;
			$opts->id = $filename;
			$opts->ext = $extension;
			$uploadSuccess = $file->move($folder, $filename);

			$img = Image::make($folder . $filename);

			$src = $img->dirname . '/' . $img->basename;

			$imagem_2x1 = $this->image_crop($src, $opts, $targ_w, $targ_h, $x, $y, $w, $h);

			$img->save($folder . $filename);

			return ($uploadSuccess) ? $imagem_2x1 : '';
		}
		return '';
	}

	public function image_crop($src, $opts, $targ_w, $targ_h, $x, $y, $w, $h)
	{
		$jpeg_quality = 100;

		// dd($targ_w, $targ_h);

		if (preg_match('~\.jpe?g$~si', $src)) {
			$img_r = imagecreatefromjpeg($src);
		} elseif (preg_match('~\.png$~si', $src)) {
			$img_r = imagecreatefrompng($src);
		} elseif (preg_match('~\.gif$~si', $src)) {
			$img_r = imagecreatefromgif($src);
		} else {
			return FALSE;
		}
		$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

		imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);

		if (isset($opts->id) && isset($opts->folder)) {
			$ds = DIRECTORY_SEPARATOR;
			$name = "{$opts->id}_{$targ_w}x{$targ_h}.{$opts->ext}";
			$location = "{$opts->folder}{$name}";
			if (imagejpeg($dst_r, $location, $jpeg_quality)) {
				return "{$opts->folder}{$name}";
			}
		}
		return FALSE;
	}
	
	public function error404() {
		return View::make('errors/404');
	}

	public function error500() {
		return View::make('errors/500');
	}
	
}
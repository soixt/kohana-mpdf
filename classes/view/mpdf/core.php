<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Render a view as a PDF.
 *
 * @packge     Kohana-mPDF
 * @author     Woody Gilk <woody.gilk@kohanaphp.com>
 * @author     Sergei Gladkovskiy <smgladkovskiy@gmail.com>
 * @copyright  (c) 2009 Woody Gilk
 * @license    MIT
 */
abstract class View_mPDF_Core extends View {

	public static function factory($file = NULL, array $data = NULL)
	{
		return new View_MPDF($file, $data);
	}

	public function render($file = NULL)
	{
		return $this->output_mpdf($this->get_mpdf($file));
	}

	public function download($generated_filename, $view_file = NULL)
	{
		$this->output_mpdf($this->get_mpdf($view_file), $generated_filename, 'D');
	}

	public function inline($generated_filename, $view_file = NULL)
	{
		$this->output_mpdf($this->get_mpdf($view_file), $generated_filename, 'I');

		// Necessary to prevent Kohana from overriding the content-type set inside the previous function - we
		// explictly set it to the correct type here...
		Request::current()->headers[] = 'Content-type: application/pdf';
	}

	private function get_mpdf($view_file)
	{
		// Render the HTML normally
		$html = parent::render($view_file);

		$error_level = error_reporting();
		error_reporting($error_level ^ E_NOTICE);

		// Render the HTML to a PDF
		$mpdf = new mPDF('UTF-8', 'A4');
		$mpdf->WriteHTML($html);

		error_reporting($error_level);

		return $mpdf;
	}

	private function output_mpdf($mpdf, $name = NULL, $dest = NULL)
	{
		$error_level = error_reporting();
		error_reporting($error_level ^ E_NOTICE);

		$output = $mpdf->output($name, $dest);

		error_reporting($error_level);

		return $output;
	}

} // End View_MPDF
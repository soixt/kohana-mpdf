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
		return $this->get_mpdf($file)->output();
	}

	public function download($generated_filename, $view_file = NULL)
	{
		$mpdf = $this->get_mpdf($view_file);
		$mpdf->output($generated_filename, 'D');
	}

	private function get_mpdf($view_file)
	{
		// Render the HTML normally
		$html = parent::render($view_file);

		// Render the HTML to a PDF
		$mpdf = new mPDF('UTF-8', 'A4');

		$mpdf->WriteHTML($html);

		return $mpdf;
	}

} // End View_MPDF
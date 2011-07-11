<?php
/**
 * @package sample
 * @version 0.4.0.0
 * @author Roman Konertz
 * @copyright (c) 2008-2011 by Roman Konertz
 * @license GPLv3
 * 
 * This file is part of Open-LIMS
 * Available at http://www.open-lims.org
 * 
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * version 3 of the License.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 
 */
require_once("report/sample_pdf.class.php");

/**
 * Sample Report IO Class
 * @package sample
 */
class SampleReportIO
{
	public static function get_full_report()
	{
		if (class_exists("TCPDF"))
		{
			if ($_GET[sample_id])
			{
				$sample_id = $_GET[sample_id];
				$sample = new Sample($sample_id);
				$owner = new User($sample->get_owner_id());
				$owner_name = str_replace("&nbsp;"," ", $owner->get_full_name(false));
				
				$pdf = new SamplePDF($sample_id, $sample->get_name(), PDF_PAGE_ORIENTATION, PDF_UNIT, "A4", true, 'UTF-8', false);
	
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Open-LIMS');
				$pdf->SetTitle('Sample Report');
				
				$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
				
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				
				$pdf->setLanguageArray($l);
				
				$pdf->setFontSubsetting(true);
				
				$pdf->SetFont('dejavusans', '', 14, '', true);
				
				$pdf->AddPage();
				
				$print_sample_id = "S".str_pad($sample_id, 8 ,'0', STR_PAD_LEFT);
				
				$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0, 0, 0);
				
				$pdf->MultiCell(90, 0, "ID", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(90, 0, $print_sample_id, 1, '', 1, 1, '', '', true, 0, false, true, 0);
				
				$pdf->MultiCell(90, 0, "Name", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(90, 0, $sample->get_name(), 1, '', 1, 1, '', '', true, 0, false, true, 0);
				
				$pdf->MultiCell(90, 0, "Type/Template", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(90, 0, $sample->get_template_name(), 1, '', 1, 1, '', '', true, 0, false, true, 0);
				
				$pdf->MultiCell(90, 0, "Owner", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
				$pdf->MultiCell(90, 0, $owner_name, 1, '', 1, 1, '', '', true, 0, false, true, 0);
				
				$pdf->MultiCell(90, 0, "Status", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
				if ($sample->get_availability() == true)
				{
					$pdf->MultiCell(90, 0, "available", 1, '', 1, 1, '', '', true, 0, false, true, 0);
				}
				else
				{
					$pdf->MultiCell(90, 0, "not available", 1, '', 1, 1, '', '', true, 0, false, true, 0);
				}
				
				$pdf->MultiCell(90, 0, "Date/Time", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
				$datetime = new DatetimeHandler($sample->get_datetime());
				$pdf->MultiCell(90, 0, $datetime->get_formatted_string("dS M Y H:i"), 1, '', 1, 1, '', '', true, 0, false, true, 0);
				
				if ($sample->get_manufacturer_id())
				{
					$manufacturer = new Manufacturer($sample->get_manufacturer_id());
					
					$pdf->MultiCell(90, 0, "Manufacturer", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
					$pdf->MultiCell(90, 0, $manufacturer->get_name(), 1, '', 1, 1, '', '', true, 0, false, true, 0);
				}
				
				if ($sample->get_date_of_expiry())
				{
					$pdf->MultiCell(90, 0, "Date of Expiry", 1, 'L', 1, 0, '', '', true, 0, false, true, 0);
					$date_of_expiry = new DatetimeHandler($sample->get_date_of_expiry());
					$pdf->MultiCell(90, 0, $date_of_expiry->get_formatted_string("dS M Y"), 1, '', 1, 1, '', '', true, 0, false, true, 0);
				}
				
				$module_dialog_array = ModuleDialog::list_dialogs_by_type("item_report");
				
				if (is_array($module_dialog_array))
				{
					$pdf->AddPage();
				}
				else
				{
					
				}
				
				return $pdf;
			}
			else
			{
				// Error
			}
		}
		else
		{
			// Error
		}
	}
	
	public static function get_barcode_report()
	{
		
	}
}
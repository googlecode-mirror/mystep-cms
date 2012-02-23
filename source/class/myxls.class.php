<?php
/********************************************
*                                           *
* Name    : Excel Builder                   *
* Author  : Windy2000                        *
* Time    : 2004-08-08                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT PLEASE HOLD THIS ITEM.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$xls->init($file_name, $sheet_name)								// Set the Database Class
	$xls->addSheet($sheet_name, $change_sheet)				// add new sheet
	$xls->delSheet($sheet_name)												// delete sheet
	$xls->resetSheet($sheet_name, $change_sheet)			// empty sheet data
	$xls->chgSheet($sheet_name)												// change working sheet
	$xls->addRow()																		// add a new working row to working sheet
	$xls->addCells($cells, $idx)											// add data to working row
	$xls->getContent()																// get xls file content
	$xls->makeFile()																	// push content to browser

--------------------------------------------------------------------------------------------------------------------*/

class MyXls extends class_common {
	public
		$xls_workSheet = array(),
		$cur_workSheet = "",
		$xls_name = "";
		
	public function init($file_name="", $sheet_name="") {
		if(empty($file_name)) $file_name = "export";
		if(empty($sheet_name)) $sheet_name = "sheet1";
		$this->xls_workSheet = array();
		$this->addSheet($sheet_name);
		$this->cur_workSheet = $sheet_name;
		$this->xls_name = $file_name;
	}

	public function addSheet($sheet_name="", $change_sheet=true) {
		if(!isset($this->xls_workSheet[$sheet_name])) {
			if(empty($sheet_name)) {
				$i = 1;
				while(isset($this->xls_workSheet['sheet'.$i])) {
					$i++;
				}
				$sheet_name = 'sheet'.$i;
			}
			$this->xls_workSheet[$sheet_name] = array();
			if($change_sheet) $this->chgSheet($sheet_name);
		}
	}

	public function delSheet($sheet_name) {
		if(isset($this->xls_workSheet[$sheet_name])) {
			unset($this->xls_workSheet[$sheet_name]);
			$this->cur_workSheet = "";
			foreach($this->xls_workSheet as $key => $value) {
				$this->chgSheet($key);
				break;
			}
		}
	}

	public function resetSheet($sheet_name, $change_sheet=true) {
		if(isset($this->xls_workSheet[$sheet_name])) {
			$this->xls_workSheet[$sheet_name] = array();
			if($change_sheet) $this->chgSheet($sheet_name);
		}
	}

	public function chgSheet($sheet_name) {
		if(isset($this->xls_workSheet[$sheet_name])) $this->cur_workSheet = $sheet_name;
	}

	public function addRow() {
		if(empty($this->cur_workSheet) || !isset($this->xls_workSheet[$this->cur_workSheet])) return;
		array_push($this->xls_workSheet[$this->cur_workSheet], array());
	}

	public function addCells($cells, $idx="") {
		if(empty($this->cur_workSheet) || !isset($this->xls_workSheet[$this->cur_workSheet])) return;
		if(empty($idx) || !isset($this->xls_workSheet[$this->cur_workSheet][$idx])) $idx = count($this->xls_workSheet[$this->cur_workSheet])-1;
		if(is_array($cells)) {
			$cells_new = array();
			foreach($cells as $value) {
				array_push($cells_new, $value);
			}
			$this->xls_workSheet[$this->cur_workSheet][$idx] = array_merge($this->xls_workSheet[$this->cur_workSheet][$idx], $cells_new);
		} else {
			array_push($this->xls_workSheet[$this->cur_workSheet][$idx], $cells);
		}
	}

	public function getContent() {
		$now = date("Y-m-d")."T".date("H:i:s")."Z";
		$content = "";
		$content .= <<<CODE
<?xml version="1.0" encoding="gb2312"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Windy2000</Author>
  <LastAuthor>windy2006@gmail.com</LastAuthor>
  <Created>{$now}</Created>
  <Company>Homebrew</Company>
  <Version>11.5606</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>9000</WindowHeight>
  <WindowWidth>11700</WindowWidth>
  <WindowTopX>240</WindowTopX>
  <WindowTopY>15</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Times New Roman" x:CharSet="134" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
 </Styles>
CODE;
		foreach($this->xls_workSheet as $key => $value){
			$count_rows = count($value);
			if($count_rows<=0) continue;
			$count_cells = 0;
			for($i=0;$i<$count_rows;$i++) {
				if(count($value[$i])>$count_cells) $count_cells = count($value[$i]);
			}
			$content .= <<<CODE

 <Worksheet ss:Name="{$key}">
  <Table ss:ExpandedColumnCount="{$count_cells}" ss:ExpandedRowCount="{$count_rows}" x:FullColumns="1"
   x:FullRows="1" ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25">

CODE;
			for($i=0; $i<$count_rows; $i++) {
				$content .= "   <Row>\r\n";
				$max_count = count($value[$i]);
				for($j=0; $j<$max_count; $j++) {
					$value[$i][$j] = htmlspecialchars($value[$i][$j]);
					$value[$i][$j] = str_replace("\r", "", $value[$i][$j]);
					$value[$i][$j] = str_replace("\n", "&#10;", $value[$i][$j]);
					$content .= '    <Cell><Data ss:Type="String">'.$value[$i][$j].' </Data></Cell>'.chr(13).chr(10);
				}
				$content .= "   </Row>\r\n";
			}
			$content .= <<<CODE
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>

CODE;
		}
		$content .= "</Workbook>";
		return $content;
	}

	public function makeFile() {
		$content = $this->getContent();
		header("Content-type: application/vnd.ms-excel; charset=gbk");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".strlen($content));
		header("Content-Disposition: attachment; filename={$this->xls_name}.xls");
		echo $content;
		exit();
	}
}
?>
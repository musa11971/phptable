<?php

/*

		phptable

	author:			https://github.com/musa11971
	github:			https://github.com/musa11971/phptable
	wiki:			https://github.com/musa11971/phptable/wiki
	version:		1.0
	last update:	july 20th 2017

*/

class PHPTable {
	private $id;
	private $data = null;
	private $classes = [];
	private $headings = [];
	private $caption = '';
	private $columnsBefore = [];
	private $columnsAfter = [];

	/////////////////////////////////////////////////

	// Constructor
	public function __construct($tableID = null) {
		if($tableID == null) $tableID = 'phptable-' . rand(1, 9999);

		$this->id = $tableID;
		$this->data = [];
	}

	/////////////////////////////////////////////////

	// Get the total count of columns in this table
	private function totalColumnCount() {
		$dataCount = 0;

		if($this->data != null) {
			foreach($this->data[0] as $singleData) {
				$dataCount++;
			}
		}
		
		return 
		(
			count($this->columnsBefore) +
			count($this->columnsAfter) +
			$dataCount
		);
	}

	/////////////////////////////////////////////////

	// Get the classes bound to this table
	public function getClasses() {
		return $this->classes;
	}

	// Add a class to the table
	public function addClass($className) {
		array_push($this->classes, $className);
	}

	/////////////////////////////////////////////////

	// Set the headings for this table
	public function setHeadings($headingsArray) {
		$this->headings = $headingsArray;
	}

	// Get the headings for this table
	public function getHeadings() {
		return $this->headings;
	}

	/////////////////////////////////////////////////

	// Bind a data array to the table
	public function bindData($dataArray) {
		$this->data = $dataArray;
	}

	// Check if table has data
	public function hasData() {
		return (count($this->data)) ? true : false;
	}

	/////////////////////////////////////////////////

	// Set the caption for the table
	public function setCaption($newCap) {
		$this->caption = $newCap;
	}

	// Get the caption for the table
	public function getCaption() {
		return $this->caption;
	}

	/////////////////////////////////////////////////

	// Add a static column to the table
	public function addColumn($position, $columnContent) {
		switch($position) {
			case 'before': {
				array_push($this->columnsBefore, $columnContent);
				break;
			}
			case 'after': {
				array_push($this->columnsAfter, $columnContent);
				break;
			}
		}
	}

	// Format a static column and replace with appropriate variables
	private function formatStatic($staticStr, $dataPiece) {
		$result = $staticStr;

		preg_match_all('/(\{.*?\})/', $result, $matches);

		foreach($matches as $matchsingle) {
			foreach($matchsingle as $single) {
				$index = str_replace('{', '', $single);
				$index = str_replace('}', '', $index);

				if(is_array($dataPiece)) {
					$result = str_replace($single, $dataPiece[$index], $result);
				}
				else {
					$result = str_replace($single, $dataPiece->$index, $result);
				}
			}
		}

		return $result;
	}

	/////////////////////////////////////////////////

	// Echo the table's HTML
	public function html() {
		// Initiate result table variable
		$resultTable = '';

		// Open table without classes
		if(!count($this->getClasses())) $resultTable .= '<table>';
		else { // Open table with classes and ID
			$resultTable .= '<table id="' . $this->id . '" class="' . implode(' ', $this->getClasses()) . '">';
		}

		// Append caption to table
		if(strlen($this->getCaption())) {
			$resultTable .= '<caption>' . $this->getCaption() . '</caption>';
		}

		// Append headings to table
		if(count($this->getHeadings())) {
			// Open thead
			$resultTable .= '<thead>';

			if(count($this->headings)) {
				// Open row
				$resultTable .= '<tr>';

				$appendedHeadings = 0;

				// Append each heading
				foreach($this->getHeadings() as $singleHeading) {
					// Append single heading
					$resultTable .= '<th>' . $singleHeading . '</th>';

					$appendedHeadings++;
				}


				// Append blank headings if spots are left
				if($appendedHeadings < $this->totalColumnCount()) {
					for($i = $appendedHeadings; $i < $this->totalColumnCount(); $i++) {
						$resultTable .= '<th></th>';
					}
				}

				// Close row
				$resultTable .= '</tr>';
			}

			// Close thead
			$resultTable .= '</thead>';
		}

		// Append data to table
		if($this->hasData()) {
			// Open tbody
			$resultTable .= '<tbody>';

			foreach($this->data as $dataPiece) {
				// Open row
				$resultTable .= '<tr>';

				// Append static before columns
				foreach($this->columnsBefore as $staticCol) {
					$resultTable .= '<td>' . $this->formatStatic($staticCol, $dataPiece) . '</td>';
				}

				// Add data piece items
				foreach($dataPiece as $singleData) {
					$resultTable .= '<td>' . $singleData . '</td>';
				}

				// Append static after columns
				foreach($this->columnsAfter as $staticCol) {
					$resultTable .= '<td>' . $this->formatStatic($staticCol, $dataPiece) . '</td>';
				}

				// Close row
				$resultTable .= '</tr>';
			}

			// Close tbody
			$resultTable .= '</tbody>';
		}

		// Close table
		$resultTable .= '</table>';

		// Return HTML string
		return $resultTable;
	}
}

?>
<?php
/***************************************************************
* Copyright notice
*
* (c) 2008-2009 Oliver Klee <typo3-coding@oliverklee.de>
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class 'tx_oelib_tests_fixtures_TestingModel' for the 'oelib' extension.
 *
 * This class represents a domain model for testing purposes.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
final class tx_oelib_tests_fixtures_TestingModel extends tx_oelib_Model {
	/**
	 * Sets the "title" data item for this model.
	 *
	 * @param string the value to set, may be empty
	 */
	public function setTitle($value) {
		$this->setAsString('title', $value);
	}

	/**
	 * Gets the "title" data item.
	 *
	 * @return string the value of the "title" data item, may be empty
	 */
	public function getTitle() {
		return $this->getAsString('title');
	}

	/**
	 * Checks whether a data item with a certain key exists.
	 *
	 * @param string the key of the data item to check, must not be empty
	 *
	 * @return boolean true if a data item with the key $key exists, false
	 *                 otherwise
	 */
	public function existsKey($key) {
		return parent::existsKey($key);
	}

	/**
	 * Gets the value stored in under the key $key as a model.
	 *
	 * @throws Exception if there is a data item stored for the key $key that
	 *                   is not a model instance
	 *
	 * @param string the key of the element to retrieve, must not be empty
	 *
	 * @return tx_oelib_Model the data item for the given key, will be null if
	 *                        it has not been set
	 */
	public function getAsModel($key) {
		return parent::getAsModel($key);
	}
}
?>
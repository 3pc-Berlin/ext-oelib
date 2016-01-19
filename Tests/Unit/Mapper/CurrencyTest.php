<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Tests_Unit_Mapper_CurrencyTest extends Tx_Phpunit_TestCase {
	/**
	 * @var Tx_Oelib_Mapper_Currency
	 */
	private $subject;

	protected function setUp() {
		$this->subject = new Tx_Oelib_Mapper_Currency();
	}

	///////////////////////////
	// Tests concerning find.
	///////////////////////////

	/**
	 * @test
	 */
	public function findWithUidOfExistingRecordReturnsCurrencyInstance() {
		self::assertTrue(
			$this->subject->find(49) instanceof Tx_Oelib_Model_Currency
		);
	}


	/////////////////////////////////////////
	// Tests regarding findByIsoAlpha3Code.
	/////////////////////////////////////////

	/**
	 * @test
	 */
	public function findByIsoAlpha3CodeWithIsoAlpha3CodeOfExistingRecordReturnsCurrencyInstance() {
		self::assertTrue(
			$this->subject->findByIsoAlpha3Code('EUR')
				instanceof Tx_Oelib_Model_Currency
		);
	}

	/**
	 * @test
	 */
	public function findByIsoAlpha3CodeWithIsoAlpha3CodeOfExistingRecordReturnsRecordAsModel() {
		self::assertSame(
			49,
			$this->subject->findByIsoAlpha3Code('EUR')->getUid()
		);
	}
}
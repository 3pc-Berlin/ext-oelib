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
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Tests_Unit_ModelTest extends Tx_Phpunit_TestCase {
	/**
	 * @var Tx_Oelib_Tests_Unit_Fixtures_TestingModel
	 */
	private $subject = NULL;

	protected function setUp() {
		$this->subject = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
	}

	/**
	 * Loading function stub.
	 *
	 * @param Tx_Oelib_Model $model
	 *
	 * @return void
	 */
	public function load(Tx_Oelib_Model $model) {
	}


	//////////////////////////////////////
	// Tests for the basic functionality
	//////////////////////////////////////

	/**
	 * @test
	 */
	public function destructDoesNotCrashForRelationToSelf() {
		$subject = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$subject->setData(
			array('foo' => $subject)
		);
	}

	/**
	 * @test
	 */
	public function destructDoesNotCrashForTwoModelsInACircle() {
		$subject1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$subject2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();

		$subject1->setData(
			array('foo' => $subject2)
		);
		$subject2->setData(
			array('foo' => $subject1)
		);
	}

	/**
	 * @test
	 */
	public function getWithNoDataThrowsException() {
		$this->setExpectedException(
			'BadMethodCallException',
			get_class($this->subject) . '#' . $this->subject->getUid()
				. ': Please call setData() directly after instantiation first.'
		);

		$this->subject->getTitle();
	}

	/**
	 * @test
	 */
	public function setDataWithEmptyArrayIsAllowed() {
		$this->subject->setData(array());
	}

	/**
	 * @test
	 */
	public function getAfterSetReturnsTheSetValue() {
		$this->subject->setTitle('bar');

		self::assertSame(
			'bar',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getAfterSetDataReturnsTheSetValue() {
		$this->subject->setData(
			array('title' => 'bar')
		);

		self::assertSame(
			'bar',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setDataCalledTwoTimesThrowsAnException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'setData must only be called once per model instance.'
		);

		$this->subject->setData(
			array('title' => 'bar')
		);
		$this->subject->setData(
			array('title' => 'bar')
		);
	}

    /**
     * @test
     */
    public function getAfterResetDataReturnsTheSetValue()
    {
        $this->subject->resetData(['title' => 'bar']);

        self::assertSame('bar', $this->subject->getTitle());
    }

    /**
     * @test
     */
    public function resetDataCanBeCalledTwoTimes()
    {
        $this->subject->resetData(['title' => 'bar']);
        $this->subject->resetData(['title' => 'foobar']);
    }

	/**
	 * @test
	 */
	public function isHiddenForLoadedHiddenObjectReturnsTrue() {
		$this->subject->setData(
			array('hidden' => 1)
		);

		self::assertTrue(
			$this->subject->isHidden()
		);
	}

	/**
	 * @test
	 */
	public function isHiddenForLoadedNonHiddenObjectReturnsFalse() {
		$this->subject->setData(
			array('hidden' => 0)
		);

		self::assertFalse(
			$this->subject->isHidden()
		);
	}


	///////////////////////////////
	// Tests concerning existsKey
	///////////////////////////////

	/**
	 * @test
	 */
	public function existsKeyForInexistentKeyReturnsFalse() {
		$this->subject->setData(array());

		self::assertFalse(
			$this->subject->existsKey('foo')
		);
	}

	/**
	 * @test
	 */
	public function existsKeyForExistingKeyWithNonEmptyDataReturnsTrue() {
		$this->subject->setData(
			array('foo' => 'bar')
		);

		self::assertTrue(
			$this->subject->existsKey('foo')
		);
	}

	/**
	 * @test
	 */
	public function existsKeyForExistingKeyWithEmptyStringDataReturnsTrue() {
		$this->subject->setData(
			array('foo' => '')
		);

		self::assertTrue(
			$this->subject->existsKey('foo')
		);
	}

	/**
	 * @test
	 */
	public function existsKeyForExistingKeyWithZeroDataReturnsTrue() {
		$this->subject->setData(
			array('foo' => 0)
		);

		self::assertTrue(
			$this->subject->existsKey('foo')
		);
	}

	/**
	 * @test
	 */
	public function existsKeyForExistingKeyWithNullDataReturnsTrue() {
		$this->subject->setData(
			array('foo' => NULL)
		);

		self::assertTrue(
			$this->subject->existsKey('foo')
		);
	}


	////////////////////////////////
	// Tests concerning getAsModel
	////////////////////////////////

	/**
	 * @test
	 */
	public function getAsModelWithEmptyKeyThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$key must not be empty.'
		);

		$this->subject->getAsModel('');
	}

	/**
	 * @test
	 */
	public function getAsModelWithInexistentKeyReturnsNull() {
		$this->subject->setData(array());

		self::assertNull(
			$this->subject->getAsModel('foo')
		);
	}

	/**
	 * @test
	 */
	public function getAsModelWithKeyForStringDataThrowsException() {
		$this->setExpectedException(
			'UnexpectedValueException',
			'The data item for the key "foo" is no model instance.'
		);

		$this->subject->setData(array('foo' => 'bar'));

		$this->subject->getAsModel('foo');
	}

	/**
	 * @test
	 */
	public function getAsModelReturnsNullSetViaSetData() {
		$this->subject->setData(
			array('foo' => NULL)
		);

		self::assertNull(
			$this->subject->getAsModel('foo')
		);
	}

	/**
	 * @test
	 */
	public function getAsModelReturnsModelSetViaSetData() {
		$otherModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->subject->setData(
			array('foo' => $otherModel)
		);

		self::assertSame(
			$otherModel,
			$this->subject->getAsModel('foo')
		);
	}

	/**
	 * @test
	 */
	public function getAsModelForSelfReturnsSelf() {
		$this->subject->setData(
			array('foo' => $this->subject)
		);

		self::assertSame(
			$this->subject,
			$this->subject->getAsModel('foo')
		);
	}


	////////////////////////////////
	// Tests concerning getAsList
	////////////////////////////////

	/**
	 * @test
	 */
	public function getAsListWithEmptyKeyThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$key must not be empty.'
		);

		$this->subject->getAsList('');
	}

	/**
	 * @test
	 */
	public function getAsListWithInexistentKeyThrowsException() {
		$this->setExpectedException(
			'UnexpectedValueException',
			'The data item for the key "foo" is no list instance.'
		);

		$this->subject->setData(array());

		self::assertNull(
			$this->subject->getAsList('foo')
		);
	}

	/**
	 * @test
	 */
	public function getAsListWithKeyForStringDataThrowsException() {
		$this->setExpectedException(
			'UnexpectedValueException',
			'The data item for the key "foo" is no list instance.'
		);

		$this->subject->setData(array('foo' => 'bar'));

		$this->subject->getAsList('foo');
	}

	/**
	 * @test
	 */
	public function getAsListReturnsListSetViaSetData() {
		$list = new Tx_Oelib_List();
		$this->subject->setData(
			array('foo' => $list)
		);

		self::assertSame(
			$list,
			$this->subject->getAsList('foo')
		);
	}


	/////////////////////////////
	// Tests concerning the UID
	/////////////////////////////

	/**
	 * @test
	 */
	public function getUidForNoUidReturnsZero() {
		$this->subject->setData(array());

		self::assertSame(
			0,
			$this->subject->getUid()
		);
	}

	/**
	 * @test
	 */
	public function getUidForSetUidReturnsTheSetUid() {
		$this->subject->setUid(42);

		self::assertSame(
			42,
			$this->subject->getUid()
		);
	}

	/**
	 * @test
	 */
	public function getUidForSetUidViaSetDataReturnsTheSetUid() {
		$this->subject->setData(array('uid' => 42));

		self::assertSame(
			42,
			$this->subject->getUid()
		);
	}

	/**
	 * @test
	 */
	public function getUidForSetStringUidViaSetDataReturnsTheSetIntegerUid() {
		$this->subject->setData(array('uid' => '42'));

		self::assertSame(
			42,
			$this->subject->getUid()
		);
	}

	/**
	 * @test
	 */
	public function hasUidForNoUidReturnsFalse() {
		$this->subject->setData(array());

		self::assertFalse(
			$this->subject->hasUid()
		);
	}

	/**
	 * @test
	 */
	public function hasUidForPositiveUidReturnsTrue() {
		$this->subject->setUid(42);

		self::assertTrue(
			$this->subject->hasUid()
		);
	}

	/**
	 * @test
	 */
	public function setUidTwoTimesThrowsAnException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'The UID of a model cannot be set a second time.'
		);
		$this->subject->setUid(42);
		$this->subject->setUid(42);
	}

	/**
	 * @test
	 */
	public function setUidForAModelWithAUidSetViaSetDataThrowsException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'The UID of a model cannot be set a second time.'
		);

		$this->subject->setData(array('uid' => 1));
		$this->subject->setUid(42);
	}

	/**
	 * @test
	 */
	public function setUidForAModelWithoutUidDoesNotFail() {
		$this->subject->setData(array());
		$this->subject->setUid(42);
	}


	//////////////////////////////////////
	// Tests concerning the model states
	//////////////////////////////////////

	/**
	 * @test
	 */
	public function initiallyHasVirginState() {
		self::assertTrue(
			$this->subject->isVirgin()
		);
	}

	/**
	 * @test
	 */
	public function afterSettingDataWithoutUidHasLoadedState() {
		$this->subject->setData(array());

		self::assertTrue(
			$this->subject->isLoaded()
		);
	}

	/**
	 * @test
	 */
	public function afterSettingDataWithUidHasLoadedState() {
		$this->subject->setData(array('uid' => 1));

		self::assertTrue(
			$this->subject->isLoaded()
		);
	}

	/**
	 * @test
	 */
	public function afterSettingDataWithUidNotHasDeadState() {
		$this->subject->setData(array('uid' => 1));

		self::assertFalse(
			$this->subject->isDead()
		);
	}

	/**
	 * @test
	 */
	public function afterSettingUidWithoutDataHasGhostState() {
		$this->subject->setUid(1);

		self::assertTrue(
			$this->subject->isGhost()
		);
	}

	/**
	 * @test
	 */
	public function afterMarkAsDeadHasDeadState() {
		$this->subject->markAsDead();

		self::assertTrue(
			$this->subject->isDead()
		);
	}

	/**
	 * @test
	 */
	public function getOnAModelWithoutLoadCallbackThrowsException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'Ghosts need a load callback function before their data can be accessed.'
		);

		$this->subject->setUid(1);
		$this->subject->getTitle();
	}

	/**
	 * @test
	 */
	public function setOnAModelInStatusGhostWithoutLoadCallbackThrowsException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'Ghosts need a load callback function before their data can be accessed.'
		);

		$this->subject->setUid(1);
		$this->subject->setTitle('foo');
	}

	/**
	 * @test
	 */
	public function getOnDeadModelThrowsException() {
		$this->setExpectedException(
			'tx_oelib_Exception_NotFound',
			'The Tx_Oelib_Tests_Unit_Fixtures_TestingModel with the UID 0' .
				' either has been deleted (or has never existed), but still is accessed.'
		);

		$this->subject->markAsDead();
		$this->subject->getTitle();
	}

	/**
	 * @test
	 */
	public function getUidOnDeadModelDoesNotFail() {
		$this->subject->markAsDead();
		$this->subject->getUid();
	}

	/**
	 * @test
	 */
	public function isHiddenOnDeadModelThrowsException() {
		$this->setExpectedException(
			'tx_oelib_Exception_NotFound',
			'The Tx_Oelib_Tests_Unit_Fixtures_TestingModel with the UID 0' .
				' either has been deleted (or has never existed), but still is accessed.'
		);

		$this->subject->markAsDead();
		$this->subject->isHidden();
	}


	//////////////////////
	// Tests for isEmpty
	//////////////////////

	/**
	 * @test
	 */
	public function isEmptyForLoadedEmptyObjectReturnsTrue() {
		$this->subject->setData(array());

		self::assertTrue(
			$this->subject->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function isEmptyForLoadedNotEmptyObjectReturnsFalse() {
		$this->subject->setData(
			array('foo' => 'bar')
		);

		self::assertFalse(
			$this->subject->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function isEmptyForGhostLoadsModel() {
		$this->subject->setData(array());
		$this->subject->setUid(1);
		$this->subject->setLoadCallback(array($this, 'load'));
		$this->subject->isEmpty();

		self::assertTrue(
			$this->subject->isLoaded()
		);
	}

	/**
	 * @test
	 */
	public function isEmptyForGhostWithLoadedDataReturnsFalse() {
		$this->subject->setData(
			array('foo' => 'bar')
		);
		$this->subject->setUid(1);
		$this->subject->setLoadCallback(array($this, 'load'));

		self::assertFalse(
			$this->subject->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function isEmptyForGhostWithoutLoadedDataReturnsTrue() {
		$this->subject->setUid(1);
		$this->subject->setLoadCallback(array($this, 'load'));

		self::assertTrue(
			$this->subject->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function isEmptyForVirginStateReturnsTrue() {
		self::assertTrue(
			$this->subject->isEmpty()
		);
	}


	//////////////////////
	// Tests for isDirty
	//////////////////////

	/**
	 * @test
	 */
	public function isDirtyAfterMarkAsDirtyReturnsTrue() {
		$this->subject->markAsDirty();

		self::assertTrue(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyAfterMarkAsCleanReturnsFalse() {
		$this->subject->markAsClean();

		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyAfterSetReturnsTrue() {
		$this->subject->setTitle('foo');

		self::assertTrue(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyAfterSetDataWithUidAndOtherDataReturnsFalse() {
		$this->subject->setData(array('uid' => 42, 'title' => 'foo'));

		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyAfterSetDataOnlyWithUidReturnsFalse() {
		$this->subject->setData(array('uid' => 42, 'title' => 'foo'));

		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyAfterSetDataForAModelAlreadyHavingAUidReturnsFalse() {
		$this->subject->setUid(42);
		$this->subject->setData(array('title' => 'foo'));

		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyAfterSetDataWithoutUidReturnsTrue() {
		$this->subject->setData(array('title' => 'foo'));

		self::assertTrue(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyOnModelInVirginStateReturnsFalse() {
		self::assertTrue(
			$this->subject->isVirgin()
		);
		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyOnModelInGhostStateReturnsFalse() {
		$this->subject->setUid(1);

		self::assertTrue(
			$this->subject->isGhost()
		);
		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyOnInitiallyDeadModelReturnsFalse() {
		$this->subject->markAsDead();

		self::assertFalse(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function isDirtyOnModelWhichTurnedIntoDeadStateReturnsFalse() {
		$this->subject->setTitle('foo');

		self::assertTrue(
			$this->subject->isDirty()
		);

		$this->subject->markAsDead();
		self::assertTrue(
			$this->subject->isDead()
		);
		self::assertFalse(
			$this->subject->isDirty()
		);
	}


	//////////////////////////////////////////
	// Tests concerning the deleted property
	//////////////////////////////////////////

	/**
	 * @test
	 */
	public function setToDeletedOnVirginModelMarksModelAsDead() {
		self::assertTrue(
			$this->subject->isVirgin()
		);

		$this->subject->setToDeleted();

		self::assertTrue(
			$this->subject->isDead()
		);
	}

	/**
	 * @test
	 */
	public function setToDeletedOnGhostModelMarksModelAsDead() {
		$this->subject->setUid(1);

		self::assertTrue(
			$this->subject->isGhost()
		);

		$this->subject->setToDeleted();

		self::assertTrue(
			$this->subject->isDead()
		);
	}

	/**
	 * @test
	 */
	public function setToDeletedOnLoadedModelMarksModelAsDirty() {
		$this->subject->setData(array('uid' => 1));

		self::assertTrue(
			$this->subject->isLoaded()
		);

		$this->subject->setToDeleted();

		self::assertTrue(
			$this->subject->isDirty()
		);
	}

	/**
	 * @test
	 */
	public function setToDeletedOnLoadedModelMarksModelAsDeleted() {
		$this->subject->setData(array('uid' => 1));

		self::assertTrue(
			$this->subject->isLoaded()
		);

		$this->subject->setToDeleted();

		self::assertTrue(
			$this->subject->isDeleted()
		);
	}

	/**
	 * @test
	 */
	public function settingDeletedByUsingSetThrowsAnException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$key must not be "deleted". Please use setToDeleted() instead.'
		);

		$this->subject->setDeletedPropertyUsingSet();
	}

	/**
	 * @test
	 */
	public function isDeletedForModelSetToDeletedReturnsTrue() {
		$this->subject->setData(array('uid' => 1));

		$this->subject->setToDeleted();

		self::assertTrue(
			$this->subject->isDeleted()
		);
	}

	/**
	 * @test
	 */
	public function isDeletedForNonDeletedModelReturnsFalse() {
		$this->subject->setData(array('uid' => 1));

		self::assertFalse(
			$this->subject->isDeleted()
		);
	}


	//////////////////////////////////////
	// Tests concerning read-only models
	//////////////////////////////////////

	/**
	 * @test
	 */
	public function isReadOnlyOnReadWriteModelReturnsFalse() {
		self::assertFalse(
			$this->subject->isReadOnly()
		);
	}

	/**
	 * @test
	 */
	public function isReadOnlyOnReadOnlyModelReturnsTrue() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_ReadOnlyModel();

		self::assertTrue(
			$model->isReadOnly()
		);
	}

	/**
	 * @test
	 */
	public function setDataOnReadOnlyModelDoesNotFail() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_ReadOnlyModel();
		$model->setData(array());
	}

	/**
	 * @test
	 */
	public function setOnReadOnlyModelThrowsException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'set() must not be called on a read-only model.'
		);

		$model = new Tx_Oelib_Tests_Unit_Fixtures_ReadOnlyModel();
		$model->setTitle('foo');
	}


	/////////////////////////////
	// Tests concerning getData
	/////////////////////////////

	/**
	 * @test
	 */
	public function getDataForNoDataSetReturnsEmptyArray() {
		self::assertSame(
			array(),
			$this->subject->getData()
		);
	}

	/**
	 * @test
	 */
	public function getDataReturnsArrayWithTheSetData() {
		$data = array('foo' => 'bar');
		$this->subject->setData($data);

		self::assertSame(
			$data,
			$this->subject->getData()
		);
	}

	/**
	 * @test
	 */
	public function getDataReturnsArrayWithoutKeyUid() {
		$this->subject->setData(array('uid' => 1));

		self::assertSame(
			array(),
			$this->subject->getData()
		);
	}


	/////////////////////////////////////////////////////
	// Test concerning setTimestamp and setCreationDate
	/////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function setTimestampForLoadedModelSetsTheTimestamp() {
		$this->subject->setData(array());
		$this->subject->setTimestamp();

		self::assertSame(
			$GLOBALS['SIM_EXEC_TIME'],
			$this->subject->getAsInteger('tstamp')
		);
	}

	/**
	 * @test
	 */
	public function setCreationDateForLoadedModelWithUidThrowsException() {
		$this->setExpectedException(
			'BadMethodCallException',
			'Only new objects (without UID) may receive "crdate".'
		);

		$this->subject->setData(array('uid' => 1));
		$this->subject->setCreationDate();
	}

	/**
	 * @test
	 */
	public function setCreationDateForLoadedModelWithoutUidSetsCrdate() {
		$this->subject->setData(array());
		$this->subject->setCreationDate();

		self::assertSame(
			$GLOBALS['SIM_EXEC_TIME'],
			$this->subject->getAsInteger('crdate')
		);
	}


	////////////////////////////////
	// Tests concerning getPageUid
	////////////////////////////////

	/**
	 * @test
	 */
	public function getPageUidForNoPageUidSetReturnsZero() {
		$this->subject->setData(array());

		self::assertSame(
			0,
			$this->subject->getPageUid()
		);
	}

	/**
	 * @test
	 */
	public function getPageUidReturnsPageUid() {
		$this->subject->setData(array('pid' => 42));

		self::assertSame(
			42,
			$this->subject->getPageUid()
		);
	}

	/**
	 * @test
	 */
	public function setPageUidSetsPageUid() {
		$this->subject->setPageUid(84);

		self::assertSame(
			84,
			$this->subject->getPageUid()
		);
	}

	/**
	 * @test
	 */
	public function setPageUidWithZeroPageUidNotThrowsException() {
		$this->subject->setPageUid(0);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function setPageUidWithNegativePageUidThrowsException() {
		$this->subject->setPageUid(-1);
	}


	//////////////////////////////////////////////////////////
	// Tests concerning the setting of the "hidden" property
	//////////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function markAsHiddenMarksVisibleModelAsHidden() {
		$this->subject->setData(array('hidden' => FALSE));

		$this->subject->markAsHidden();

		self::assertTrue(
			$this->subject->isHidden()
		);
	}

	/**
	 * @test
	 */
	public function markAsVisibleMarksHiddenModelAsNotHidden() {
		$this->subject->setData(array('hidden' => TRUE));

		$this->subject->markAsVisible();

		self::assertFalse(
			$this->subject->isHidden()
		);
	}

	/*
	 * Tests concerning __clone
	 */

	/**
	 * @test
	 * @expectedException \BadMethodCallException
	 */
	public function cloneOfReadOnlyModelThrowsException() {
		$this->subject->markAsReadOnly();

		clone $this->subject;
	}

	/**
	 * @return int[][]
	 */
	public function uncloneableStatusDataProvider() {
		return array(
			'loading' => array(Tx_Oelib_Model::STATUS_LOADING),
			'deleted' => array(Tx_Oelib_Model::STATUS_DEAD),
		);
	}

	/**
	 * @test
	 * @param string $status
	 * @dataProvider uncloneableStatusDataProvider
	 * @expectedException \BadMethodCallException
	 */
	public function cloneWithInvalidStatusThrowsException($status) {
		$this->subject->setLoadStatus($status);

		clone $this->subject;
	}
}
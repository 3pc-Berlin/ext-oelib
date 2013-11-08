<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2013 Niels Pardon (mail@niels-pardon.de)
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
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class tx_oelib_MailTest extends tx_phpunit_testcase {
	/**
	 * @var tx_oelib_Mail
	 */
	private $fixture;

	public function setUp() {
		$this->fixture = new tx_oelib_Mail();
	}

	public function tearDown() {
		$this->fixture->__destruct();
		unset($this->fixture);
	}


	////////////////////////////////////////////////////
	// Tests regarding setting and getting the sender.
	////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getSenderInitiallyReturnsNull() {
		$this->assertNull(
			$this->fixture->getSender()
		);
	}

	/**
	 * @test
	 */
	public function getSenderForNonEmptySenderReturnsSender() {
		$sender = new tx_oelib_tests_fixtures_TestingMailRole(
			'John Doe', 'foo@bar.com'
		);

		$this->fixture->setSender($sender);

		$this->assertSame(
			$sender,
			$this->fixture->getSender()
		);

		$sender->__destruct();
	}

	/**
	 * @test
	 */
	public function hasSenderInitiallyReturnsFalse() {
		$this->assertFalse(
			$this->fixture->hasSender()
		);
	}

	/**
	 * @test
	 */
	public function hasSenderWithSenderReturnsTrue() {
		$sender = new tx_oelib_tests_fixtures_TestingMailRole(
			'John Doe', 'foo@bar.com'
		);

		$this->fixture->setSender($sender);

		$this->assertTrue(
			$this->fixture->hasSender()
		);

		$sender->__destruct();
	}


	////////////////////////////////////////////////////////
	// Tests regarding adding and getting the recipients.
	////////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getRecipientsInitiallyReturnsEmptyArray() {
		$this->assertSame(
			array(),
			$this->fixture->getRecipients()
		);
	}

	/**
	 * @test
	 */
	public function getRecipientsWithOneRecipientReturnsOneRecipient() {
		$recipient = new tx_oelib_tests_fixtures_TestingMailRole(
			'John Doe', 'foo@bar.com'
		);
		$this->fixture->addRecipient($recipient);

		$this->assertSame(
			array($recipient),
			$this->fixture->getRecipients()
		);

		$recipient->__destruct();
	}

	/**
	 * @test
	 */
	public function getRecipientsWithTwoRecipientsReturnsTwoRecipients() {
		$recipient1 = new tx_oelib_tests_fixtures_TestingMailRole(
			'John Doe', 'foo@bar.com'
		);
		$recipient2 = new tx_oelib_tests_fixtures_TestingMailRole(
			'John Doe', 'foo@bar.com'
		);
		$this->fixture->addRecipient($recipient1);
		$this->fixture->addRecipient($recipient2);

		$this->assertSame(
			array($recipient1, $recipient2),
			$this->fixture->getRecipients()
		);

		$recipient1->__destruct();
		$recipient2->__destruct();
	}


	/////////////////////////////////////////////////////
	// Tests regarding setting and getting the subject.
	/////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getSubjectInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getSubject()
		);
	}

	/**
	 * @test
	 */
	public function getSubjectWithNonEmptySubjectReturnsSubject() {
		$this->fixture->setSubject('test subject');

		$this->assertSame(
			'test subject',
			$this->fixture->getSubject()
		);
	}

	/**
	 * @test
	 */
	public function setSubjectWithEmptySubjectThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$subject must not be empty.'
		);

		$this->fixture->setSubject('');
	}

	/**
	 * @test
	 */
	public function setSubjectWithSubjectContainingCarriageReturnThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$subject must not contain any line breaks or carriage returns.'
		);

		$this->fixture->setSubject('test ' . CR . ' subject');
	}

	/**
	 * @test
	 */
	public function setSubjectWithSubjectContainingLinefeedThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$subject must not contain any line breaks or carriage returns.'
		);

		$this->fixture->setSubject('test ' . LF . ' subject');
	}

	/**
	 * @test
	 */
	public function setSubjectWithSubjectContainingCarriageReturnLinefeedThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$subject must not contain any line breaks or carriage returns.'
		);

		$this->fixture->setSubject('test ' . CRLF . ' subject');
	}


	/////////////////////////////////////////////////////
	// Tests regarding setting and getting the message.
	/////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getMessageInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getMessage()
		);
	}

	/**
	 * @test
	 */
	public function getMessageWithNonEmptyMessageReturnsMessage() {
		$this->fixture->setMessage('test message');

		$this->assertSame(
			'test message',
			$this->fixture->getMessage()
		);
	}

	/**
	 * @test
	 */
	public function setMessageWithEmptyMessageThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$message must not be empty.'
		);

		$this->fixture->setMessage('');
	}

	/**
	 * @test
	 */
	public function hasMessageInitiallyReturnsFalse() {
		$this->assertFalse(
			$this->fixture->hasMessage()
		);
	}

	/**
	 * @test
	 */
	public function hasMessageWithMessageReturnsTrue() {
		$this->fixture->setMessage('test');

		$this->assertTrue(
			$this->fixture->hasMessage()
		);
	}


	//////////////////////////////////////////////////////////
	// Tests regarding setting and getting the HTML message.
	//////////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getHTMLMessageInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getHTMLMessage()
		);
	}

	/**
	 * @test
	 */
	public function getHTMLMessageWithNonEmptyMessageReturnsMessage() {
		$this->fixture->setHTMLMessage('test message');

		$this->assertSame(
			'test message',
			$this->fixture->getHTMLMessage()
		);
	}

	/**
	 * @test
	 */
	public function setHTMLMessageWithEmptyMessageThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'$message must not be empty.'
		);

		$this->fixture->setHTMLMessage('');
	}

	/**
	 * @test
	 */
	public function hasHTMLMessageInitiallyReturnsFalse() {
		$this->assertFalse(
			$this->fixture->hasHTMLMessage()
		);
	}

	/**
	 * @test
	 */
	public function hasHTMLMessageWithHTMLMessageReturnsTrue() {
		$this->fixture->setHTMLMessage('<p>test</p>');

		$this->assertTrue(
			$this->fixture->hasHTMLMessage()
		);
	}

	////////////////////////////////////////////////////
	// Tests regarding adding and getting attachments.
	////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getAttachmentsInitiallyReturnsEmptyArray() {
		$this->assertSame(
			array(),
			$this->fixture->getAttachments()
		);
	}

	/**
	 * @test
	 */
	public function getAttachmentsWithOneAttachmentReturnsOneAttachment() {
		$attachment = new tx_oelib_Attachment();
		$attachment->setFileName('test.txt');
		$attachment->setContentType('text/plain');
		$attachment->setContent('Test');
		$this->fixture->addAttachment($attachment);

		$this->assertSame(
			array($attachment),
			$this->fixture->getAttachments()
		);
	}

	/**
	 * @test
	 */
	public function getAttachmentsWithTwoAttachmentsReturnsTwoAttachments() {
		$attachment = new tx_oelib_Attachment();
		$attachment->setFileName('test.txt');
		$attachment->setContentType('text/plain');
		$attachment->setContent('Test');
		$this->fixture->addAttachment($attachment);

		$otherAttachment = new tx_oelib_Attachment();
		$otherAttachment->setFileName('second_test.txt');
		$otherAttachment->setContentType('text/plain');
		$otherAttachment->setContent('Second Test');
		$this->fixture->addAttachment($otherAttachment);

		$this->assertSame(
			array($attachment, $otherAttachment),
			$this->fixture->getAttachments()
		);
	}


	//////////////////////////////////////////////////////
	// Tests regarding setting and getting the CSS file.
	//////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function setCssFileForNoCssFileGivenDoesNotSetCssFile() {
		$this->fixture->setCssFile('');

		$this->assertFalse(
			$this->fixture->hasCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForStringGivenWhichIsNoFileDoesNotSetCssFile() {
		$this->fixture->setCssFile('foo');

		$this->assertFalse(
			$this->fixture->hasCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForGivenCssFileWithAbsolutePathSetsCssFile() {
		$this->fixture->setCssFile(
			t3lib_extMgm::extPath('oelib') . 'tests/fixtures/test.css'
		);

		$this->assertTrue(
			$this->fixture->hasCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForGivenCssFileWithAbsoluteExtPathSetsCssFile() {
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test.css');

		$this->assertTrue(
			$this->fixture->hasCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForGivenCssFileStoresContentsOfCssFile() {
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test.css');

		$this->assertContains(
			'h3',
			$this->fixture->getCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForSetCssFileAndThenGivenEmptyStringClearsStoredCssFileData() {
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test.css');
		$this->fixture->setCssFile('');

		$this->assertFalse(
			$this->fixture->hasCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForSetCssFileAndThenGivenNewCssFileRemovesOldCssDataFromStorage() {
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test.css');
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test_2.css');

		$this->assertNotContains(
			'h3',
			$this->fixture->getCssFile()
		);
	}

	/**
	 * @test
	 */
	public function setCssFileForSetCssFileAndThenGivenNewCssFileStoresNewCssData() {
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test.css');
		$this->fixture->setCssFile('EXT:oelib/tests/fixtures/test_2.css');

		$this->assertContains(
			'h4',
			$this->fixture->getCssFile()
		);
	}


	/////////////////////////////////////////////////////////////////////////////
	// Tests concerning the mogrification of the HTML Messages and the CSS file
	/////////////////////////////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function setHtmlMessageWithNoCssFileStoredOnlyStoresTheHtmlMessage() {
		$htmlMessage =
			'<html>' .
				'<head><title>foo</title></head>' .
				'<body><h3>Bar</h3></body>' .
			'</html>';
		$this->fixture->setHTMLMessage($htmlMessage);

		$this->assertSame(
			$htmlMessage,
			$this->fixture->getHTMLMessage()
		);
	}

	/**
	 * @test
	 */
	public function setHtmlMessageWithCssFileStoredStoresAttributesFromCssInHtmlMessage() {
		$this->fixture->setCssFile(
			t3lib_extMgm::extPath('oelib') . 'tests/fixtures/test.css'
		);
		$this->fixture->setHTMLMessage(
			'<html>' .
				'<head><title>foo</title></head>' .
				'<body><h3>Bar</h3></body>' .
			'</html>'
		);

		$this->assertSame(
			'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"' .
				' "http://www.w3.org/TR/REC-html40/loose.dtd">' . LF .
			'<html>' . LF .
				'<head><title>foo</title></head>' . LF .
				'<body><h3 style="font-weight: bold;">Bar</h3></body>' . LF .
			'</html>'
			,
			$this->fixture->getHTMLMessage()
		);
	}


	////////////////////////////////////////////
	// Tests concerning the additional headers
	////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getAdditionalHeadersForNoAdditionalHeadersReturnsEmptyArray() {
		$this->assertSame(
			array(),
			$this->fixture->getAdditionalHeaders()
		);
	}

	/**
	 * @test
	 */
	public function setReturnPathForNoReturnPathSetSetsGivenReturnPath() {
		$this->fixture->setReturnPath('foo@bar.com');

		$this->assertSame(
			array(
				'Return-Path' => '<foo@bar.com>',
				'Errors-To' => 'foo@bar.com',
			),
			$this->fixture->getAdditionalHeaders()
		);
	}

	/**
	 * @test
	 */
	public function setReturnPathForAlreadySetReturnPathOverridesOldReturnPath() {
		$this->fixture->setReturnPath('old@mail.com');
		$this->fixture->setReturnPath('foo@bar.com');

		$this->assertSame(
			array(
				'Return-Path' => '<foo@bar.com>',
				'Errors-To' => 'foo@bar.com',
			),
			$this->fixture->getAdditionalHeaders()
		);
	}

	/**
	 * @test
	 */
	public function setReturnPathForNoSetReturnPathAndEmptyStringGivenDoesNotSetAnyReturnPath() {
		$this->fixture->setReturnPath('');

		$this->assertSame(
			array(),
			$this->fixture->getAdditionalHeaders()
		);
	}

	/**
	 * @test
	 */
	public function setReturnPathForSetReturnPathAndEmptyStringGivenDoesNotUnsetReturnPath() {
		$this->fixture->setReturnPath('foo@bar.com');
		$this->fixture->setReturnPath('');

		$this->assertSame(
			array(
				'Return-Path' => '<foo@bar.com>',
				'Errors-To' => 'foo@bar.com',
			),
			$this->fixture->getAdditionalHeaders()
		);
	}

	/**
	 * @test
	 */
	public function setReturnPathSetsMemberVariableReturnPath() {
		$this->fixture->setReturnPath('foo@bar.com');

		$this->assertSame(
			'foo@bar.com',
			$this->fixture->getReturnPath()
		);
	}

	/**
	 * @test
	 */
	public function getReturnPathInitiallyReturnsAnEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getReturnPath()
		);
	}

	/**
	 * @test
	 */
	public function setReturnPathForAlreadySetReturnPathAndNoStringGivenDoesNotOverrideTheReturnPath() {
		$this->fixture->setReturnPath('foo@bar.com');
		$this->fixture->setReturnPath('');

		$this->assertSame(
			'foo@bar.com',
			$this->fixture->getReturnPath()
		);
	}

	/**
	 * @test
	 */
	public function getReturnPathForStringSetInReturnPathReturnsThisString() {
		$this->fixture->setReturnPath('foo@bar.com');

		$this->assertSame(
			'foo@bar.com',
			$this->fixture->getReturnPath()
		);
	}

	/**
	 * @test
	 */
	public function hasAdditionalHeadersForNoAdditionalHeadersSetReturnsFalse() {
		$this->assertFalse(
			$this->fixture->hasAdditionalHeaders()
		);
	}

	/**
	 * @test
	 */
	public function hasAdditionalHeadersForAdditionalHeadersSetReturnsTrue() {
		$this->fixture->setReturnPath('foo@bar.com');

		$this->assertTrue(
			$this->fixture->hasAdditionalHeaders()
		);
	}
}
?>
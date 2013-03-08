<?php
/**
 * @author Antoine Musso
 * @copyright Copyright © 2011, Antoine Musso
 * @file
 */

/**
 * Test class for MWNamespace.
 * Generated by PHPUnit on 2011-02-20 at 21:01:55.
 *
 */
class MWNamespaceTest extends MediaWikiTestCase {
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
	}


#### START OF TESTS #########################################################

	/**
	 * @todo Write more texts, handle $wgAllowImageMoving setting
	 */
	public function testIsMovable() {
		$this->assertFalse( MWNamespace::isMovable( NS_CATEGORY ) );
		# @todo FIXME: Write more tests!!
	}

	/**
	 * Please make sure to change testIsTalk() if you change the assertions below
	 */
	public function testIsSubject() {
		// Special namespaces
		$this->assertIsSubject( NS_MEDIA   );
		$this->assertIsSubject( NS_SPECIAL );

		// Subject pages
		$this->assertIsSubject( NS_MAIN );
		$this->assertIsSubject( NS_USER );
		$this->assertIsSubject( 100     );  # user defined

		// Talk pages
		$this->assertIsNotSubject( NS_TALK      );
		$this->assertIsNotSubject( NS_USER_TALK );
		$this->assertIsNotSubject( 101          ); # user defined

		// Back compat
		$this->assertTrue( MWNamespace::isMain( NS_MAIN ) == MWNamespace::isSubject( NS_MAIN ) );
		$this->assertTrue( MWNamespace::isMain( NS_USER_TALK ) == MWNamespace::isSubject( NS_USER_TALK ) );
	}

	/**
	 * Reverse of testIsSubject().
	 * Please update testIsSubject() if you change assertions below
	 */
	public function testIsTalk() {
		// Special namespaces
		$this->assertIsNotTalk( NS_MEDIA   );
		$this->assertIsNotTalk( NS_SPECIAL );

		// Subject pages
		$this->assertIsNotTalk( NS_MAIN   );
		$this->assertIsNotTalk( NS_USER   );
		$this->assertIsNotTalk( 100       );  # user defined

		// Talk pages
		$this->assertIsTalk( NS_TALK      );
		$this->assertIsTalk( NS_USER_TALK );
		$this->assertIsTalk( 101          ); # user defined
	}

	/**
	 */
	public function testGetSubject() {
		// Special namespaces are their own subjects
		$this->assertEquals( NS_MEDIA, MWNamespace::getSubject( NS_MEDIA ) );
		$this->assertEquals( NS_SPECIAL, MWNamespace::getSubject( NS_SPECIAL ) );

		$this->assertEquals( NS_MAIN, MWNamespace::getSubject( NS_TALK ) );
		$this->assertEquals( NS_USER, MWNamespace::getSubject( NS_USER_TALK ) );
	}

	/**
	 * Regular getTalk() calls
	 * Namespaces without a talk page (NS_MEDIA, NS_SPECIAL) are tested in
	 * the function testGetTalkExceptions()
	 */
	public function testGetTalk() {
		$this->assertEquals( NS_TALK, MWNamespace::getTalk( NS_MAIN ) );
		$this->assertEquals( NS_TALK, MWNamespace::getTalk( NS_TALK ) );
		$this->assertEquals( NS_USER_TALK, MWNamespace::getTalk( NS_USER ) );
		$this->assertEquals( NS_USER_TALK, MWNamespace::getTalk( NS_USER_TALK ) );
	}

	/**
	 * Exceptions with getTalk()
	 * NS_MEDIA does not have talk pages. MediaWiki raise an exception for them.
	 * @expectedException MWException
	 */
	public function testGetTalkExceptionsForNsMedia() {
		$this->assertNull( MWNamespace::getTalk( NS_MEDIA ) );
	}

	/**
	 * Exceptions with getTalk()
	 * NS_SPECIAL does not have talk pages. MediaWiki raise an exception for them.
	 * @expectedException MWException
	 */
	public function testGetTalkExceptionsForNsSpecial() {
		$this->assertNull( MWNamespace::getTalk( NS_SPECIAL ) );
	}

	/**
	 * Regular getAssociated() calls
	 * Namespaces without an associated page (NS_MEDIA, NS_SPECIAL) are tested in
	 * the function testGetAssociatedExceptions()
	 */
	public function testGetAssociated() {
		$this->assertEquals( NS_TALK, MWNamespace::getAssociated( NS_MAIN ) );
		$this->assertEquals( NS_MAIN, MWNamespace::getAssociated( NS_TALK ) );

	}

	### Exceptions with getAssociated()
	### NS_MEDIA and NS_SPECIAL do not have talk pages. MediaWiki raises
	### an exception for them.
	/**
	 * @expectedException MWException
	 */
	public function testGetAssociatedExceptionsForNsMedia() {
		$this->assertNull( MWNamespace::getAssociated( NS_MEDIA   ) );
	}

	/**
	 * @expectedException MWException
	 */
	public function testGetAssociatedExceptionsForNsSpecial() {
		$this->assertNull( MWNamespace::getAssociated( NS_SPECIAL ) );
	}

	/**
	 * @todo Implement testExists().
	 */
/*
	public function testExists() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet. Rely on $wgCanonicalNamespaces.'
		);
	}
*/

	/**
	 * Test MWNamespace::equals
	 * Note if we add a namespace registration system with keys like 'MAIN'
	 * we should add tests here for equivilance on things like 'MAIN' == 0
	 * and 'MAIN' == NS_MAIN.
	 */
	public function testEquals() {
		$this->assertTrue( MWNamespace::equals( NS_MAIN, NS_MAIN ) );
		$this->assertTrue( MWNamespace::equals( NS_MAIN, 0 ) ); // In case we make NS_MAIN 'MAIN'
		$this->assertTrue( MWNamespace::equals( NS_USER, NS_USER ) );
		$this->assertTrue( MWNamespace::equals( NS_USER, 2 ) );
		$this->assertTrue( MWNamespace::equals( NS_USER_TALK, NS_USER_TALK ) );
		$this->assertTrue( MWNamespace::equals( NS_SPECIAL, NS_SPECIAL ) );
		$this->assertFalse( MWNamespace::equals( NS_MAIN, NS_TALK ) );
		$this->assertFalse( MWNamespace::equals( NS_USER, NS_USER_TALK ) );
		$this->assertFalse( MWNamespace::equals( NS_PROJECT, NS_TEMPLATE ) );
	}

	/**
	 * Test MWNamespace::subjectEquals
	 */
	public function testSubjectEquals() {
		$this->assertSameSubject( NS_MAIN, NS_MAIN );
		$this->assertSameSubject( NS_MAIN, 0 ); // In case we make NS_MAIN 'MAIN'
		$this->assertSameSubject( NS_USER, NS_USER );
		$this->assertSameSubject( NS_USER, 2 );
		$this->assertSameSubject( NS_USER_TALK, NS_USER_TALK );
		$this->assertSameSubject( NS_SPECIAL, NS_SPECIAL );
		$this->assertSameSubject( NS_MAIN, NS_TALK );
		$this->assertSameSubject( NS_USER, NS_USER_TALK );

		$this->assertDifferentSubject( NS_PROJECT, NS_TEMPLATE );
		$this->assertDifferentSubject( NS_SPECIAL, NS_MAIN     );
	}

	public function testSpecialAndMediaAreDifferentSubjects() {
		$this->assertDifferentSubject(
			NS_MEDIA, NS_SPECIAL,
			"NS_MEDIA and NS_SPECIAL are different subject namespaces"
		);
		$this->assertDifferentSubject(
			NS_SPECIAL, NS_MEDIA,
			"NS_SPECIAL and NS_MEDIA are different subject namespaces"
		);

	}

	/**
	 * @todo Implement testGetCanonicalNamespaces().
	 */
/*
	public function testGetCanonicalNamespaces() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet. Rely on $wgCanonicalNamespaces.'
		);
	}
*/
	/**
	 * @todo Implement testGetCanonicalName().
	 */
/*
	public function testGetCanonicalName() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet. Rely on $wgCanonicalNamespaces.'
		);
	}
*/
	/**
	 * @todo Implement testGetCanonicalIndex().
	 */
/*
	public function testGetCanonicalIndex() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet. Rely on $wgCanonicalNamespaces.'
		);
	}
*/
	/**
	 * @todo Implement testGetValidNamespaces().
	 */
/*
	public function testGetValidNamespaces() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet. Rely on $wgCanonicalNamespaces.'
		);
	}
*/
	/**
	 */
	public function testCanTalk() {
		$this->assertCanNotTalk( NS_MEDIA   );
		$this->assertCanNotTalk( NS_SPECIAL );

		$this->assertCanTalk( NS_MAIN      );
		$this->assertCanTalk( NS_TALK      );
		$this->assertCanTalk( NS_USER      );
		$this->assertCanTalk( NS_USER_TALK );

		// User defined namespaces
		$this->assertCanTalk( 100 );
		$this->assertCanTalk( 101 );
	}

	/**
	 */
	public function testIsContent() {
		// NS_MAIN is a content namespace per DefaultSettings.php
		// and per function definition.
		$this->assertIsContent( NS_MAIN );

		global $wgContentNamespaces;

		$saved = $wgContentNamespaces;

		$wgContentNamespaces[] = NS_MAIN;
		$this->assertIsContent( NS_MAIN );

		// Other namespaces which are not expected to be content
		if ( isset( $wgContentNamespaces[NS_MEDIA] ) ) {
			unset( $wgContentNamespaces[NS_MEDIA] );
		}
		$this->assertIsNotContent( NS_MEDIA );

		if ( isset( $wgContentNamespaces[NS_SPECIAL] ) ) {
			unset( $wgContentNamespaces[NS_SPECIAL] );
		}
		$this->assertIsNotContent( NS_SPECIAL );

		if ( isset( $wgContentNamespaces[NS_TALK] ) ) {
			unset( $wgContentNamespaces[NS_TALK] );
		}
		$this->assertIsNotContent( NS_TALK );

		if ( isset( $wgContentNamespaces[NS_USER] ) ) {
			unset( $wgContentNamespaces[NS_USER] );
		}
		$this->assertIsNotContent( NS_USER );

		if ( isset( $wgContentNamespaces[NS_CATEGORY] ) ) {
			unset( $wgContentNamespaces[NS_CATEGORY] );
		}
		$this->assertIsNotContent( NS_CATEGORY );

		if ( isset( $wgContentNamespaces[100] ) ) {
			unset( $wgContentNamespaces[100] );
		}
		$this->assertIsNotContent( 100 );

		$wgContentNamespaces = $saved;
	}

	/**
	 * Similar to testIsContent() but alters the $wgContentNamespaces
	 * global variable.
	 */
	public function testIsContentWithAdditionsInWgContentNamespaces() {
		// NS_MAIN is a content namespace per DefaultSettings.php
		// and per function definition.
		$this->assertIsContent( NS_MAIN );

		// Tests that user defined namespace #252 is not content:
		$this->assertIsNotContent( 252 );

		# @todo FIXME: Is global saving really required for PHPUnit?
		// Bless namespace # 252 as a content namespace
		global $wgContentNamespaces;
		$savedGlobal = $wgContentNamespaces;
		$wgContentNamespaces[] = 252;
		$this->assertIsContent( 252 );

		// Makes sure NS_MAIN was not impacted
		$this->assertIsContent( NS_MAIN );

		// Restore global
		$wgContentNamespaces = $savedGlobal;

		// Verify namespaces after global restauration
		$this->assertIsContent( NS_MAIN  );
		$this->assertIsNotContent( 252 );
	}

	public function testIsWatchable() {
		// Specials namespaces are not watchable
		$this->assertIsNotWatchable( NS_MEDIA   );
		$this->assertIsNotWatchable( NS_SPECIAL );

		// Core defined namespaces are watchables
		$this->assertIsWatchable( NS_MAIN );
		$this->assertIsWatchable( NS_TALK );

		// Additional, user defined namespaces are watchables
		$this->assertIsWatchable( 100 );
		$this->assertIsWatchable( 101 );
	}

	public function testHasSubpages() {
		// Special namespaces:
		$this->assertHasNotSubpages( NS_MEDIA   );
		$this->assertHasNotSubpages( NS_SPECIAL );

		// namespaces without subpages
		# save up global
		global $wgNamespacesWithSubpages;
		$saved = null;
		if( array_key_exists( NS_MAIN, $wgNamespacesWithSubpages ) ) {
			$saved = $wgNamespacesWithSubpages[NS_MAIN];
			unset( $wgNamespacesWithSubpages[NS_MAIN] );
		}

		$this->assertHasNotSubpages( NS_MAIN );

		$wgNamespacesWithSubpages[NS_MAIN] = true;
		$this->assertHasSubpages( NS_MAIN );
		$wgNamespacesWithSubpages[NS_MAIN] = false;
		$this->assertHasNotSubpages( NS_MAIN );

		# restore global
		if( $saved !== null ) {
			$wgNamespacesWithSubpages[NS_MAIN] = $saved;
		}

		// Some namespaces with subpages
		$this->assertHasSubpages( NS_TALK      );
		$this->assertHasSubpages( NS_USER      );
		$this->assertHasSubpages( NS_USER_TALK );
	}

	/**
	 */
	public function testGetContentNamespaces() {
		$this->assertEquals(
			array( NS_MAIN ),
			MWNamespace::getcontentNamespaces(),
			'$wgContentNamespaces is an array with only NS_MAIN by default'
		);

		global $wgContentNamespaces;

		$saved = $wgContentNamespaces;
		# test !is_array( $wgcontentNamespaces )
		$wgContentNamespaces = '';
		$this->assertEquals( NS_MAIN, MWNamespace::getcontentNamespaces() );
		$wgContentNamespaces = false;
		$this->assertEquals( NS_MAIN, MWNamespace::getcontentNamespaces() );
		$wgContentNamespaces = null;
		$this->assertEquals( NS_MAIN, MWNamespace::getcontentNamespaces() );
		$wgContentNamespaces = 5;
		$this->assertEquals( NS_MAIN, MWNamespace::getcontentNamespaces() );

		# test $wgContentNamespaces === array()
		$wgContentNamespaces = array();
		$this->assertEquals( NS_MAIN, MWNamespace::getcontentNamespaces() );

		# test !in_array( NS_MAIN, $wgContentNamespaces )
		$wgContentNamespaces = array( NS_USER, NS_CATEGORY );
		$this->assertEquals(
			array( NS_MAIN, NS_USER, NS_CATEGORY ),
			MWNamespace::getcontentNamespaces(),
			'NS_MAIN is forced in $wgContentNamespaces even if unwanted'
		);

		# test other cases, return $wgcontentNamespaces as is
		$wgContentNamespaces = array( NS_MAIN );
		$this->assertEquals(
			array( NS_MAIN ),
			MWNamespace::getcontentNamespaces()
		);

		$wgContentNamespaces = array( NS_MAIN, NS_USER, NS_CATEGORY );
		$this->assertEquals(
			array( NS_MAIN, NS_USER, NS_CATEGORY ),
			MWNamespace::getcontentNamespaces()
		);

		$wgContentNamespaces = $saved;
	}

	/**
	 * Some namespaces are always capitalized per code definition
	 * in MWNamespace::$alwaysCapitalizedNamespaces
	 */
	public function testIsCapitalizedHardcodedAssertions() {
		// NS_MEDIA and NS_FILE are treated the same
		$this->assertEquals(
			MWNamespace::isCapitalized( NS_MEDIA ),
			MWNamespace::isCapitalized( NS_FILE  ),
			'NS_MEDIA and NS_FILE have same capitalization rendering'
		);

		// Boths are capitalized by default
		$this->assertIsCapitalized( NS_MEDIA );
		$this->assertIsCapitalized( NS_FILE  );

		// Always capitalized namespaces
		// @see MWNamespace::$alwaysCapitalizedNamespaces
		$this->assertIsCapitalized( NS_SPECIAL   );
		$this->assertIsCapitalized( NS_USER      );
		$this->assertIsCapitalized( NS_MEDIAWIKI );
	}

	/**
	 * Follows up for testIsCapitalizedHardcodedAssertions() but alter the
	 * global $wgCapitalLink setting to have extended coverage.
	 *
	 * MWNamespace::isCapitalized() rely on two global settings:
	 *   $wgCapitalLinkOverrides = array(); by default
	 *   $wgCapitalLinks = true; by default
	 * This function test $wgCapitalLinks
 	 *
	 * Global setting correctness is tested against the NS_PROJECT and
	 * NS_PROJECT_TALK namespaces since they are not hardcoded nor specials
	 */
	public function testIsCapitalizedWithWgCapitalLinks() {
		global $wgCapitalLinks;
		// Save the global to easily reset to MediaWiki default settings
		$savedGlobal = $wgCapitalLinks;

		$wgCapitalLinks = true;
		$this->assertIsCapitalized( NS_PROJECT      );
		$this->assertIsCapitalized( NS_PROJECT_TALK );

		$wgCapitalLinks = false;
		// hardcoded namespaces (see above function) are still capitalized:
		$this->assertIsCapitalized( NS_SPECIAL   );
		$this->assertIsCapitalized( NS_USER      );
		$this->assertIsCapitalized( NS_MEDIAWIKI );
		// setting is correctly applied
		$this->assertIsNotCapitalized( NS_PROJECT      );
		$this->assertIsNotCapitalized( NS_PROJECT_TALK );

		// reset global state:
		$wgCapitalLinks = $savedGlobal;
	}

	/**
	 * Counter part for MWNamespace::testIsCapitalizedWithWgCapitalLinks() now
	 * testing the $wgCapitalLinkOverrides global.
	 *
	 * @todo split groups of assertions in autonomous testing functions
	 */
	public function testIsCapitalizedWithWgCapitalLinkOverrides() {
		global $wgCapitalLinkOverrides;
		// Save the global to easily reset to MediaWiki default settings
		$savedGlobal = $wgCapitalLinkOverrides;

		// Test default settings
		$this->assertIsCapitalized( NS_PROJECT      );
		$this->assertIsCapitalized( NS_PROJECT_TALK );
		// hardcoded namespaces (see above function) are capitalized:
		$this->assertIsCapitalized( NS_SPECIAL   );
		$this->assertIsCapitalized( NS_USER      );
		$this->assertIsCapitalized( NS_MEDIAWIKI );

		// Hardcoded namespaces remains capitalized
		$wgCapitalLinkOverrides[NS_SPECIAL]   = false;
		$wgCapitalLinkOverrides[NS_USER]      = false;
		$wgCapitalLinkOverrides[NS_MEDIAWIKI] = false;
		$this->assertIsCapitalized( NS_SPECIAL   );
		$this->assertIsCapitalized( NS_USER      );
		$this->assertIsCapitalized( NS_MEDIAWIKI );

		$wgCapitalLinkOverrides = $savedGlobal;
		$wgCapitalLinkOverrides[NS_PROJECT] = false;
		$this->assertIsNotCapitalized( NS_PROJECT );
		$wgCapitalLinkOverrides[NS_PROJECT] = true ;
		$this->assertIsCapitalized( NS_PROJECT );
		unset(  $wgCapitalLinkOverrides[NS_PROJECT] );
		$this->assertIsCapitalized( NS_PROJECT );

		// reset global state:
		$wgCapitalLinkOverrides = $savedGlobal;
	}

	public function testHasGenderDistinction() {
		// Namespaces with gender distinctions
		$this->assertTrue( MWNamespace::hasGenderDistinction( NS_USER      ) );
		$this->assertTrue( MWNamespace::hasGenderDistinction( NS_USER_TALK ) );

		// Other ones, "genderless"
		$this->assertFalse( MWNamespace::hasGenderDistinction( NS_MEDIA   ) );
		$this->assertFalse( MWNamespace::hasGenderDistinction( NS_SPECIAL ) );
		$this->assertFalse( MWNamespace::hasGenderDistinction( NS_MAIN    ) );
		$this->assertFalse( MWNamespace::hasGenderDistinction( NS_TALK    ) );

	}

	####### HELPERS ###########################################################
	function __call( $method, $args ) {
		// Call the real method if it exists
		if( method_exists($this, $method ) ) {
			return $this->$method( $args );
		}

		if( preg_match( '/^assert(Has|Is|Can)(Not|)(Subject|Talk|Watchable|Content|Subpages|Capitalized)$/', $method, $m ) ) {
			# Interprets arguments:
			$ns  = $args[0];
			$msg = isset($args[1]) ? $args[1] : " dummy message";

			# Forge the namespace constant name:
			if( $ns === 0 ) {
				$ns_name = "NS_MAIN";
			} else {
				$ns_name = "NS_" . strtoupper(  MWNamespace::getCanonicalName( $ns ) );
			}
			# ... and the MWNamespace method name
			$nsMethod = strtolower( $m[1] ) . $m[3];

			$expect = ($m[2] === '');
			$expect_name = $expect ? 'TRUE' : 'FALSE';

			return $this->assertEquals( $expect,
				MWNamespace::$nsMethod( $ns, $msg ),
				"MWNamespace::$nsMethod( $ns_name ) should returns $expect_name"
			);
		}

		throw new Exception( __METHOD__ . " could not find a method named $method\n" );
	}

	function assertSameSubject( $ns1, $ns2, $msg = '' ) {
		$this->assertTrue( MWNamespace::subjectEquals( $ns1, $ns2, $msg ) );
	}
	function assertDifferentSubject( $ns1, $ns2, $msg = '' ) {
		$this->assertFalse( MWNamespace::subjectEquals( $ns1, $ns2, $msg ) );
	}
}

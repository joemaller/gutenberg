/**
 * Internal dependencies
 */
import '../../support/bootstrap';
import {
	insertBlock,
	newDesktopBrowserPage,
	newPost,
	// publishPost,
	// searchForBlock,
	typeIntoEditor,
	visitPublishedPage,
} from '../../support/utils';

describe( 'core/blocks: Latest Comments', () => {
	beforeEach( async () => {
		await newDesktopBrowserPage();
		await newPost();
	} );

	it( 'should show latest comments when comments exist', async () => {
		await typeIntoEditor();
		await visitPublishedPage();

		await page.waitForSelector( '#comment' );
		await page.type( '#comment', 'Hello I am a comment.' );
		await page.click( '#submit' );
		await page.waitForNavigation();
		// await page.type( '#comment', 'Hello I am another comment.' );
		// await page.click( '#submit' );
		// await page.waitForNavigation();

		await page.goBack();
		await page.goBack();

		await insertBlock( 'Latest Comments' );

		await page.waitForSelector( '.wp-block-latest-comments__comment' );
		const commentsBlock = await page.$$( '.wp-block-latest-comments' );
		const comments = await page.$$( '.wp-block-latest-comments__comment' );

		expect( commentsBlock ).toHaveLength( 1 );
		expect( comments ).toHaveLength( 5 );
	} );

	it( 'should show no comments when zero comments exist', async () => {
		await insertBlock( 'Latest Comments' );

		await page.waitForSelector( '.wp-block-latest-comments' );
		const commentsBlock = await page.$$( '.wp-block-latest-comments' );
		const comments = await page.$$( '.wp-block-latest-comments-comment' );

		expect( commentsBlock ).toHaveLength( 1 );
		expect( comments ).toHaveLength( 0 );
	} );
} );

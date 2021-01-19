/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.toolbar=[
        ['Copy','Cut','Paste','Preview','Table','Link','Unlink','TextColor','BGColor','Font','FontSize'],'/',
            ['Bold', 'Italic','Underline','Strike','Image', 'Smiley','Flash','Source','HorizontalRule','SpecialChar',
             'JustifyLeft','JustifyCenter','JustifyRight']
    ];
};
CKEDITOR.config.removePlugins = 'elementspath';



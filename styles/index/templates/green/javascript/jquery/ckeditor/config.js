/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
       config.htmlEncodeOutput = false;
       config.entities = false;
       config.startupFocus = true;
       config.skin          = 'moono_blue';
       config.uiColor       = '#0662B5';
       config.preset        = 'full';
       config.toolbar = [
            [ 'Bold','Italic','Underline','Strike','-' ],
            [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            [ 'Blockquote','TextColor','ShowBlocks' ],
            [ 'Link','Unlink' ],
            [ 'Image','HorizontalRule','Smiley' ]
       ];
       config.width = 520;
       config.height = 150;
};

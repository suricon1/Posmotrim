CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

    //  включить SpellChecker
    config.disableNativeSpellChecker = false;

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		//{ name: 'forms' },
        //{ name: 'Table' },
		{ name: 'tools' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi'] },
		{ name: 'styles',      groups: [ 'Format' ] },
		//{ name: 'colors' },
		{ name: 'about' }
	];
	//
	// config.toolbar = 'MyToolbar';
	//
	config.toolbar_InlineToolbar =
		[
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
            { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            //'/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
            { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
            //'/',
            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            { name: 'others', items: [ '-' ] },
            { name: 'about', items: [ 'About' ] }

		];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;h4;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

    //	Маршрут php загрузчика фото на сервере
	config.filebrowserUploadUrl = '/admin/ckeditor-upload-image';

	//config.extraPlugins = 'youtube';
	//config.extraPlugins = 'iframe';

	config.extraPlugins = 'div';
    //config.extraPlugins = 'forms';
    //config.extraPlugins = 'table';


	/*	Разрешенные тэги и атрибуты. */
	/*	https://ckeditor.com/docs/ckeditor4/latest/guide/dev_allowed_content_rules.html */
	//config.allowedContent = true;
	config.allowedContent =
		'h1 h2 h3 h4 h5 h6 p blockquote strong em pre thead tbody tr th td caption;' +
		'div(*);' +
		'ol(*);' +
		'ul(*);' +
		'li(*);' +
		'a[!href, rel];' +
		'iframe(*)[!src];' +
        'table(*);' +
		'img(left,right)[!src,alt]{float, width, height};';

    //config.extraAllowedContent = 'table tbody tr td;';

	/*	Запрещенные тэги и атрибуты (имеют приоритет над разрешенными). */
	/*	https://ckeditor.com/docs/ckeditor4/latest/guide/dev_disallowed_content.html */
	//config.disallowedContent = 'style span';  ё

    //config.height = '600px';
};

// $(function () {
//     CKEDITOR.replace('lit', {
//         filebrowserUploadUrl: "{{ route('uploader') }}",
//         toolbar : [
// 			{name: 'img', items: ['Image']},
// 		]
// 	});
// });

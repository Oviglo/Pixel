// Import du fichier SCSS
require('./scss/main.scss')

import tinymce from 'tinymce'
require('../node_modules/tinymce/models/dom/index')
require('../node_modules/tinymce/themes/silver/index')
require('../node_modules/tinymce/icons/default/index')

require ('tinymce/skins/content/default/content')
require ('tinymce/skins/ui/oxide/content')
require ('tinymce/skins/ui/oxide/skin')

tinymce.init({
    selector: 'textarea.wysiwyg'
})
